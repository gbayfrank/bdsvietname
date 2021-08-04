<?php
/**
 * Tab widget class
 * Author :DoBao
 */
class Hrm_Post_Tabs extends WP_Widget
{
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Class constructor
     * Set up the widget
     *
     * @return Hrm_Post_Tabs
     */
    function __construct()
    {
        $this->defaults = array(
            'title_1'      => '',
            'limit_1'     => 5,
            'excerpt_1'   => 0,
            'length_1'     => 10,
            'thumb_1'      => 1,
            'thumb_default_1'  => 'http://placehold.it/60x60',
            'cat_1'            => '',
            'date_1'      => 1,
            'comments_1'      => 0,
            'date_format_1'   => 'd/m/Y',


            'title_2'      => '',
            'limit_2'     => 5,
            'excerpt_2'   => 0,
            'length_2'     => 10,
            'thumb_2'      => 1,
            'thumb_default_2'  => 'http://placehold.it/60x60',
            'cat_2'            => '',
            'date_2'      => 1,
            'comments_2'      => 0,
            'date_format_2'   => 'd/m/Y',
        );

        parent::__construct(
            'hrm-tabs',
            __( '[HRM] Post Tabs', 'hrm' ),
            array(
                'classname'   => 'tabs-widget',
                'description' => __( 'Hiển thị chuyên mục bài viết theo tabs', 'hrm' ),
            ),
            array(
                'width'  => 515,
                'height' => 350,
            )
        );
    }
    /**
     *
     * @return void
     */
    function widget( $args, $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );

        $query_args1 = array(
            'posts_per_page'      => $limit_1,
            'post_status'         => 'publish',
            'post_type'           => 'post',
            'ignore_sticky_posts' => true,
            'category__in'        => $cat_1[0],
        );
        $query_args2 = array(
            'posts_per_page'      => $limit_2,
            'post_status'         => 'publish',
            'post_type'           => 'post',
            'ignore_sticky_posts' => true,
            'category__in'        => $cat_2[0],
        );

        $query1 = new WP_Query( $query_args1 );
        $query2 = new WP_Query( $query_args2 );

        if ( ! $query1->have_posts() )
            return;
        if ( ! $query2->have_posts() )
            return;

        extract( $args );

        echo $before_widget;
        printf( '
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#cat1" aria-controls="cat1" role="tab" data-toggle="tab">%s</a></li>
                <li role="presentation"><a href="#cat2" aria-controls="cat2" role="tab" data-toggle="tab">%s</a></li>
            </ul>',
            $instance['title_1'],
            get_cat_name($instance['cat_2'][0])
        );

        ?>
        <div class="tab-content">
        <?php
        echo '<div role="tabpanel" class="tab-pane active" id="cat1">';
        echo '<ul class="post-tabs">';
        while ( $query1->have_posts() ) : $query1->the_post(); ?>
            <li class="hrm-post-tabs">
                <?php if ($thumb_1) : ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo $thumb_default_1; ?>">
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="hrm-text">
                    <a class="hrm-title" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'hrm' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    <?php
                    if ( $date_1 )
                        echo '<time class="hrm-date" datetime="' . get_the_time( 'c' ) . '">' . esc_html( get_the_time( $date_format_1 ) ) . '</time>';

                    if ( $comments_1 )
                        echo '<span class="hrm-comments">' . sprintf( __( '%s Comments', 'hrm' ), get_comments_number() ) . '</span>';

                    if ( $excerpt_1 )
                    {
                        echo '<div class="hrm-excerpt">' . custom_excerpt( $length_1 ) . '</div>';
                    }
                    ?>
                </div>
            </li>
        <?php
        endwhile;
        echo '</ul>';
        echo '</div>';
        wp_reset_postdata();
        ?>
        <?php
        echo '<div role="tabpanel" class="tab-pane" id="cat2">';
        echo '<ul class="post-tabs">';
        while ( $query2->have_posts() ) : $query2->the_post();
            ?>
            <li class="hrm-post-tabs">
                <?php if ($thumb_2) : ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo $thumb_default_2; ?>">
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="hrm-text">
                    <a class="hrm-title" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'hrm' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    <?php
                    if ( $date_2 )
                        echo '<time class="hrm-date" datetime="' . get_the_time( 'c' ) . '">' . esc_html( get_the_time( $date_format_2 ) ) . '</time>';

