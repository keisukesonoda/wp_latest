<?php
/**
 * 基本設定・どの案件でも使用する関数
 */
require_once dirname(dirname(__FILE__)) . '/' . get_stylesheet() .'/functions/general.php';

/**
 * カスタムポストタイプ ACF定義
 */
require_once dirname(dirname(__FILE__)) . '/' . get_stylesheet() .'/functions/cptg-acf.php';

/**
 * ACFオプション設定
 */
if ( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' => 'サイト設定',
    'menu_title' => 'サイト設定',
    'menu_slug' => 'theme-general-settings',
    'capability' => 'edit_posts',
    'redirect'   => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => '一覧ページSNS設定',
    'menu_title'  => '一覧ページSNS設定',
    'parent_slug' => 'theme-general-settings',
    'menu_slug'   => 'sns-settings',
    'capability'  => 'manage_options',
  ));

  // acf_add_options_sub_page(array(
  //   'page_title'  => 'ページ設定',
  //   'menu_title'  => 'ページ設定',
  //   'parent_slug' => 'theme-general-settings',
  //   'menu_slug'   => 'top-settings',
  //   'capability'  => 'manage_options',
  // ));
}


/**
 * ログイン画像変更
 */
function login_logo_image() {
  echo '<style type="text/css">
    #login h1 a {
    width: 140px;
    height: 92px;
    background: url(' . get_template_directory_uri() . '/images/logo_header.png) no-repeat !important;
    background-size: cover !important;
    }
  </style>';
}
// add_action('login_head', 'login_logo_image');


/**
 * ログイン画像URL変更
 */
function login_logo_url() {
  return home_url();
}
// add_filter('login_headerurl', 'login_logo_url');

/**
 * ログイン画像title変更
 */
function login_logo_title(){
  return get_bloginfo('name');
}
// add_filter('login_headertitle','login_logo_title');


/**
 * エディタにスタイルシートを適用
 */
function theme_add_editor_styles(){
  add_editor_style( array(
    'style.css',
    'editor-style.css'
  ));
}
add_action('after_setup_theme', 'theme_add_editor_styles');



/* -----------------------------------
* 認証関連
----------------------------------- */
/**
 * Google Map API Keyの登録
 */
function my_acf_init() {
  acf_update_setting('google_api_key', '');
}
// add_action('acf/init', 'my_acf_init');



/* -----------------------------------
* フロント独自関数
----------------------------------- */
/**
 * Hook: pre_get_posts
 */
function custom_main_query( $query ) {
  if ( is_admin() || !$query->is_main_query() ) return;

  /**
   *
   */
  // if ( $query->is_post_type_archive() ) {
  //   $query->set('posts_per_page', '2');
  // }
}
// add_action( 'pre_get_posts', 'custom_main_query' );


/**
 * 特定のページで404ページを返す
 */
function status404() {
  global $wp_query;

  // 詳細ページを404にするポストタイプ
  $disable_post_types = array(
    'mainvisual',
    // 'banner',
  );
  // 外部リンク指定してる投稿は404
  $post_type = get_query_var('post_type');
  $is_disable = is_singular() && in_array($post_type, $disable_post_types);
  // 外部リンク指定してる投稿も404
  $disable_post = is_singular() && get_field('link-outside');

  if ( is_attachment() || $is_disable || $disable_post ) {
    $wp_query->set_404();
    status_header(404);
  }
}
add_action('template_redirect', 'status404');


/**
 * アイキャッチ部分に説明文追加
 */
function add_featured_image_instruction( $content ) {
  $post_type = get_post_type();
  switch ($post_type) {
    // ニュース
    case 'news': $content .= '<span>size: 332 × 332</span>'; break;
    // case 'product-en': $content .= '<span>size: 320 × 240</span>'; break;
    // // スペシャル
    // case 'special': $content .= '<span>size: 320 × 320</span>'; break;
    // // お買い物
    // case 'shopping': $content .= '<span>size: 1080 × 320</span>'; break;
    // // キットカットを知る
    // case 'about': $content .= '<span>size: 1080 × 320</span>'; break;
    default:  break;
  }
  return $content;
}
add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction');




?>
