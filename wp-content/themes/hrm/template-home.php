<?php
/**
 * Template name: Home
 */

get_header(); ?>
	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
			<?php if(is_active_sidebar('content-home')) : ?>
				<?php dynamic_sidebar('content-home' ); ?>
			<?php endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<aside id="secondary" class="widget-area col-md-3" role="complementary">
		<?php dynamic_sidebar( 'widget-trangchu' ); ?>
	</aside><!-- #secondary -->

<?php
get_footer();
