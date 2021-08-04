<?php
global $hrm_options;
$enabled_related = $hrm_options['enabled-related'];

get_header(); ?>
<div id="primary" class="content-area col-md-9">
  <main id="main" class="site-main realty" role="main">

    <?php
    while ( have_posts() ) : the_post();
      get_template_part( 'template-parts/content-single', 'realty' );
      postview_set(get_the_ID());
        endwhile; // End of the loop.
        ?>
      </main><!-- #main -->
      <div class="related-post widget">
        <?php
        $terms_obj = wp_get_post_terms( get_the_id(), 'city-realty' );
        $terms     = array();
        foreach ($terms_obj as $term_ob) {
          $terms[]   = $term_ob->term_id;
        }
        
        $related_items = new WP_Query( array(
          'post_type'           => 'realty',
          'posts_per_page'      => 6,
          'ignore_sticky_posts' => 1,
          'post__not_in'        => array( get_the_ID() ),
          'tax_query' =>   array(
            array(
              'taxonomy'         => 'city-realty',
              'field'            => 'id',
              'terms'            => $terms,
              'include_children' => true,
            ),
          ),
        ) );
        ?>
        <?php if ( $related_items->have_posts()) : ?>
          <div class="title-related">
            <h3><?php _e( 'Tin đăng khác liên quan ' ); ?></h3>
          </div>
          <div class="list-realty">
            <ul>
              <?php while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
               <?php get_template_part( 'template-parts/content-archive', 'realty' ); ?>
             <?php endwhile; ?>
           </ul>
         </div>
       <?php endif; ?>
       <?php
       wp_reset_postdata();
       ?>
     </div><!-- .related-post -->
     <div class="realty-comment">
      <div class="comment-title">
        <h3><?php _e( 'Bình luận' ,'hrm' ); ?></h3>
      </div>
      <div class="comment">
        <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="5"></div>
      </div>
    </div>
  </div><!-- #primary -->
  <?php get_sidebar(); ?>
  <?php
  get_footer();
