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
    'page_title' => 'ヘッダ設定',
    'menu_title' => 'header',
    'parent_slug'=> 'theme-general-settings'
  ));

  acf_add_options_sub_page(array(
    'page_title' => 'フッタ設定',
    'menu_title' => 'footer',
    'parent_slug'=> 'theme-general-settings'
  ));
}

/**
 * Hook: pre_get_posts
 */
function custom_main_query( $query ) {
  if ( is_admin() || !$query->is_main_query() ) return;

  /**
   * 
   */
  if ( $query->is_post_type_archive() ) {

  }
}
add_action( 'pre_get_posts', 'custom_main_query' );


/**
 * Add Editor Styles
 */
function theme_add_editor_styles(){
  add_editor_style( array(
    'style.css',
    'editor-style.css'
  ));
}
add_action('after_setup_theme', 'theme_add_editor_styles');



/*
* User Define functions
*/

/**
 * Google Map API Keyの登録
 */
function my_acf_init() {
  acf_update_setting('google_api_key', 'AIzaSyA67wAaMVxSlZu5n75TO8hLCWXGkEVI2r4');
}
// add_action('acf/init', 'my_acf_init');


/**
 * 特定のページで404ページを返す
 */
function status404() {
  global $wp_query;

  if ( is_attachment() ) {
    $wp_query->set_404();
    status_header(404);
  }
}
add_action('template_redirect', 'status404');



?>
