<?php
global $hrm_options;
$enabled_related = $hrm_options['enabled-related'];

get_header(); ?>
	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', get_post_format() );
		endwhile; // End of the loop.
		?>
		</main><!-- #main -->
		<?php if ( is_single() && $enabled_related ) : ?>
			<div class="related-post">
				<?php hrm_recent_post_category(); ?>
			</div><!-- .related-post -->
		<?php endif; ?>

	</div><!-- #primary -->
    <?php get_sidebar(); ?>
<?php
get_footer();
