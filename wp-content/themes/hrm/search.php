<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Ham_Rong_Media
 */
global $hrm_options;
get_header(); ?>

	<section id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Kết quả tìm kiếm với: %s', 'hrm' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->
			<div class="list-blog">
				<?php $loop_layout = $hrm_options['search-default-layout'];	?>
				<?php get_template_part( 'template-parts/content', 'loop' );	?>
		<?php
			echo '</div>';
			echo '<div class="hrm-pagenavi">';
				hrm_pagination();
			echo '</div>';
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
