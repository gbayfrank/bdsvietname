<?php
/*
* Author : DoBao
*/
class Hrm_Widget_Realty_Highlights extends WP_Widget
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
            'limitv'         => 5,
            'excerpt'       => 1,
            'length'        => 10,
            'thumb'         => 1,
            'thumb_default' => 'http://placehold.it/170x115',
            'date'          => 1,
            'date_format'   => 'd/m/Y',
            'orderby'       => 'date',
            'order'         => 'DESC'
        );

        parent::__construct(
            'hrm-realty-highlights',
            __( '[HRM] Bất động sản nổi bật', 'hrm' ),
            array(
                'classname'   => 'hrm-realty-highlights hrm-recent-realty feature',
                'description' => __( 'Hiển thị bất động sản nổi bật.', 'hrm' )
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

        extract( $args );

        echo $before_widget;
        echo '<div class="widget-text project-hl">';
        ?>
        <?php
            if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            echo $before_title . '<a href="'.get_post_type_archive_link( 'realty' ).'" title="'.$title.'">' . $title .'</a>'. $after_title;
        ?>
        <?php if ($limitv>0) { ?>
        
        <div class="slide-feature owl-carousel owl-theme">
            <?php
                $queryv_args = array(
                    'posts_per_page'      => $limitv,
                    'post_status'         => 'publish',
                    'post_type'           => 'realty',
                    'ignore_sticky_posts' => true,
                    'meta_key'            => 'nb_type',
                    'meta_value'          => 1
                );
                $queryv = new WP_Query( $queryv_args );
                if ( $queryv->have_posts() ) {
                    while ( $queryv->have_posts() ) : $queryv->the_post(); ?>
                        <div class="item">
                            <a href="<?php the_permalink(); ?>" class="thumb">
                                <?php the_post_thumbnail('post-news'); ?>
                                <span class="vip">HOT</span>
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
                                    if (($par_value == 'Triệu/m2') && $prince_realty) {
								$key = __('Triệu/m<sup>2</sup>', 'hrm');
								echo number_format($prince_realty, 0, ",", ".") . ' ' . $key;
							} elseif ($prince_realty) {
								echo number_format($prince_realty, 0, ",", ".") . ' ' . $par_value;
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
        <?php } ?>
        <?php $query_args = array(
            'posts_per_page'      => $limit,
            'post_status'         => 'publish',
            'post_type'           => 'realty',
            'orderby'             => $orderby,
            'order'               => $order,
            'ignore_sticky_posts' => true,
        );

        $query = new WP_Query( $query_args ); ?>
         <div class="list-realty list-50 clearfix">
            <ul>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php get_template_part('template-parts/content-archive-realty'); ?>
                <?php endwhile; ?>
            </ul>
            <div class="clear clearfix more_link_ar">
                    <a href="<?php echo get_post_type_archive_link( 'realty' ); ?>" title="Xem thêm">Xem thêm tin bất động sản</a>
                </div>
        </div>
    </div>
      <?php  wp_reset_postdata();

        echo $after_widget;
    }

    function update( $new_instance, $old_instance )
    {

        return $new_instance;
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
                <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Số tin thường hiển thị', 'hrm' ); ?></label>
            </p>
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'limitv' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limitv' ) ); ?>" type="text" size="2" value="<?php echo $instance['limitv']; ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'limitv' ) ); ?>"><?php _e( 'Số tin VIP hiển thị', 'hrm' ); ?></label>
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
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="text" size="2" value="<?php echo $instance['length']; ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>"><?php _e( 'Excerpt Length (words)', 'hrm' ); ?></label>
            </p>
        </div>

        <div style="clear: both;"></div>
        <?php
    }

}