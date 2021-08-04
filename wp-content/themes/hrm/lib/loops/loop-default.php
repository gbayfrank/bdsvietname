<ul class="post-listing archive-box">
<?php while ( have_posts() ) : the_post(); ?>
	<li class="item-list">
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail('post-news');  ?>
				<?php else : ?>
					<img src="http://placehold.it/230x150">
				<?php endif; ?>
			</a>
		</div><!-- post-thumbnail /-->
		<div class="entry">
			<h2 class="post-box-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<p><?php echo wp_trim_words( get_the_content(),31,'.' ); ?></p>
		</div>
		<div class="clear"></div>
	</li><!-- .item-list -->
<?php endwhile;?>
</ul>
