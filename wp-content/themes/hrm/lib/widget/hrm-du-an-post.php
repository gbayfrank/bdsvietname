<?php
/*
* Author : DoBao
*/

class Hrm_Widget_DA_Posts extends WP_Widget
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
            'title' => '',
            'limit' => 5,
        );

        parent::__construct(
            'hrm-da-posts-widget',
            __( '[HRM] Hiển thị tin dự án', 'hrm' ),
            array(
                'classname'   => 'hrm-da-posts-widget hrm-recent-realty',
                'description' => __( 'Advanced recent posts widget.', 'hrm' )
            )
        );
    }

    /**
     * Display widget
     * @return void
     */
    function widget( $args, $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );

        $query_args = array(
            'posts_per_page'      => $limit,
            'post_type'           => 'project',
        );

        $query = new WP_Query( $query_args );

        // if ( ! $query->have_posts() )
        //     return;

        extract( $args );

        echo $before_widget;

        ?>
        <?php
            if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            echo $before_title . $title . $after_title; 
        ?>
       
        <div class="post-listing archive-project-list archive-box masonry-grid">
            <div class="row">
                <?php while ( $query->have_posts() ) { $query->the_post(); ?>
                    <div class="col-md-4 col-sm-4 col-xs-6 project-wrap-item">
                        <?php get_template_part( 'template-parts/item-du-an');  ?>
                    </div>
                <?php }
                wp_reset_postdata();
                wp_reset_query(); ?>
            </div>
        </div>

        <?php echo $after_widget;

    }

    /**
     * Update widget
     *
     * @return array
     */
    function update( $new_instance, $old_instance ) {
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Tiêu đề', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Số dự án', 'hrm' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" size="2" value="<?php echo $instance['limit']; ?>">
            
        </p>

        <div style="clear: both;"></div>
        <?php
    }

}

