<?php
/**
 * Template name: Tin VIP
 */

get_header(); ?>
<div id="primary" class="content-area col-md-9">
	<main id="main" class="site-main" role="main">

		<?php
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = array(
			'post_type'      => 'realty',
			'posts_per_page' => get_option( 'posts_per_page' ),
			'post_status'    => 'publish',
			'meta_key'       => 'vip_type', 
			'meta_value'     => '1', 
			'paged'          => $paged,
		);
		$query = new WP_Query ( $args );
		if ( have_posts() ) : ?>
			<div class="wrapper-realty">
				<header class="entry-header clearfix">
					<div class="product-title">
						<div class="title">
							<h1 class="entry-title"><?php the_title() ?></h1>
						</div>
					</div>
				</header><!-- .entry-header -->
				<div class="list-realty clearfix">
					<ul>

						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
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
