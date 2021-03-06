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
  // グローバルサイトタイトル
  $meta_title = get_field('sitename', 'options') ?: get_bloginfo('name');
  // グローバルsnsタイトル
  $glb_sns_title = get_field('og-title', 'options') ?: $meta_title;
  // 記事個別SNSタイトル
  $sns_title = get_field('og-title') ?: $glb_sns_title;
  // wp_titleを含めた各タイトル
  $title = wp_title($sep, false, 'right') . $meta_title;
  $og_title = $sns_title . $sep . $meta_title;

  // グローバルサイトディスクリプション
  $description = get_field('description', 'options') ?: get_bloginfo('description');
  // グローバルSNSディスクリプション
  $glb_sns_description = get_field('og-description', 'options') ?: $description;
  // 記事個別SNSディスクリプション
  $og_description = get_field('og-description') ?: $glb_sns_description;

  // グローバルサイトキーワード
  $keywords = get_field('keywords', 'options') ?: '';

  // グローバルOG Image
  $glb_og_image = get_field('og-image', 'options') ?: array();
  $glb_og_image = !empty($glb_og_image) ? $glb_og_image['url'] : get_bloginfo('template_url').'/images/noimage.jpg';
  // オリジナルOG Image
  $org_og_image = get_field('og-image') ?: array();
  $og_image = !empty($org_og_image) ? $org_og_image['url'] : $glb_og_image;

  // オリジナルOG URL
  $og_url = get_field('og-url') ?: get_my_url();

  // デフォルト（ホーム）
  $meta = array(
    'title' => $title,
    'description' => $description,
    'keywords' => $keywords,
    'og-title' => $og_title,
    'og-description' => $og_description,
    'og-image' => is_home() ? $glb_og_image : $og_image,
    'url' => $og_url,
  );

  if ( is_page() ) {
    // 固定ページ
    $post_obj = $wp_query->get_queried_object();
    if ( $post_obj->post_parent != 0 ) {
      // 親ページがある場合
      $parent_obj = get_post($post_obj->post_parent);
      $parent_title = $parent_obj->post_title;
      $title = get_the_title();
      $meta['title'] = $title. $sep .$parent_title. $sep .$meta_title;
      if ( $parent_obj->post_parent != 0 ) {
        // 祖父ページがある場合
        $grand_obj = get_post($parent_obj->post_parent);
        $grand_title = $grand_obj->post_title;
        $title = get_the_title();
        $meta['title'] = $title. $sep .$parent_title. $sep. $grand_title. $sep .$meta_title;
      }
    }
  } // end is_page
  if ( is_archive() ) {
    // 投稿タイプアーカイブ
    $post_type = get_query_var('post_type');
    // アーカイブ独自のog設定取得
    if ( have_rows('post-type', 'options') ) {
      while ( have_rows('post-type', 'options') ) : the_row();
        // 表示している投稿タイプ名と一致したら配列に格納
        if ( $post_type == get_sub_field('post-type-name') ) {
          $meta['og-title'] = get_sub_field('og-title') ? get_sub_field('og-title') . $sep . $meta_title : $meta['title'];
          $meta['og-description'] = get_sub_field('og-description') ?: $meta['description'];
          // og:image
          $image = get_sub_field('og-image');
          $meta['og-image'] = !empty($image) ? $image['url'] : $meta['og-image'];
          // og:url
          $meta['url'] = get_sub_field('og-url') ?: $og_url;
          break;
        }
      endwhile;
    }
  }
  if( is_single()) {
    // 詳細ページ
    $post_type = get_query_var('post_type');
    $post_obj  = get_post_type_object($post_type);
    if( $post_type != '' ) {
      $meta['title'] = get_the_title() . $sep . $post_obj->label . $sep . $meta_title;
      $meta['og-title'] = $sns_title . $sep . $post_obj->label . $sep . $meta_title;
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
    $meta['title'] = esc_html($myterm->name) . $sep . $post_obj->label . $sep . $meta_title;
  } // end is_tax
  if( is_search() ) {
    // 検索結果
    $s = isset($_GET['s']) ? $_GET['s'] : null;
    $meta['title'] = $s . $sep . '検索結果' . $sep . $meta_title;
  }
  return $meta;
}


