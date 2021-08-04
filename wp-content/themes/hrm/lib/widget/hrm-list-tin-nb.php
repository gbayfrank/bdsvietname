<?php

class Hrm_tin_nb extends WP_Widget
{
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor
     */
    function __construct()
    {
        $this->defaults = array(
            'title' => 'TIN NỔI BẬT',
            'limit'   => 5,
        );

        parent::__construct(
            'hrm-tin_nb-widget',
            __( '[HRM] Tin Nổi Bật', 'hrm' ),
            array(
                'classname'   => 'hrm-tin_dac_biet-widget hrm-tin_nb hrm-tabs-city',
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
        extract( $args );

        echo $before_widget;

        $args = array(
            'post_type'  => 'page',
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'template-tin-hot.php'
        );
        $pages  = get_pages( $args );
        $link_p = get_permalink( $pages[0] );
        wp_reset_query();
        if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            echo $before_title . '<a href="'.$link_p.'" title="'.$title.'">' . $title .'</a>'. $after_title;
        ?>
        <div class="widget tabs-widget tabs-type">
            <?php  $query_args = array(
                'posts_per_page'      => $limit,
                'post_type'           => 'realty',
                'ignore_sticky_posts' => true,
                'orderby'             => 'random',
                'meta_key'            => 'nb_type', 
                'meta_value'          => '1', 
            );
            $query = new WP_Query( $query_args ); ?>
            <div class="list-realty">
                <ul>
                    <?php $count = 1; ?>
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php get_template_part('template-parts/content-archive-realty'); ?>
                        <?php $count = $count + 1 ?>
                    <?php endwhile;
                    wp_reset_postdata();
                    wp_reset_query(); ?>
                </ul>
                <div class="clear clearfix more_link_ar">
                    <a href="<?php echo $link_p ?>" title="Xem thêm <?php echo $title ?>">Xem thêm <?php echo $title ?></a>
                </div>
            </div>
        </div>
        <?php wp_reset_postdata();

        echo $after_widget;

    }

    /**
     * Update widget
     * @return array
     */
    function update( $new_instance, $old_instance ) {

        return $new_instance;
    }

    /**
     * Display widget settings
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
        </div>
        <div style="clear: both;"></div>
        <?php
    }

}

