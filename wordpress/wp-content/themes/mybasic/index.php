<?php get_header(); ?>
<div class="contents line mt5 container">

	<?php if (have_posts() ) : ?>
		<div class="main-query mt4">

			<?php while (have_posts()) : the_post(); ?>
				<h2><?php the_title(); ?></h2>
				<div class="mt5 editor"><?php the_content(); ?></div>
			<?php endwhile; ?>

		</div><!-- /main-query -->
	<?php else : ?>
		<p>Not Found.</p>
	<?php endif; ?>

</div><!-- /contents -->

<?php get_footer(); ?>
