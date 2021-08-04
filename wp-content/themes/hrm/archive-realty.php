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
			<div class="wrapper-realty">
				<header class="entry-header">
					<div class="product-title">
						<div class="title">
							<h1 class="entry-title">
								<?php
									$tinh =get_term_by( 'slug', $_POST['quick-city'], 'city-realty' );
									$quan =get_term_by( 'slug', $_POST['quick-district'], 'city-realty' );
									$title = get_the_archive_title();
									if ($tinh && !($quan)) {
										echo $title->name .' tại ' .$tinh->name;
									} elseif ($quan && $tinh) {
										echo $title->name .' tại ' .$quan->name .' tỉnh '  .$tinh->name;
									} else {
										echo $title;
									}
								?>
							</h1>
						</div>
					</div>
				</header><!-- .entry-header -->
				<div class="lblsearchresult">
					<span class="spancount">
						<?php _e( '.Có' ,'hrm' ); ?>
						<b><?php echo wp_count_posts( 'realty' )->publish; ?></b>
						<?php _e( 'bất động sản được tìm thấy', 'hrm' ); ?>
					</span>
				</div>
				<div class="tab" id="tabList">
		        	<?php get_template_part( 'lib/admin/filter-select' ); ?>
			    </div>
				<div class="list-realty">
					<ul>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/content-archive', 'realty' );	?>
						<?php endwhile; ?>
					</ul>
				</div>
				<div class="hrm-pagenavi">
					<?php hrm_pagination(); ?>
				</div>
			</div>
			<?php

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
