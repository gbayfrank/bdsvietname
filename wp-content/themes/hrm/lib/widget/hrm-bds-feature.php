<?php
class Hrm_Show_BDS_Feature extends WP_Widget
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
            'thumb_default' => 'http://placehold.it/60x60',
        );

        parent::__construct(
            'hrm-bds-feature',
            __( '[HRM] Bất động sản nổi bật', 'hrm' ),
            array(
                'classname'   => 'hrm-bds-feature',
                'description' => __( 'Hiển thị BDS nổi bật trang chủ.', 'hrm' )
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
            'ignore_sticky_posts' => true,
            'meta_key' => 'vip_type',
            'meta_value' => array('',0)
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
        <div class="slide-feature owl-carousel owl-theme">
            <?php
                $queryv_args = array(
                    'posts_per_page'      => $limit,
                    'post_status'         => 'publish',
                    'post_type'           => 'realty',
                    'ignore_sticky_posts' => true,
                    'meta_key' => 'vip_type',
                    'meta_value' => 1
                );
                $queryv = new WP_Query( $queryv_args );
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) : $query->the_post(); ?>
                        <div class="item">
                            <a href="<?php the_permalink(); ?>" class="thumb">
                                <?php the_post_thumbnail('realty-thumbnail'); ?>
                                <span class="vip">Vip</span>
                            </a>
                            <h3 class="name">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="price">
                                <label><?php _e( 'Giá','hrm' ); ?><span>:</span></label>
                                <?php
                                    $prince_realty = rwmb_meta('price-realty', 'type=number');
                                    $par_value = rwmb_meta('par_value');
                                    $key = '';
                                    if ( ($par_value=='Triệu/m2') && $prince_realty ) {
                                        $key = __('Triệu/m<sup>2</sup>','hrm');
                                        echo $prince_realty.' '.$key;
                                    } elseif ($prince_realty) {
                                        echo $prince_realty.' '.$par_value;
                                    } elseif (!$prince_realty) {
                                        echo __('Thỏa thuận','hrm');
                                    }
                                ?>
                            </div>
                            <div class="area">
                                <label><?php _e( 'Diện tích','hrm' ); ?><span>:</span></label>
                                <?php echo rwmb_meta('area-realty', 'type=number'); ?> m<sup>2</sup>
                            </div>
                        </div>
                <?php endwhile;
                }
                wp_reset_postdata();
            ?>
        </div>
        <div class="list-realty">
            <ul>
                <?php
                $first_post = true;
                while ( $query->have_posts() ) : $query->the_post(); ?>
                     <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('realty-thumbnail'); ?>
                        </a>
                        <div class="info-realty">
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <p class="date">
                                <i class="fa fa-clock-o"></i>
                                <?php echo get_the_date('d/m/Y') ?>
                            </p>
                            <div class="des">
                                <?php
                                    $content = apply_filters('the_content', get_the_content());
                                    $content = str_replace(']]>', ']]&gt;', $content);
                                ?>
                                <?php echo wp_trim_words( $content,60,'...' ); ?>
                            </div>
                            <div class="details">
                                <div class="price">
                                    <label><?php _e( 'Giá','hrm' ); ?><span>:</span></label>
                                    <?php
                                        $prince_realty = rwmb_meta('price-realty', 'type=number');
                                        $par_value = rwmb_meta('par_value');
                                        $key = '';
                                        if ( ($par_value=='Triệu/m2') && $prince_realty ) {
                                            $key = __('Triệu/m<sup>2</sup>','hrm');
                                            echo $prince_realty.' '.$key;
                                        } elseif ($prince_realty) {
                                            echo $prince_realty.' '.$par_value;
                                        } elseif (!$prince_realty) {
                                            echo __('Thỏa thuận','hrm');
                                        }
                                    ?>
                                </div>
                                <div class="area">
                                    <label><?php _e( 'Diện tích','hrm' ); ?><span>:</span></label>
                                    <?php echo rwmb_meta('area-realty', 'type=number'); ?> m<sup>2</sup>
                                </div>
                                <div class="location">
                                    <label><?php _e( 'Vị trí','hrm' ); ?><span>:</span></label>
                                    <?php the_terms( get_the_ID() , 'city-realty'  ); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php
                endwhile;
            
            echo '</ul>';
            
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
        </div>
        <div style="clear: both;"></div>
        <?php
    }

}


