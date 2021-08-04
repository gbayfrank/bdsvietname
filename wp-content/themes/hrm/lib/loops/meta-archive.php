<?php  
	global $hrm_options;
	$show_meta = $hrm_options['arc_show_meta'];
	$meta_author = $hrm_options['arc_meta_author'];
	$meta_date = $hrm_options['arc_meta_date'];
	$meta_cate = $hrm_options['arc_meta_cats'];
?>
<?php if( $show_meta ): ?>
	<p class="post-meta">
		<?php if( $meta_author ): ?>		
			<span class="post-meta-author"><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title=""><?php echo get_the_author() ?> </a></span>
		<?php endif; ?>	
		<?php if( $meta_date ): ?>	
			<span class="post-date">
				<i class="fa fa-clock-o"></i><?php echo get_the_time('d/m/Y'); ?>
			</span>	
		<?php endif; ?>	
		<?php if( $meta_cate  && get_post_type( get_the_ID() ) == 'post' ): ?>
			<span class="post-cats"><i class="fa fa-folder"></i><?php printf('%1$s', get_the_category_list( ', ' ) ); ?></span>
		<?php endif; ?>	
	</p>
<?php endif; ?>
