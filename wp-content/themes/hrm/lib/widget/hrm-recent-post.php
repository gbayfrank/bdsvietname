<?php
/*
* Author : DoBao
*/

class Hrm_Widget_Recent_Posts extends WP_Widget
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
     * @return hrm_Widget_Recent_Posts
     */
    function __construct()
    {
        $this->defaults = array(
            'title'         => '',
            'limit'         => 5,
            'excerpt'       => 1,
            'length'        => 10,
            'thumb'         => 1,
            'thumb_default' => 'http://placehold.it/60x60',
            'cat'           => '',
            'date'          => 1,
            'comments'      => 0,
            'date_format'   => 'd/m/Y',
        );

        parent::__construct(
            'hrm-recent-posts-widget',
            __( '[HRM] Recent Posts Widget', 'hrm' ),
            array(
                'classname'   => 'hrm-recent-posts-widget',
                'description' => __( 'Advanced recent posts widget.', 'hrm' )
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

        ?>
        <?php
            if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            echo $before_title . $title . $after_title; 
        ?>
        <?php
        echo '<div class="widget-text"><ul class="widget-recent-post">';
        while ( $query->have_posts() ) : $query->the_post();?>
            <li>
                <h4>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h4>
            </li>
        <?php
        endwhile;
        echo '</ul></div>';
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
        $instance                  = $old_instance;
        $instance['title']         = strip_tags( $new_instance['title'] );
        $instance['limit']         = (int) ( $new_instance['limit'] );
        $instance['cat']           = array_filter( $new_instance['cat'] );
        $instance['comments']      = ! empty( $new_instance['comments'] );
        $instance['thumb']         = ! empty( $new_instance['thumb'] );
        $instance['thumb_default'] = $new_instance['thumb_default'];

        $instance['date']          = ! empty( $new_instance['date'] );
        $instance['date_format']   = strip_tags( $new_instance['date_format'] );
        $instance['excerpt']       = ! empty( $new_instance['excerpt'] );
        $instance['length']        = (int) ( $new_instance['length'] );

        return $instance;
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
        </div>

        <div style="clear: both;"></div>
        <?php
    }

}

