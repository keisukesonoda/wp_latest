<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $meta = get_meta_info(); ?>
  <title><?php echo $meta['title']; ?></title>
  <meta name="description" content="<?php echo $meta['description']; ?>">
  <?php if ( $meta['keywords'] ) : // keywordsは入力がなければ不要 ?>
    <meta name="keywords" content="<?php echo $meta['keywords']; ?>">
  <?php endif; ?>
  <meta name="viewport" content="width=device-width">

  <?php // OG ?>
  <?php $og_type = is_home() ? 'website' : 'article'; ?>
  <meta property="og:type" content="<?php echo $og_type; ?>">
  <meta property="og:title" content="<?php echo $meta['og-title']; ?>">
  <meta property="og:description" content="<?php echo $meta['og-description']; ?>">
  <meta property="og:url" content="<?php echo $meta['url']; ?>">
  <meta property="og:image" content="<?php echo $meta['og-image']; ?>">

  <?php // favicon ?>
  <!-- <link rel="shortcut icon" href="<?php // echo get_template_directory_uri(); ?>/favicon.ico" /> -->

  <?php global $UA; $UA = get_userAgent(); ?>
  <?php // style sheets ?>
  <?php if ( !$UA['SP'] ) : ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" media="all">
  <?php else: ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.sp.css" media="all">
  <?php endif; ?>

  <?php // scripts ?>
  <?php wp_deregister_script( 'jquery' ); ?>
  <?php wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), '3.3.1', true ); ?>
  <?php wp_enqueue_script( 'main', get_template_directory_uri().'/js/main.js', array( 'jquery' ), '1.0', true ); ?>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

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
