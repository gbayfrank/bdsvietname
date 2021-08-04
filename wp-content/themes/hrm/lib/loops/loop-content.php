<div class="post-listing">
	<?php while ( have_posts() ) : the_post(); ?>
		<article class="item-list">
			<h2 class="post-box-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<?php get_template_part( 'lib/loops/meta-archive' ); ?>					
			<div class="entry">
				<?php the_content( _e( 'Xem thêm &raquo;' ) ); ?>
			</div>
			<div class="clear"></div>
		</article><!-- .item-list -->

	<?php endwhile;?>
</div>
