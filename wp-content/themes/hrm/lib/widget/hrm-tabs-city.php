<?php
/*
* Author : DoBao
*/
class Hrm_Widget_Tabs_City extends WP_Widget
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
            'group_num'            => 1,
            'orderby'       => 'date',
            'order'         => 'DESC'
        );

        parent::__construct(
            'hrm-tabs-city',
            __( '[HRM] Tabs Thành Phố', 'hrm' ),
            array(
                'classname'   => 'hrm-tabs-city',
                'description' => __( 'Hiển thị danh sách các huyện theo tỉnh.', 'hrm' )
            ),
            array( 'width' => 505 , 'height' => 250 )
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
        echo $before_widget;
        ?>
        <div class="widget tabs-widget tabs-type">
            <ul class="nav nav-tabs" role="tablist">
                <?php for ( $i = 0; $i < $instance['group_num']; $i++ ) {
                    echo '<li role="presentation" ' .( $i == 1 ? 'class="active"' : '').'  >
                            <a href="#city'.($i + 1).'" aria-controls="city'.($i + 1).'" role="tab" data-toggle="tab">'.$instance['title'][$i].'</a>
                        </li>';
                } ?>
            </ul>
            <div class="tab-content">
                <?php for ( $i = 0; $i < $instance['group_num']; $i++ ) : ?>
                    <div role="tabpanel" class="tab-pane <?php if ($i==1) {echo 'active';} ?>" id="city<?php echo $i+1; ?>">
                        <div class="list-term-tax">
                            <ul>
                                <?php
                                    $args = array(
                                        'hide_empty'          => false,
                                        'orderby'             => $instance['orderby'][$i],
                                        'order'               => $instance['order'][$i],
                                        'parent'              => $instance['term_city'][$i],
                                        'number'              => $instance['limit'][$i],
                                    );
                                    $terms = get_terms('city-realty', $args);
                                    foreach ($terms  as $term) {
                                ?>
                                    <li class="cat-item cat-item-<?php echo $term->term_id; ?>">
                                        <a href="<?php echo get_term_link( $term->slug, 'city-realty' ); ?>">
                                            <?php echo $term->name; ?>
                                        </a>
                                    </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
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
        /** Merge with defaults */
        $instance = wp_parse_args( (array) $instance, $this->defaults );
        ?>

        <p style="background: #ccc; padding: 5px;">
            <label for="<?php echo $this->get_field_id( 'group_num' ); ?>"><?php _e( 'Number of support group', 'fit' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'group_num' ); ?>" name="<?php echo $this->get_field_name( 'group_num' ); ?>" value="<?php echo esc_attr( $instance['group_num'] ); ?>" size="2" />
            <input type="submit" name="savewidget" id="savewidget" class="button-secondary widget-control-save" value="Save" />
        </p>
        <?php for ( $i = 0; $i < $instance['group_num']; $i++ ) : ?>
        <div class="col-city">
            <div>
                <div>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'title'. $i ) ); ?>"><?php _e( 'Title '. $i, 'hrm' ); ?></label>
                        <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title'. $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title') ); ?>[]" value="<?php echo $instance['title'][$i]; ?>">
                    </p>
                    <p>
                        <input id="<?php echo esc_attr( $this->get_field_id( 'limit'. $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit') ); ?>[]" type="text" size="2" value="<?php echo $instance['limit'][$i]; ?>">
                        <label for="<?php echo esc_attr( $this->get_field_id( 'limit'. $i ) ); ?>"><?php _e( 'Number Of Posts ( 0 All )', 'hrm' ); ?></label>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('term_city'. $i); ?>"><?php _e('Type List:', 'hrm'); ?></label>
                        <select id="<?php echo $this->get_field_id('term_city'. $i); ?>"  name="<?php echo $this->get_field_name('term_city'); ?>[]">
                            <?php
                            $cats1 = get_categories(
                                array(
                                    'hide_empty' => 0,
                                    'taxonomy' => 'city-realty',
                                    'parent' => 0,
                                    'hierarchical' => true
                                )
                            );
                            foreach ($cats1 as $cat1) {
                                echo '<option value="' . $cat1->term_id . '" ' .( $cat1->term_id == $instance['term_city'][$i] ? 'selected="selected"' : '' ). '>' . $cat1->name . '</option>';
                            }
                            ?>
                        </select>
                    </p>
                    <p><label for="<?php echo $this->get_field_id('orderby'. $i); ?>"><?php _e('Sorted by:', 'hrm'); ?></label>
                      <select id="<?php echo $this->get_field_id('orderby'. $i); ?>"  name="<?php echo $this->get_field_name('orderby'); ?>[]">
                         <option value="date"
                         <?php echo 'date' ==  $instance['orderby'][$i] ? 'selected="selected"' : '' ?>><?php _e('Date', 'hrm'); ?></option>
                         <option value="ID"
                         <?php echo 'ID' == $instance['orderby'][$i] ? 'selected="selected"' : '' ?>><?php _e('ID', 'hrm'); ?></option>
                         <option value="title"
                         <?php echo 'title' == $instance['orderby'][$i] ? 'selected="selected"' : '' ?>><?php _e('Title', 'hrm'); ?></option>
                         <option value="rand"
                         <?php echo 'rand' == $instance['orderby'][$i] ? 'selected="selected"' : '' ?>><?php _e('Random', 'hrm'); ?></option>
                        </select>
                    </p>

                    <p>
                        <label for="<?php echo $this->get_field_id('order'. $i); ?>"><?php _e('Sorting criteria:', 'hrm'); ?></label>
                        <select id="<?php echo $this->get_field_id('order'. $i); ?>" name="<?php echo $this->get_field_name('order'); ?>[]">
                            <option value="DESC"
                            <?php echo 'DESC' == $instance['order'][$i] ? 'selected="selected"' : '' ?>><?php _e('DESC:', 'hrm'); ?></option>
                            <option value="ASC"
                            <?php echo 'ASC' == $instance['order'][$i] ? 'selected="selected"' : '' ?>><?php _e('ASC:', 'hrm'); ?></option>
                        </select>
                    </p>
                </div>
            </div>
        </div>
        <?php endfor; ?>


        <div style="clear: both;"></div>
        <?php
    }

}

