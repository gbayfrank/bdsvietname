<div class="post-listing archive-box">
<?php while ( have_posts() ) : the_post(); ?>

	<article class="item-list">

		<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>
		<div class="post-thumbnail single-post-thumb archive-wide-thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'full' ); ?>
			</a>
		</div>
		<div class="clear"></div>
		<?php endif; ?>

		<h2 class="post-box-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<?php get_template_part( 'lib/loops/meta-archive' ); ?>

		<div class="entry">
			<p><?php echo wp_trim_words( get_the_content() ,40 ,'...' ); ?></p>
			<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More &raquo;', 'hrm' ) ?></a>
		</div>
		<div class="clear"></div>
	</article><!-- .item-list -->

<?php endwhile;?>
</div>