/**
 * URLフィールドからhrefを含むリンクを出力
 * @param  txt url文字列
 * @return ary hrefを含むurl文字列とtarget
*/
function get_acf_href($txt = '') {
  $href = $txt !== '' ? 'href="'. $txt .'"' : '';
  $result = array(
    'href' => $href,
    'activity' => !$href ? 'disable' : '',
  );
  return $result;
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


/**
 * 子階層を含めたメニューを返却する
 * @return array
*/
function get_nav_menus($nav_name = '') {
  global $UA;
  $navs = wp_get_nav_menu_items($nav_name);
  if ( !$nav_name || empty($navs) ) return;
  // 返却用の配列作成
  $result = array();
  foreach ( $navs as $nav ) {
    // トラッキング用のポジション取得
    $position = 'other';
    if ( strpos($nav_name, 'gnav') !== false ) $position = 'header';
    elseif ( strpos($nav_name, 'fnav') !== false ) $position = 'footer';

    // メニュー用カスタムフィールド値の取得（指定がなければmenuSubCategoryとeventLabelは同一）
    $menu_sub_category = $event_label = get_field('nav-menu-sub-category', $nav);
    if ( get_field('flg-origin-label', $nav) ) {
      // 独自のeventLabelを設定
      $event_label = get_field('nav-event-label', $nav);
      if ( get_field('flg-device-label', $nav) ) {
        // デバイス別のイベントラベル設定がある場合（ヘッダ）
        if ( !$UA['SP'] ) $event_label = get_field('nav-event-label-pc', $nav);
        else              $event_label = get_field('nav-event-label-sp', $nav);
      }
    }

    if ( $nav->menu_item_parent == 0 ) {
      // 親階層のメニューを取得・格納
      $type = 'wp-menu';
      switch ($nav->object) {
        case 'archive': $type = $type . '-post-type-'.$nav->type; break;
        case 'page': $type = $type . '-page'; break;
        case 'custom': $type = $type . '-custom'; break;
        default: $type = $type . '-other'; break;
      }
      $class = isset($nav->classes[1]) ? $nav->classes[0] . ' ' . $nav->classes[1] : $nav->classes[0];
      $result[$nav->ID] = array(
        'ID' => $nav->ID,
        'title' => $nav->title,
        'class' => $class,
        'url' => $nav->url,
        'target' => $nav->target,
        'type' => $type,
        'tracking' => array(
          'menu_category' => $position,
          'menu_sub_category' => $menu_sub_category,
          'event_label' => $event_label,
        ),
        'children' => array(),
      );
    } else {
      // 子階層のメニューを親階層の配列に格納
      $parent = $nav->menu_item_parent;
      $result[$parent]['children'][$nav->ID] = array(
        'ID' => $nav->ID,
        'title' => $nav->title,
        'class' => $nav->classes[0],
        'url' => $nav->url,
        'target' => $nav->target,
        'position' => $position,
      );
    }
  }
  return $result;
}


/**
 * アイキャッチの画像URL（なければnoimage）取得
 * @param post_id Int ID
 * @param size    Str (thumbnail, medium, large, full)
 */
function get_post_thumbnail_path($post_id, $size = 'full') {
  if ( !$post_id ) return;
  if (has_post_thumbnail($post_id) ) {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
    $path = $image[0];
  } else {
    $path = get_bloginfo('template_url').'/images/noimage.jpg';
  }
  return $path;
}


/**
 * 画像情報の取得
 */
function get_image_info($image) {
  if ( ctype_digit($image) ) {
    // 画像IDの場合
    $info = wp_get_attachment_image_src($image, 'full');
    $result = array(
      'url' => get_id_imagePath($image),
      'class' => $info[1] < $info[2] ? 'cover' : 'contain',
    );
  } elseif ( is_array($image) ) {
    // フィールドの場合
    $info = wp_get_attachment_image_src($image['id'], 'full');
    $result = array(
      'url' => get_acf_imagePath($image),
      'class' => $info[1] < $info[2] ? 'cover' : 'contain',
    );
  } elseif (!$image) {
    // 何も入って来なかった場合
    $result = array(
      'url' => get_bloginfo('template_url').'/images/noimage.jpg',
      'class' => 'contain',
    );
  }
  return $result;
}


/**
 * useragentの判別
 */
function get_userAgent() {
  $UA = strtolower($_SERVER['HTTP_USER_AGENT']);

  $result = array(
    'TAB' => strpos($UA, 'windows') !== false && strpos($UA, 'touch') !== false ||
           strpos($UA, 'android') !== false && strpos($UA, 'mobile') === false ||
           strpos($UA, 'firefox') !== false && strpos($UA, 'tablet') !== false ||
           strpos($UA, 'ipad') !== false ||
           strpos($UA, 'kindle') !== false ||
           strpos($UA, 'silk') !== false ||
           strpos($UA, 'playbook') !== false,
    'SP' => strpos($UA, 'windows') !== false && strpos($UA, 'phone') !== false ||
          strpos($UA, 'android') !== false && strpos($UA, 'mobile') !== false ||
          strpos($UA, 'firefox') !== false && strpos($UA, 'mobile') !== false ||
          strpos($UA, 'iphone') !== false ||
          strpos($UA, 'ipod') !== false ||
          strpos($UA, 'blackberry') !== false ||
          strpos($UA, 'bb') !== false,
    'AD' => strpos($UA, 'android') !== false,
    'WINDOWS' => strpos($UA, 'windows') !== false,
    'MAC' => strpos($UA, 'mac os') !== false,
    'CHROME' => strpos($UA, 'chrome') !== false && strpos($UA, 'edge') === false,
    'IE' => strpos($UA, 'MSIE') !== false ||
          strpos($UA, 'Trident/') !== false ||
          strpos($UA, 'Edge') !== false,
  );
  return $result;
}





?>