                    if ( $comments_2 )
                        echo '<span class="hrm-comments">' . sprintf( __( '%s Comments', 'hrm' ), get_comments_number() ) . '</span>';

                    if ( $excerpt_2 )
                    {
                        echo '<div class="hrm-excerpt">' . custom_excerpt( $length_2 ) . '</div>';
                    }
                    ?>
                </div>
            </li>
        <?php
        endwhile;
        echo '</ul>';
        echo '</div>';
        wp_reset_postdata();
    ?>
        </div>
    <?php
        echo $after_widget;

    }
    /**
     * Sanitize widget form values as they are saved
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array Updated safe values to be saved
     */
    function update( $new_instance, $old_instance )
    {
        $instance                  = $old_instance;
        $instance['title_1']         = strip_tags( $new_instance['title_1'] );
        $instance['limit_1']         = (int) ( $new_instance['limit_1'] );
        $instance['cat_1']           = array_filter( $new_instance['cat_1'] );
        $instance['comments_1']      = ! empty( $new_instance['comments_1'] );
        $instance['thumb_1']         = ! empty( $new_instance['thumb_1'] );
        $instance['thumb_default_1'] = $new_instance['thumb_default_1'];

        $instance['date_1']          = ! empty( $new_instance['date_1'] );
        $instance['date_format_1']   = strip_tags( $new_instance['date_format_1'] );
        $instance['excerpt_1']       = ! empty( $new_instance['excerpt_1'] );
        $instance['length_1']        = (int) ( $new_instance['length_1'] );

        $instance['title_2']         = strip_tags( $new_instance['title_2'] );
        $instance['limit_2']         = (int) ( $new_instance['limit_2'] );
        $instance['cat_2']           = array_filter( $new_instance['cat_2'] );
        $instance['comments_2']      = ! empty( $new_instance['comments_2'] );
        $instance['thumb_2']         = ! empty( $new_instance['thumb_2'] );
        $instance['thumb_default_2'] = $new_instance['thumb_default_2'];

        $instance['date_2']          = ! empty( $new_instance['date_2'] );
        $instance['date_format_2']   = strip_tags( $new_instance['date_format_2'] );
        $instance['excerpt_2']       = ! empty( $new_instance['excerpt_2'] );
        $instance['length_2']        = (int) ( $new_instance['length_2'] );
        return $instance;
    }


    /**
     * Displays the widget options
     *
     * @param array $instance
     *
     * @return void
     */
    function form( $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
        ?>
    <div style="float: left; width: 233px; border: 1px solid #DDD; padding: 10px 10px 0px 10px;">
        <p><strong><?php _e( 'Category first', 'hrm' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_1' ) ); ?>" type="text" value="<?php echo $instance['title_1']; ?>">
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'limit_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit_1' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit_1']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit_1' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cat_1' ) ); ?>"><?php _e( 'Select Category: ', 'hrm' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_1' ) ); ?>[]">
                <option value=""<?php selected( empty( $instance['cat_1'] ) ); ?>><?php _e( 'All', 'hrm' ); ?></option>
                <?php
                $categories = get_terms( 'category' );
                foreach ( $categories as $category )
                {
                    printf(
                        '<option value="%s"%s>%s</option>',
                        $category->term_id,
                        selected( in_array( $category->term_id, (array) $instance['cat_1'] ) ),
                        $category->name
                    );
                }
                ?>
            </select>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'comments_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comments_1' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['comments_1'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'comments_1' ) ); ?>"><?php _e( 'Show Comment Number', 'hrm' ); ?></label>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'thumb_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_1' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['thumb_1'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb_1' ) ); ?>"><?php _e( 'Show Thumbnail', 'hrm' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb_default_1' ) ); ?>"><?php _e( 'Default Thumbnail', 'hrm' ); ?></label>
            <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'thumb_default_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_default_1' ) ); ?>" value="<?php echo $instance['thumb_default_1']; ?>">

        </p>

        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'date_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_1' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['date_1'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'date_1' ) ); ?>"><?php _e( 'Show Date', 'hrm' ); ?></label>
        </p>
        <p>
            <input size="6" id="<?php echo esc_attr( $this->get_field_id( 'date_format_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_format_1' ) ); ?>" type="text" value="<?php echo $instance['date_format_1']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'date_format_1' ) ); ?>"><?php _e( 'Date Format', 'hrm' ); ?></label>
            <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">[?]</a>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_1' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['excerpt_1'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_1' ) ); ?>"><?php _e( 'Show Excerpt', 'hrm' ); ?></label>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'length_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length_1' ) ); ?>" type="text" size="2" value="<?php echo $instance['length_1']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'length_1' ) ); ?>"><?php _e( 'Excerpt Length (words)', 'hrm' ); ?></label>
        </p>

        <div style="clear: both;"></div>
    </div>
    <div style="float: left; width: 233px; border: 1px solid #DDD; padding: 10px 10px 0px 10px;">
        <p><strong><?php _e( 'Category Second', 'hrm' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_2' ) ); ?>" type="text" value="<?php echo $instance['title_2']; ?>">
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'limit_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit_2' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit_2']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit_2' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cat_2' ) ); ?>"><?php _e( 'Select Category: ', 'hrm' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_2' ) ); ?>[]">
                <option value=""<?php selected( empty( $instance['cat_2'] ) ); ?>><?php _e( 'All', 'hrm' ); ?></option>
                <?php
                $categories = get_terms( 'category' );
                foreach ( $categories as $category )
                {
                    printf(
                        '<option value="%s"%s>%s</option>',
                        $category->term_id,
                        selected( in_array( $category->term_id, (array) $instance['cat_2'] ) ),
                        $category->name
                    );
                }
                ?>
            </select>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'comments_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comments_2' ) ); ?>" type="checkbox" value="2" <?php checked( $instance['comments_2'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'comments_2' ) ); ?>"><?php _e( 'Show Comment Number', 'hrm' ); ?></label>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'thumb_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_2' ) ); ?>" type="checkbox" value="2" <?php checked( $instance['thumb_2'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb_2' ) ); ?>"><?php _e( 'Show Thumbnail', 'hrm' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb_default_2' ) ); ?>"><?php _e( 'Default Thumbnail', 'hrm' ); ?></label>
            <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'thumb_default_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_default_2' ) ); ?>" value="<?php echo $instance['thumb_default_2']; ?>">

        </p>

        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'date_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_2' ) ); ?>" type="checkbox" value="2" <?php checked( $instance['date_2'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'date_2' ) ); ?>"><?php _e( 'Show Date', 'hrm' ); ?></label>
        </p>
        <p>
            <input size="6" id="<?php echo esc_attr( $this->get_field_id( 'date_format_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_format_2' ) ); ?>" type="text" value="<?php echo $instance['date_format_2']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'date_format_2' ) ); ?>"><?php _e( 'Date Format', 'hrm' ); ?></label>
            <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">[?]</a>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_2' ) ); ?>" type="checkbox" value="2" <?php checked( $instance['excerpt_2'] ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_2' ) ); ?>"><?php _e( 'Show Excerpt', 'hrm' ); ?></label>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'length_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length_2' ) ); ?>" type="text" size="2" value="<?php echo $instance['length_2']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'length_2' ) ); ?>"><?php _e( 'Excerpt Length (words)', 'hrm' ); ?></label>
        </p>

        <div style="clear: both;"></div>
    </div>
        <?php
    }
}