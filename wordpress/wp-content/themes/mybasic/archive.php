<?php get_header(); ?>
<div class="contents line mt5 container">

	<div class="main-query mt4">
		<?php if (have_posts() ) : ?>
			<ul>
			<?php while (have_posts()) : the_post(); ?>
				<li class="mt2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
			</ul>
		<?php endif; ?>
	</div>
	<!-- /main-query -->

</div>
<!-- /contents -->
<?php get_footer(); ?>




