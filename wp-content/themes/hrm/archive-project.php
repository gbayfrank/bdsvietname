<?php
/**
 * @package hrm
 */

get_header(); ?>
	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
		
		<?php if ( have_posts() ) : ?>

			<header class="entry-header">
				<?php
					the_archive_title( '<h1 class="entry-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="list-blog clearfix">
				<div class="post-listing archive-project-list archive-box masonry-grid">
					<div class="row">
						<?php while ( have_posts() ) : the_post(); ?>
							<div class="col-md-4 col-sm-4 col-xs-6 project-wrap-item">
							<?php get_template_part( 'template-parts/item-du-an');	?>
							</div>
						<?php endwhile;?>
					</div>
				</div>
			</div>
			
			<div class="hrm-pagenavi">
				<?php hrm_pagination(); ?>
			</div>

		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
