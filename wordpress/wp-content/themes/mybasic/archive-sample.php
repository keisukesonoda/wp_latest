<?php
$taxes = get_tax_terms();
$sample_terms = $taxes['sample-tax']['terms'];

$term_slugs = array();
foreach( $sample_terms as $sample_term ){
  $term_slugs[] = $sample_term['slug'];
}

// sample-taxタクソノミー内のタームに紐付いた投稿は除外
$args = array(
  'post_type' => 'sample', 
  'posts_per_page' => -1,
  'tax_query' => array( 
    array(
      'taxonomy'=>'sample-tax',
      'terms' => $term_slugs,
      'field'=>'slug',
      'operator'=>'NOT IN'
    ),
  )
);

$query = new WP_Query($args);
?>


<?php get_header(); ?>
<div class="contents line mt5 container">

  <div class="main-query mt4">
    <?php if( $query->have_posts() ) : ?>
      <ul>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
    <?php else : ?>
      Not Found.
    <?php endif; ?>
  </div>
  <!-- /main-query -->

</div>
<!-- /contents -->
<?php get_footer(); ?>




