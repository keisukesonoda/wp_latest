
<?php
/*
* Support Wordpress Native functions
*/

// support menu
add_theme_support('menus');

// support thumbnail
add_theme_support('post-thumbnails');

// support widgets
if ( function_exists('register_sidebar') ) register_sidebar(array('id'=>'sidebar-1'));


/*
* テンプレート名表示
*/
function get_template_name() {
  global $template;
  $template_name = basename($template);
  echo $template_name;
}


/**
 * pagination
 * @param mixd $args
 * @return none
 */
function get_pagination( $args = null ) {
  global $wp_rewrite, $wp_query, $paged;

  $defaults = array(
    'container_class' => 'pagination',
    'prev_text' => '&laquo; Back',
    'next_text' => 'Next &raquo;',
  );
  $r = wp_parse_args( $args, $defaults );

  $paginate_base = get_pagenum_link( 1 );
  if ( strpos($paginate_base, '?' ) || ! $wp_rewrite->using_permalinks() ) {
    $paginate_format = '';
    $paginate_base = add_query_arg( 'paged', '%#%' );

    $tmp = $paginate_base;
    $tmp = preg_replace( "/\&paged\=\%\#\%/", "", $tmp);
    $tmp = preg_replace( "/\/page\/[0-9]+/", "", $tmp);

    $tmp = preg_match( "/^(?P<fst>.*)(?P<sec>\?.*)$/", $tmp, $matches);
    $paginate_base = $matches["fst"] .'page/%#%/' . $matches["sec"];

  } else {
    $paginate_format = ( substr($paginate_base, -1 ,1) == '/' ? '' : '/' ) .user_trailingslashit('page/%#%/', 'paged');
    $paginate_base .= '%_%';
  }


  $total = isset($r['query']) ? $r['query']->max_num_pages : $wp_query->max_num_pages;

  $pagination = array(
    'base' => $paginate_base,
    'format' => $paginate_format,
    'total' => $total,
    'mid_size' => 5,
    'current' => ($paged ? $paged : 1),
    'prev_text' => $r['prev_text'],
    'next_text' => $r['next_text'],
    'prev_next' => false,
  );
  $tmp_format = str_replace( "/page/1/", "/", paginate_links($pagination));
  if( !empty($tmp_format) ) {
    echo '<div class="'.$r['container_class'].'"><div class="inner">'. $tmp_format .'</div></div>';
  }
}


/**
 * 短縮文字列
 * @param  string 元の文字列, integer 短縮する文字数
 * @return string 短縮した文字列
 */
function get_substring($org = '', $outlen = 60) {
  $replace = str_replace(array("\r\n", "\r", "\n"), '', strip_tags($org));
  $orglen = mb_strlen($replace);

  $str = $orglen > $outlen ? mb_substr($replace, 0, $outlen - 1) . '...' : $org;

  return $str;
}


/**
 * 短縮文字列
 * @param  $content string content
 * @param  $max     number 最大文字数
 * @param  $tag     string 許可するタグ
 * @return $result  string 短縮した文字列
 */
function get_my_excerpt_content($content = '', $max = 200, $tag = '') {
  if (!$content) return;

  if( mb_strlen($content, 'UTF-8' ) > $max) {
    $content = mb_substr(strip_tags($content, $tag), 0, $max, 'UTF-8');
    $result = $content . '...';
  } else {
    $result = strip_tags($content, $tag);
  }

  return $result;
}


