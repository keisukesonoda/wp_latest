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

// acf options page
if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' => 'サイト設定',
		'menu_title' => 'サイト設定',
		'menu_slug'	=> 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect'	 => false
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
* Add Editor Styles
*/
function theme_add_editor_styles(){
	add_editor_style('editor-style.css');
}
add_action('after_setup_theme', 'theme_add_editor_styles');











/*
* User Define functions
*/

// is_first
function is_first(){
	global $wp_query;
	return ($wp_query -> current_post === 0);
}

// テンプレート名を表示
// ---------------------------------------
function get_template_name() {
	global $template;
	$template_name = basename($template);
	echo $template_name;
}



// タクソノミーとタームを取得
// ---------------------------------------
function get_tax_terms(){
	$taxes = array();

	$args = array(
		'public' => true,
		'_builtin' => false,
	);
	$output = 'objects';
	// $output = 'names';

	$taxonomies = get_taxonomies($args, $output);
	foreach( $taxonomies as $taxonomy => $details ){
		$terms = get_terms( $taxonomy );
		$postTypes = $details->object_type;
		if( $terms ) {
			$taxes[$taxonomy] = array();
			foreach( $terms as $term ) {
				$taxes[$taxonomy]['terms'][] = array(
					'name' => $term->name,
					'slug' => $term->slug,
					'link' => get_term_link($term->slug, $taxonomy),
				);
			} // foreach $terms
			foreach( $postTypes as $postType ) {
				$taxes[$taxonomy]['postTypes'][] = $postType;
			} // foreach $postTypes
		} // if $terms
	} // foreach $taxonomies
	return $taxes;
}



?>
