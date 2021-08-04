<?php
/*
* Author : DoBao
*/
class Hrm_Widget_List_City extends WP_Widget
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
            'hrm-list-city',
            __( '[HRM] Danh sách các tỉnh', 'hrm' ),
            array(
                'classname'   => 'hrm-list-city',
                'description' => __( ' Danh sách các tỉnh', 'hrm' )
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
            'parent'              => 0,
        );
        $count = 0;
        $terms = get_terms('city-realty', $args);
        $term_current = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
        echo $before_widget;
        ?>
        <?php
            if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
        ?>
        <div class="widget-top">
            <h2 class="widget-title"><?php echo $title; ?></h2>
        </div>
        <div class="list-term-tax">
            <ul id="city-district">
                
                <?php
                    foreach ($terms as $term) { $count++;
                ?>
                    <li class="cat-item closed cat-item-<?php echo $term->term_id; ?><?php if ($term_current->term_id == $term->term_id) { echo " current-cat"; } ?><?php if ($count>=$limit) { echo " not-rand hide"; } ?> ">

                        <a href="<?php echo get_term_link( $term->slug, 'city-realty' ); ?>">
                            <?php echo $term->name; ?>
                        </a>
                        <?php
                            $districts = get_terms(
                                'city-realty',
                                array(
                                    "parent" => $term->term_id,
                                    'hide_empty'            => 0
                                )
                            );
                            if ($districts) {
                                echo '<ul class="sub-menu">';
                                foreach($districts as $district) {
                                    printf(
                                        '<li class="%s"><a href="%s">%s</a></li>',
                                        $term_current->term_id == $district->term_id ? 'current-cat' : '',
                                        get_term_link( $district->term_id, 'city-realty' ),
                                        $district->name
                                    );
                                }
                                echo '</ul>';
                            }
                        ?>
                        <span class="toggle-caretc">Quận/Huyện</span>
                    </li>
                <?php
                    }
                ?>
                <li class="not-rand show-hide" id="dshow-all"><a title="tất cả" href="javascript:ShowDistrictLink(1);"> Tất cả [ <font style="color:#f87310;float:none;">+</font> ]</a></li>
                <li class="not-rand show-hide hide" id="dhide-all"><a title="thu gọn" href="javascript:ShowDistrictLink(0);"> Thu gọn [ <font style="color:#f87310;float:none;">-</font> ]</a></li>
            </ul>
        </div>
        <?php echo $after_widget; ?>
        <?php
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
        $instance['term_city'] =  $new_instance['term_city'];
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
        $term_city        = apply_filters ( 'term_city', isset ( $instance ['term_city'] ) ? $instance ['term_city'] : '' );
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

