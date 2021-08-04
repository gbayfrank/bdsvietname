<?php

class Hrm_tin_dac_biet extends WP_Widget
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
            'title_1' => 'TIN VIP',
            'title_2' => 'TIN NỔI BẬT',
            'limit'   => 5,
            'date'    => 1,
        );

        parent::__construct(
            'hrm-bds_type-widget',
            __( '[HRM] Loại bài viết đặc biệt', 'hrm' ),
            array(
                'classname'   => 'hrm-tin_dac_biet-widget hrm-tabs-city',
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

        echo $before_widget;  ?>
        <div class="widget tabs-widget tabs-type">

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tin_bd1" aria-controls="tin_bd1" role="tab" data-toggle="tab"><?php echo $title_1 ?></a></li>
                <li role="presentation"><a href="#tin_db2" aria-controls="tin_db2" role="tab" data-toggle="tab"><?php echo $title_2 ?></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tin_bd1">
                    <?php  $query_args = array(
                        'posts_per_page'      => $limit,
                        'post_type'           => 'realty',
                        'ignore_sticky_posts' => true,
                        'orderby'             => 'random',
                        'meta_key'            => 'vip_type', 
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
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="tin_db2">
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
                    </div>
                </div>
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
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title2' ) ); ?>"><?php _e( 'Title2', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title2' ) ); ?>" type="text" value="<?php echo $instance['title2']; ?>">
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

