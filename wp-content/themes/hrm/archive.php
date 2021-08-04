<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hrm
 */

get_header(); ?>
	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
		
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="list-blog">
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
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
