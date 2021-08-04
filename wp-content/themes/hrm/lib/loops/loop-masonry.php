<div class="post-listing archive-box masonry-grid">
	<div class="row">
		<?php while ( have_posts() ) : the_post(); ?>

			<article class="col-md-6 item-masory">
				<div class="box-masory">
			
					<h2 class="post-box-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					
					<?php get_template_part( 'lib/loops/meta-archive' ); ?>					

					
					<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>	
					
					<div class="post-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('post-news');  ?>
						</a>
					</div><!-- post-thumbnail /-->
					
					<?php endif; ?>
						
					<div class="entry">
						<p><?php hrm_excerpt() ?></p>
						<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Xem thêm &raquo;' ) ?></a>
					</div>		
					<div class="clear"></div>
				</div>
			</article><!-- .item-list -->
			
		<?php endwhile;?>
	</div>
</div>
