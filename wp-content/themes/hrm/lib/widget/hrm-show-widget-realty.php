<?php
/*
* Author : DoBao
*/
class Hrm_Widget_Widget_Realty extends WP_Widget
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
            'date'          => 1,
            'date_format'   => 'd/m/Y',
            'orderby'       => 'date',
            'order'         => 'DESC'
        );

        parent::__construct(
            'hrm-widget-realty',
            __( '[HRM] Tin mới đăng ', 'hrm' ),
            array(
                'classname'   => 'hrm-widget-realty',
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
            'post_type'           => 'realty',
            'orderby'             => $orderby,
            'order'               => $order,
            'ignore_sticky_posts' => true,
        );

        $query = new WP_Query( $query_args );

        if ( ! $query->have_posts() )
            return;

        extract( $args );

        echo $before_widget;
        echo '<div class="widget-text">';
        ?>
        <?php
            if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            echo $before_title . $title . $after_title;
        ?>
        <div class="list-realty">
          <ul>
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <li>
                    <div class="info-realty">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="details">
                            <div class="price">
                                <label><?php _e( 'Giá','hrm' ); ?><span>:</span></label>
                                <?php echo rwmb_meta('price-realty', 'type=number');  ?><sup>đ</sup>
                            </div>
                            <span class="date"><?php echo get_the_date('d/m/Y') ?></span>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
          </ul>
        </div>
    </div>
      <?php  wp_reset_postdata();

        echo $after_widget;
    }

    function update( $new_instance, $old_instance )
    {
        $instance                  = $old_instance;
        $instance['title']         = strip_tags( $new_instance['title'] );
        $instance['limit']         = (int) ( $new_instance['limit'] );
        $instance['comments']      = ! empty( $new_instance['comments'] );
        $instance['thumb']         = ! empty( $new_instance['thumb'] );
        $instance['thumb_default'] = $new_instance['thumb_default'];

        $instance['date']          = ! empty( $new_instance['date'] );
        $instance['date_format']   = strip_tags( $new_instance['date_format'] );
        $instance['excerpt']       = ! empty( $new_instance['excerpt'] );
        $instance['length']        = (int) ( $new_instance['length'] );
        $instance['orderby']      =  $new_instance['orderby'];
        $instance['order']        =  $new_instance['order'];

        return $instance;
    }


    function form( $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
        $orderby        = apply_filters ( 'orderby', isset ( $instance ['orderby'] ) ? $instance ['orderby'] : '' );
        $order          = apply_filters ( 'order', isset ( $instance ['order'] ) ? $instance ['order'] : '' );
        ?>

        <div>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
            </p>
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit']; ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
            </p>
            <p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Sorted by:', 'hrm'); ?></label>
              <select   id="<?php echo $this->get_field_id('orderby'); ?>"  name="<?php echo $this->get_field_name('orderby'); ?>">
                 <option value="date"
                 <?php echo 'date' == $orderby ? 'selected="selected"' : '' ?>><?php _e('Date', 'hrm'); ?></option>
                 <option value="ID"
                 <?php echo 'ID' == $orderby ? 'selected="selected"' : '' ?>><?php _e('ID', 'hrm'); ?></option>
                 <option value="title"
                 <?php echo 'title' == $orderby ? 'selected="selected"' : '' ?>><?php _e('Title', 'hrm'); ?></option>
                 <option value="rand"
                 <?php echo 'rand' == $orderby ? 'selected="selected"' : '' ?>><?php _e('Random', 'hrm'); ?></option>
                </select>
            </p>

            <p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Sorting criteria:', 'hrm'); ?></label>
                <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                    <option value="DESC"
                    <?php echo 'DESC' == $order ? 'selected="selected"' : '' ?>><?php _e('DESC:', 'hrm'); ?></option>
                    <option value="ASC"
                    <?php echo 'ASC' == $order ? 'selected="selected"' : '' ?>><?php _e('ASC:', 'hrm'); ?></option>
                </select>
            </p>
        </div>

        <div style="clear: both;"></div>
        <?php
    }

}

