<?php
global $hrm_options;
$enabled_thumb = $hrm_options['enabled-thumb'];
$share_social = $hrm_options['enabled-social-share'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		?>
	</header><!-- .entry-header -->
	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php get_template_part( 'lib/loops/meta-archive' ); ?>
		</div><!-- .entry-meta -->
	<?php
	endif; ?>
	<div class="entry-content">
		<?php the_content();?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php hrm_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php if (is_single() && $share_social) : ?>
		<?php hrm_social_share(get_the_ID()); ?>
	<?php endif; ?>
</article><!-- #post-## -->
