<?php
/**
 * Template Name: Tìm kiếm BĐS
 */
global $hrm_options;
get_header(); ?>

	<section id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
			<?php get_template_part('template-parts/result-search/search' , 'realty') ?>
		</main><!-- #main -->
	</section><!-- #primary -->
	<?php get_sidebar(); ?>
<?php
get_footer();
