<?php 
	function hrm_social_share( $postid ) { 
	global $post ,$hrm_options; 
	$share_face = $hrm_options['enabled-social-face'];
	$share_google = $hrm_options['enabled-social-google'];
	$share_twitter = $hrm_options['enabled-social-twitter'];
	$share_linkedIn = $hrm_options['enabled-social-linkedIn'];
	$share_pinterest = $hrm_options['enabled-social-pinterest'];

	$share_class = 'hrm-social-share';
?>
<div class="<?php echo $share_class ?>">
	<span class="share-text"><?php _e( 'Share This Story, Choose Your Platform!' , 'hrm' );?></span>
	<ul class="hrm-share">
		<?php if ($share_face) : ?>
            <li>
            	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink( $postid ); ?>" class="facebook" target="_blank">
            		<i class="fa fa-facebook"></i>
            		<span><?php _e( 'Facebook' ,'hrm' ); ?></span>
            	</a>
            </li>
		<?php endif; ?>

		<?php if ($share_google) : ?>
            <li>
                <a href="https://plus.google.com/share?url=<?php the_permalink( $postid ); ?>" class="google" target="_blank">
	                <i class="fa fa-google-plus"></i>
	                <span><?php _e( 'Google Plus', 'hrm' ); ?></span>
                </a>

            </li>
		<?php endif; ?>

		<?php if ($share_twitter) : ?>
            <li>
                <a href="https://twitter.com/home?status=<?php the_permalink( $postid ); ?>" class="twitter" target="_blank">
	                <i class="fa fa-twitter"></i>
	                <span><?php _e( 'Twitter' ,'hrm' ); ?></span>
                </a>
            </li>
		<?php endif; ?>

		<?php if ($share_linkedIn) : ?>
			<li>
				<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink( $postid ); ?>" class="linkedin" target="_blank">
					<i class="fa fa-linkedin"></i> 
					<span><?php _e( 'LinkedIn' , 'hrm' );?></span>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($share_pinterest) : ?>
            <li class="pinterest">
                <div class="share-pin-origin">
                    <a href="//www.pinterest.com/pin/create/button/?url=<?php the_permalink( $postid ) ?>&description=<?php echo $post->post_excerpt; ?>" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
                    <!-- Please call pinit.js only once per page -->
                    <script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
                </div>
                <i class="fa fa-pinterest-p"></i> 
                <span class="share-pin-alt pinterest"><?php _e( 'Pinterest' ,'hrm' ); ?></span>
            </li>
		<?php endif; ?>
	</ul>
</div>
<?php 
 }
?>