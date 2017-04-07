<?php
$sample_args = array(
  'post_type' => 'sample',
  // 'post_type' => array('sample', 'post', 'page'),
  'posts_per_page' => -1,
);
$sample_query = new WP_Query($sample_args);
$sample_posts = get_posts($sample_args);

$posts_args = array(
  'public' => true,
  '_builtin' => false
);

$post_types = get_post_types($posts_args, 'object');
?>

<?php get_header(); ?>
<div class="contents line mt5 container">

  <div class="loops">
    <h2 class="fsp4 b">ワードプレスループ</h2>

    <div class="main-query mt6">
      <h3 class="fsp2 b">メインクエリ</h3>
      <?php if (have_posts() ) : ?>
        <ul>
        <?php while (have_posts()) : the_post(); ?>
          <li class="mt2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
        </ul>
      <?php else : ?>
        <p class="mt2">Not Found.</p>
      <?php endif; ?>
    </div><!-- /main-query -->

    <div class="wp-query mt6">
      <h3 class="fsp2 b">wp query</h3>
      <?php if( $sample_query->have_posts() ) : ?>
        <ul>
        <?php while ( $sample_query->have_posts() ) : $sample_query->the_post(); ?>
          <li class="mt2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      <?php endif; ?>
    </div><!-- /wp-query -->

    <div class="get_posts mt6">
      <h3 class="fsp2 b">get posts</h3>
      <?php if( !empty( $sample_posts ) ) : ?>
        <ul>
        <?php foreach( $sample_posts as $post ) : setup_postdata( $post ); ?>
          <li class="mt2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endforeach; wp_reset_postdata(); ?>
        </ul>
      <?php else : ?>
        <p class="mt2">Not Found.</p>
      <?php endif; ?>
    </div><!-- /get_posts -->
  </div>
  <!-- /loops -->


  <div class="archive mt10">
    <h2 class="fsp4 mb2 b">カスタム投稿タイプ アーカイブ</h2>

    <?php foreach( $post_types as $post_type => $post_typeInfo ) : ?>
      <?php $arc_link = get_post_type_archive_link($post_type); ?>
      <ul>
        <li><a href="<?php echo $arc_link ?>"><?php echo $post_type; ?></a></li>
      </ul>
    <?php endforeach; ?>
    <?//php  ?>
  </div><!-- /archive -->


  <div class="include mt10">
    <?php get_template_part('parts/content', 'button'); ?>
  </div>

</div>
<!-- /contents -->
<?php get_footer(); ?>
