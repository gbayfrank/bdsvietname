<?php
/*
* Author : DoBao
*/
class Hrm_Widget_Tax_Realty extends WP_Widget
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
            'limit'         => 0,
            'orderby'       => 'date',
            'order'         => 'DESC'
        );

        parent::__construct(
            'hrm-list-tax-realty',
            __( '[HRM] Hiển thị danh sách', 'hrm' ),
            array(
                'classname'   => 'hrm-list-tax-realty',
                'description' => __( 'Hiển thị danh sách.', 'hrm' )
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
        global $post;
        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );


        extract( $args );
        $args = array(
            'hide_empty'          => false,
            'orderby'             => $orderby,
            'order'               => $order,
            'number'              => $limit,
            'parent'              => 0,
        );
        $terms_car = get_terms( $type_tax, array( 'hide_empty' => 0,));
        $current_term = get_the_terms( $post->ID , $type_tax );
        if ($current_term && is_single()) {
            foreach ($current_term as $hihi) {
            $terms = get_terms($type_tax, $args);
            echo $before_widget;
            ?>
            <?php
                if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            ?>
            <div class="widget-top <?php echo $type_tax; ?>">
                <h2 class="widget-title"><?php echo $title; ?></h2>
            </div>
            <div class="list-term-tax <?php echo $type_tax; ?>">
                <ul>
                    <?php foreach ($terms as $term) { ?>
                        <?php
                            $current_cat = '';
                            if ($hihi->term_id == $term->term_id) {
                                $current_cat = 'current-cat';
                            } else {
                                $current_cat = '';
                            }
                        ?>
                        <li class="cat-item cat-item-<?php echo $term->term_id; ?> <?php echo $current_cat; ?>">
                            <a href="<?php echo get_term_link( $term->slug, $type_tax ); ?>">
                            <?php echo $term->name; ?> <b>(<?php echo $term->count; ?>)</b>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php echo $after_widget; ?>
        <?php }
    }
    else {
            $current = "";
            $terms = get_terms($type_tax, $args);
            echo $before_widget;
            ?>
            <?php
                if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
            ?>
            <div class="widget-top <?php echo $type_tax; ?>">
                <h2 class="widget-title"><?php echo $title; ?></h2>
            </div>
            <div class="list-term-tax <?php echo $type_tax; ?>">
                <ul>
                    <?php foreach ($terms as $term) { ?>
                        <?php
                            $queried_object = get_queried_object();
                            if ($queried_object->term_id == $term->term_id) {
                                $current = "current-cat";
                            } else {
                                $current = "";
                            };
                        ?>
                        <li class="cat-item <?php echo $current; ?> cat-item-<?php echo $term->term_id; ?>">
                            <a href="<?php echo get_term_link( $term->slug, $type_tax ); ?>">
                                <?php echo $term->name; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php echo $after_widget; ?>
        <?php
    }
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
        $instance             = $old_instance;
        $instance['title']    = strip_tags( $new_instance['title'] );
        $instance['limit']    = (int) ( $new_instance['limit'] );
        $instance['type_tax'] =  $new_instance['type_tax'];
        $instance['orderby']  =  $new_instance['orderby'];
        $instance['order']    =  $new_instance['order'];


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
        $orderby        = apply_filters ( 'orderby', isset ( $instance ['orderby'] ) ? $instance ['orderby'] : '' );
         $type_tax        = apply_filters ( 'type_tax', isset ( $instance ['type_tax'] ) ? $instance ['type_tax'] : '' );
        $order          = apply_filters ( 'order', isset ( $instance ['order'] ) ? $instance ['order'] : '' );
        ?>

        <div>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
            </p>
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit']; ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Number Of Posts ( 0 All )', 'hrm' ); ?></label>
            </p>
            <p><label for="<?php echo $this->get_field_id('type_tax'); ?>"><?php _e('Type List:', 'hrm'); ?></label>
              <select   id="<?php echo $this->get_field_id('type_tax'); ?>"  name="<?php echo $this->get_field_name('type_tax'); ?>">
                 <option value="realty-sell"
                 <?php echo 'realty-sell' == $type_tax ? 'selected="selected"' : '' ?>><?php _e('BDS Bán', 'hrm'); ?></option>
                 <option value="realty-rent"
                 <?php echo 'realty-rent' == $type_tax ? 'selected="selected"' : '' ?>><?php _e('BDS Thuê', 'hrm'); ?></option>
                 <option value="city"
                 <?php echo 'city' == $type_tax ? 'selected="selected"' : '' ?>><?php _e('Thành phố', 'hrm'); ?></option>
                </select>
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

