<?php
global $hrm_options;
get_header(); ?>
	<div id="primary" class="content-area blog-cate col-md-9">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<div class="title-cate">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</div>
			</header><!-- .page-header -->

			<div class="list-blog">
				<?php $loop_layout = $hrm_options['category-default-layout'];	?>
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