/**
 * パンくずナビ
 * @return array パンくず
*/
function get_breadcrumbs() {
  if ( is_home() ) return array();
  global $wp_query;
  $breadcrumbs = array(
    array(
      'title' => 'TOP',
      'url' => home_url(),
    ),
  );

  if ( is_page() ) {
    $post_obj = $wp_query->get_queried_object();
    // 親ページがない（一番上のページ）
    if ( $post_obj->post_parent == 0 ) {
      array_push($breadcrumbs, array(
        'title' => get_the_title(),
        'url' => get_permalink(),
      ));
    } else {
      // 現在の記事の親IDを取得＆並べ替え
      $ancestors = array_reverse(get_post_ancestors( $post_obj->ID ));
      // 自分のIDを最後に挿入
      array_push($ancestors, $post_obj->ID);
      // 配列に格納
      foreach( $ancestors as $id ) {
        array_push($breadcrumbs, array(
          'title' => get_the_title($id),
          'url' => get_permalink($id),
        ));
      }
    }
  } // end is_page

  if(is_post_type_archive() ){
    // カスタム投稿名取得
    $post_obj = $wp_query->get_queried_object();
    $post_type = get_query_var( 'post_type' );

    array_push($breadcrumbs, array(
      'title' => $post_obj->label,
      'url' => get_post_type_archive_link($post_type),
    ));
  } //end post type archive

  if( is_single()) {
    $post_type = get_query_var('post_type');
    $post_obj  = get_post_type_object($post_type);

    if( $post_type == '' ) {
      // デフォルト投稿
      array_push($breadcrumbs, array(
        'title' => get_the_title(),
        'url' => get_permalink(),
      ));
    } else {
      // アーカイブページ
      array_push($breadcrumbs, array(
        'title' => $post_obj->label,
        'url' => get_post_type_archive_link(get_query_var('post_type')),
      ));
      // 現在のページ
      array_push($breadcrumbs, array(
        'title' => get_the_title(),
        'url' => get_permalink(),
      ));
    }
  }// end is_single

  if ( is_category() ) {
    // アーカイブページ
    $my_category = get_the_category();
    $my_category = !empty($my_category) ? $my_category[0] : $my_category;
    array_push($breadcrumbs, array(
      'title' => esc_html($my_category->name),
      'url' => esc_html(get_term_link($my_category->term_id)),
    ));
  }

  if ( is_tag() ) {
    $my_tag = get_the_tags();
    $my_tag = !empty($my_tag) ? $my_tag[0] : $my_tag;
    array_push($breadcrumbs, array(
      'title' => esc_html($my_tag->name),
      'url' => esc_html(get_term_link($my_tag->term_id)),
    ));
  }


  if( is_tax() ){
    // ターム情報を取得
    $terms     = $wp_query->queried_object;
    $taxonomy  = get_query_var('taxonomy');
    $myterm    = get_term_by('slug', get_query_var('term'), $taxonomy);
    $post_type = get_taxonomy($taxonomy)->object_type[0];
    $post_obj  = get_post_type_object($post_type);

    // アーカイブ
    array_push($breadcrumbs, array(
      'title' => $post_obj->label,
      'url' => get_post_type_archive_link($post_type),
    ));
    // タクソノミー
    array_push($breadcrumbs, array(
      'title' => esc_html($myterm->name),
      'url' => get_term_link($myterm->term_id),
    ));
  } // end is_tax

  if( is_search() ) {
    $s = isset($_GET['s']) ? $_GET['s'] : null;
    array_push($breadcrumbs, array(
      'title' => $s ? $s.'を含む検索結果' : '検索結果',
      'url' => '',
    ));
  }
  return $breadcrumbs;
}


