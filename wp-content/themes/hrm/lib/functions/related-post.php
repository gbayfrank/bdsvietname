<?php
function hrm_recent_post_category() {
    $categories = get_the_category($post->ID);
    if ($categories):
        $category_ids = array();
        foreach($categories as $individual_category):
          $category_ids[] = $individual_category->term_id;
          $args=array(
                'category__in'        => $category_ids,
                'post__not_in'        => array($post->ID),
                'showposts'           => 5,
                'ignore_sticky_posts' => 1,
                'orderby'             => 'date',
                'order'               => 'DESC',
                );
          $related_post = new wp_query($args);
        endforeach;
        if( $related_post->have_posts() ):
            if( is_single() ):?>
            <div class="title-related">
              <h3>Các bài viết liên quan</h3>
            </div>
            <div class="show-related">
            <ul class="post-listing archive-box">
                <?php while ($related_post-> have_posts() ) :$related_post-> the_post(); ?>
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
            </div>
            <?php  
            endif; 
        endif; 
    endif; 
    wp_reset_query(); 
}

  function hrm_related_tax() {
      $related_items = new WP_Query( array(
      'post_type' => 'realty',
      'posts_per_page'      => 5,
      'ignore_sticky_posts' => 1,
      'post__not_in'        =>array( $post->ID )
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
}