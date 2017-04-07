<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $meta = get_meta_info(); ?>
  <title><?php echo $meta['title']; ?></title>
  <meta name="description" content="<?php echo $meta['description']; ?>">
  <meta name="keywords" content="<?php echo $meta['keywords']; ?>">
  <meta name="viewport" content="width=device-width">

  <!-- OG -->
  <?php $og_type = is_home() ? 'website' : 'article'; ?>
  <meta property="og:title" content="<?php echo $meta['title']; ?>">
  <meta property="og:type" content="<?php echo $og_type; ?>">
  <meta property="og:url" content="<?php echo $meta['url']; ?>">
  <meta property="og:image" content="<?php echo $meta['og_image']; ?>">

  <!-- favicon -->
  <!-- <link rel="shortcut icon" href="<?php // bloginfo('template_url'); ?>/favicon.ico" /> -->

  <!-- style sheets -->
  <link id="sp-style" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.sp.css" media="screen and (max-width: 767px)">
  <link id="pc-style" rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen and (min-width: 768px)">

  <!-- scripts -->
  <?php wp_deregister_script( 'jquery' ); ?>
  <?php wp_enqueue_script( 'init', get_bloginfo('template_url').'/js/init.js', array(), '1.0.0', false ); ?>
  <?php wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), '1.11.3', true ); ?>
  <?php wp_enqueue_script( 'main', get_bloginfo('template_url').'/js/main.js', array( 'jquery' ), '1.0', true ); ?>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-temp="<?php bloginfo('template_url'); ?>">

  <div class="wrapper">

    <header id="header" class="header">
      <div class="container">
        <h1 class="site-title fsp10 b"><a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <p class="site-description"><?php bloginfo( 'description' ); ?></p>
      </div>

      <?php wp_nav_menu( array(
        'menu' => 'gnav',
        'menu_class' => 'container',
      )); ?>
    </header>
