<?php
// Author : DoBao

class Hrm_Show_Posts_Home extends WP_Widget
{
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     *
     * @return Hrm_Show_Posts_Home
     */
    function __construct()
    {
        $this->defaults = array(
            'title'         => '',
            'limit'         => 5,
            'excerpt'       => 0,
            'length'        => 10,
            'thumb'         => 1,
            'thumb_default' => 'http://placehold.it/60x60',
            'cat'           => '',
            'style'           => 'style_1',
            'location'           => 'location_1',
            'icon'           => '',
        );

        parent::__construct(
            'hrm-show-posts-home',
            __( '[HRM] Show Posts Home', 'hrm' ),
            array(
                'classname'   => 'hrm-show-post-home',
                'description' => __( 'Hiển thị bài viết trang chủ.', 'hrm' )
            ),
            array( 'width' => 150 , 'height' => 350 )
        );
    }

    /**
     * Display widget
     *
     * @param array $args     Sidebar configuration
     * @param array $instance Widget settings
     *
     * @return void
     */
    function widget( $args, $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );
        $query_args = array(
            'posts_per_page'      => $limit,
            'post_status'         => 'publish',
            'post_type'           => 'post',
            'ignore_sticky_posts' => true,
        );
        if ( ! empty( $cat ) && is_array( $cat ) )
            $query_args['category__in'] = $cat;

        $query = new WP_Query( $query_args );

        if ( ! $query->have_posts() )
            return;

        extract( $args );

        echo $before_widget;
        echo '<div class="widget-text '.$style.' '.$location.' '.$icon.'">';
        ?>
        <?php
            if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            echo $before_title . $title . $after_title;
        ?>
        <div class="show-more-view">
        <?php if ($style != 'style_3') : ?>
            <div class="row">
        <?php endif; ?>
                <?php
                $first_post = true;
                while ( $query->have_posts() ) : $query->the_post();
                    if ( $first_post ) {
                      ?>
                    <?php if ($style == 'style_3') : ?>
                        <div class="first-post">
                    <?php elseif ( $style == 'style_2') : ?>
                        <div class="first-post col-sm-6">
                    <?php elseif ( $style == 'style_1') : ?>
                        <div class="first-post col-sm-7">
                    <?php endif; ?>
        		            <article class="view-more-news">
                                <?php if ($style == 'style_1') : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('post-news', array('class' => 'lazy')); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>">
                                       <?php the_post_thumbnail('post-news', array('class' => 'lazy')); ?>
                                    </a>
                                <?php endif; ?>
        		                <div class="news-des">
        	                    	<h3>
                                        <a href="<?php the_permalink(); ?>"rel="bookmark"><?php the_title(); ?></a>
                                    </h3>
        		                </div>
        		            </article>
        		        </div>
                        <?php if ($style == 'style_3') : ?>
                            <div class="other-posts">
                        <?php elseif ( $style == 'style_2') : ?>
                            <div class="other-posts col-sm-6">
                        <?php elseif ( $style == 'style_1') : ?>
                            <div class="other-posts col-sm-5">
                        <?php endif; ?>
                            <div class="news-default-right">
                            <ul>
                    			<?php
                    			$first_post = false;
                    			} else {
                    			?>
                                <li>
                                    <?php if($style == 'style_1') : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('realty-thumbnail', array('class' => 'lazy')); ?>
                                            <?php else : ?>
                                                <img class="lazy" src="http://placehold.it/70x45">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif; ?>
                                    <h4>
                                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h4>
                                </li>
                    <?php
                	}
                    endwhile;
            echo '</ul></div>';
            echo '</div>';
            if ($style != 'style_3') {
                echo '</div>';
            }
            echo '</div></div>';
        wp_reset_postdata();

        echo $after_widget;

    }


    /**
     * Update widget
     *
     * @param array $new_instance New widget settings
     * @param array $old_instance Old widget settings
     *
     * @return array
     */
    function update( $new_instance, $old_instance )
    {
        return $new_instance;
    }

    /**
     * Display widget settings
     *
     * @param array $instance Widget settings
     *
     * @return void
     */
    function form( $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
    ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
        </p>

        <div style="width: 280px; float: left; margin-right: 10px;">
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit']; ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php _e( 'Select Category: ', 'hrm' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>[]">
                    <option value=""<?php selected( empty( $instance['cat'] ) ); ?>><?php _e( 'All', 'hrm' ); ?></option>
                    <?php
                    $categories = get_terms( 'category' );
                    foreach ( $categories as $category )
                    {
                        printf(
                            '<option value="%s"%s>%s</option>',
                            $category->term_id,
                            selected( in_array( $category->term_id, (array) $instance['cat'] ) ),
                            $category->name
                        );
                    }
                    ?>
                </select>
            </p>
            <p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Chọn kiểu hiển thị:', 'hrm'); ?> </label>
                <select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">

                    <option value="style_1" <?php echo 'style_1' == $instance ['style'] ? 'selected="selected"' : '' ?>><?php _e('Style 1', 'hrm'); ?></option>
                    <option value="style_2" <?php echo 'style_2' == $instance ['style'] ? 'selected="selected"' : '' ?>><?php _e('Style 2', 'hrm'); ?></option>
                    <option value="style_3" <?php echo 'style_3' == $instance ['style'] ? 'selected="selected"' : '' ?>><?php _e('Style 3', 'hrm'); ?></option>
                </select>
            </p>
            <p><label for="<?php echo $this->get_field_id('location'); ?>"><?php _e('Chọn cột hiển thị:', 'hrm'); ?> </label>
                <select id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>">

                    <option value="location_1" <?php echo 'location_1' == $instance ['location'] ? 'selected="selected"' : '' ?>><?php _e('Cột trái', 'hrm'); ?></option>
                    <option value="location_2" <?php echo 'location_2' == $instance ['location'] ? 'selected="selected"' : '' ?>><?php _e('Cột phải', 'hrm'); ?></option>
                </select>
                ( Style 3)
            </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Class Icon', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo $instance['icon']; ?>">
        </p>
        </div>
        <div style="clear: both;"></div>
        <?php
    }

}


