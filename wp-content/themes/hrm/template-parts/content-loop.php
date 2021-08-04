<?php if ( ! have_posts() ) : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php

else : 
	global $hrm_options;
	global $loop_layout;
	
	if( empty( $loop_layout ) )
		$loop_layout = $hrm_options['archive-default-layout'];
	
	if( $loop_layout == 'full_thumb' ){
	
		get_template_part( 'lib/loops/loop-wide-featured' );
		
	}
	elseif( $loop_layout == 'content' ){
	
		get_template_part( 'lib/loops/loop-content' );
		
	}
	elseif( $loop_layout == 'masonry' ){
	
		get_template_part( 'lib/loops/loop-masonry' );
		
	}
	else{
	
		get_template_part( 'lib/loops/loop-default' );

	}

endif;
?>