/**
 * meta情報の取得
 * @return array meta info
*/
function get_meta_info() {
  global $wp_query;

  $sep = ' | ';
  $meta_title = get_field('sitename', 'options') ? get_field('sitename', 'options') : get_bloginfo('name');
  $description = get_field('description', 'options') ? get_field('description', 'options') : get_bloginfo('description');
  $keywords = get_field('keywords', 'options') ? get_field('keywords', 'options') : '';
  // グローバルOG Image
  $glb_og = get_field('og-image', 'options') ? get_field('og-image', 'options') : array();
  $glb_og = !empty($glb_og) ? $glb_og['url'] : get_bloginfo('template_url').'/images/noimage.jpg';
  // オリジナルOG Image
  $org_og = get_field('og-image') ? get_field('og-image') : array();
  $og_image = !empty($org_og) ? $org_og['url'] : $glb_og;

  // デフォルト（ホーム・アーカイブ）
  $meta = array(
    'title' => wp_title($sep, false, 'right') . $meta_title,
    'description' => $description,
    'keywords' => $keywords,
    'og_image' => $og_image,
    'url' => get_my_url(),
  );

  if ( is_page() ) {
    $post_obj = $wp_query->get_queried_object();

    if ( $post_obj->post_parent != 0 ) {
      // 親ページがある場合
      $parent_title = get_the_title($post_obj->post_parent);
      $title = get_the_title();
      $meta['title'] = $title. $sep .$parent_title. $sep .$meta_title;
    }
  } // end is_page

  if( is_single()) {
    $post_type = get_query_var('post_type');
    $post_obj  = get_post_type_object($post_type);

    if( $post_type != '' ) {
      $meta['title'] = get_the_title().$sep.$post_obj->label.$sep.$meta_title;
    }
  }// end is_single

  if( is_tax() ){
    // カスタムタクソノミーページ
    // ターム情報を取得
    $terms     = $wp_query->queried_object;
    $taxonomy  = get_query_var('taxonomy');
    $myterm    = get_term_by('slug', get_query_var('term'), $taxonomy);
    $post_type = get_taxonomy($taxonomy)->object_type[0];
    $post_obj  = get_post_type_object($post_type);
    // アーカイブ
    $meta['title'] = esc_html($myterm->name). $sep .$post_obj->label . $sep .$meta_title;
  } // end is_tax

  if( is_search() ) {
    // 検索結果
    $s = isset($_GET['s']) ? $_GET['s'] : null;
    $meta['title'] = $s. $sep .'検索結果'. $sep .$meta_title;
  }

  return $meta;
}


/**
 * URLフィールドからhrefを含むリンクを出力
 * @param  txt url文字列
 * @return txt hrefを含むurl文字列
*/
function get_acf_href($txt = '') {
  $href = $txt !== '' ? 'href="'. $txt .'"' : '';
  return $href;
}


/**
 * target判別
 * @param  num 0 or 1
 * @return txt target文字列
*/
function get_acf_target($num = 0) {
  $target = $num ? '_blank' : '_self';
  return $target;
}


/**
 * 画像フィールドからパス取得（ない場合はnoimg）
 * @param  ary 画像フィールド
 * @return txt 画像パス
*/
function get_acf_imagePath($ary = array()) {
  $path = get_bloginfo('template_url').'/images/noimage.jpg';
  $path = !empty($ary) ? $ary['url'] : $path;

  return $path;
}


/**
 * 画像IDからパス取得（ない場合はnoimg）
 * @param  num 画像ID
 * @return txt 画像パス
*/
function get_id_imagePath($id = '') {
  $path = get_bloginfo('template_url').'/images/noimage.jpg';
  $path = $id !== '' ? wp_get_attachment_url($id) : $path;

  return $path;
}


/**
 * aタグのdisableクラス取得
 * @param  txt 上記関数で取得した文字列
 * @return txt disableクラス名
*/
function get_disable_class($result = '') {
  $disable = $result == '' ? 'disable' : '';
  return $disable;
}


/**
 * スラッグから固定ページURL取得
 * @return txt enjoyページのURL文字列
*/
function get_page_slug_link($slug = '') {
  if (!$slug) return;

  $page = get_page_by_path($slug) ? get_page_by_path($slug): array();
  $url = !empty($page) ? get_permalink($page->ID): '';

  return $url;
}


/**
 * $_SERVERからURLを取得
 * @return str URL
*/
function get_my_url() {
  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
  $host = $_SERVER['HTTP_HOST'];
  $request = $_SERVER['REQUEST_URI'];
  $search = $_SERVER['QUERY_STRING'];
  $path = str_replace('?'.$search, '', $request);
  $URL = $protocol . $host . $path;

  return $URL;
}


?>
