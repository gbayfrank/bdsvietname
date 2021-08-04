<?php
/**
 * Tab widget class
 * Author :DoBao
 */
class Hrm_Type_Tabs extends WP_Widget
{
    /**
     * Holds widget settings defaults, populated in constructor.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Class constructor
     * Set up the widget
     *
     * @return Hrm_Post_Tabs
     */
    function __construct()
    {
        $this->defaults = array(
            'title_1'      => '',
            'limit_1'     => 5,

            'title_2'      => '',
            'limit_2'     => 5,

            'title_3'      => '',
            'limit_3'     => 5,
        );

        parent::__construct(
            'hrm-tabs-type',
            __( '[HRM] Type Tabs', 'hrm' ),
            array(
                'classname'   => 'tabs-widget',
                'description' => __( 'Hiển thị filter type', 'hrm' ),
            ),
            array(
                'width'  => 770,
                'height' => 350,
            )
        );
    }
    /**
     *
     * @return void
     */
    function widget( $args, $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
        extract( $instance );
        
    ?>
        <div class="widget tabs-widget tabs-type">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?php echo $style_1; ?> active">
                    <a href="#term_type1" aria-controls="term_type1" role="tab" data-toggle="tab">
                        <?php echo $title_1; ?>
                    </a>
                </li>
                <li role="presentation" class="<?php echo $style_2; ?>">
                    <a href="#term_type2" aria-controls="term_type2" role="tab" data-toggle="tab">
                        <?php echo $title_2; ?>
                    </a>
                </li>
                <li role="presentation" class="<?php echo $style_3; ?>">
                    <a href="#term_type3" aria-controls="term_type3" role="tab" data-toggle="tab">
                        <?php echo $title_3; ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="term_type1">
                    <ul class="list-term-tax">
                        <?php
                            $args_1 = array(
                                'hide_empty'          => 0,
                                'number'              => $limit_1,
                                'parent'              => 0,
                            );
                            $terms1 = get_terms( $style_1, $args_1);
                            $current_term1 = get_the_terms( $post->ID , $style_1 );
                            $queried_object = get_queried_object();
                            $current = "";
                        ?>
                        <?php foreach ($terms1 as $term) : ?>
                            <?php if ($current_term1 && is_single()) : ?>
                                <?php
                                    foreach ($current_term1 as $hihi) {
                                        if ($hihi->term_id == $term->term_id) {
                                            $current = 'current-cat';
                                        } else {
                                            $current = '';
                                        }
                                        printf(
                                            '<li class="cat-item cat-item-%1s %2s">
                                                <a href="%3s">%4s</a>
                                            </li>',
                                            $term->term_id,
                                            $current,
                                            get_term_link( $term->slug, $style_1 ),
                                            $term->name
                                        );
                                    }
                                ?>
                            <?php else : ?>
                                <?php
                                    if ($queried_object->term_id == $term->term_id) {
                                        $current = "current-cat";
                                    } else {
                                        $current = "";
                                    };
                                    printf(
                                        '<li class="cat-item cat-item-%1s %2s">
                                            <a href="%3s">%4s</a>
                                        </li>',
                                        $term->term_id,
                                        $current,
                                        get_term_link( $term->slug, $style_1 ),
                                        $term->name
                                    );
                                ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane" id="term_type2">
                    <ul class="list-term-tax">
                        <?php
                            $args_2 = array(
                                'hide_empty'          => 0,
                                'number'              => $limit_2,
                                'parent'              => 0,
                            );
                            $terms2 = get_terms( $style_2, $args_2);
                            $current_term2 = get_the_terms( $post->ID , $style_2 );
                            $queried_object = get_queried_object();
                            $current = "";
                        ?>
                        <?php foreach ($terms2 as $term) : ?>
                            <?php if ($current_term2 && is_single()) : ?>
                                <?php
                                    foreach ($current_term2 as $hihi) {
                                        if ($hihi->term_id == $term->term_id) {
                                            $current = 'current-cat';
                                        } else {
                                            $current = '';
                                        }
                                        printf(
                                            '<li class="cat-item cat-item-%1s %2s">
                                                <a href="%3s">%4s</a>
                                            </li>',
                                            $term->term_id,
                                            $current,
                                            get_term_link( $term->slug, $style_2 ),
                                            $term->name
                                        );
                                    }
                                ?>
                            <?php else : ?>
                                <?php
                                    if ($queried_object->term_id == $term->term_id) {
                                        $current = "current-cat";
                                    } else {
                                        $current = "";
                                    };
                                    printf(
                                        '<li class="cat-item cat-item-%1s %2s">
                                            <a href="%3s">%4s</a>
                                        </li>',
                                        $term->term_id,
                                        $current,
                                        get_term_link( $term->slug, $style_2 ),
                                        $term->name
                                    );
                                ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane" id="term_type3">
                    <ul class="list-term-tax">
                        <?php
                            $args_3 = array(
                                'hide_empty'          => 0,
                                'number'              => $limit_3,
                                'parent'              => 0,
                            );
                            $terms3 = get_terms( $style_3, $args_3);
                            $current_term3 = get_the_terms( $post->ID , $style_3 );
                            $queried_object = get_queried_object();
                            $current = "";
                        ?>
                        <?php foreach ($terms3 as $term) : ?>
                            <?php if ($current_term3 && is_single()) : ?>
                                <?php
                                    foreach ($current_term3 as $hihi) {
                                        if ($hihi->term_id == $term->term_id) {
                                            $current = 'current-cat';
                                        } else {
                                            $current = '';
                                        }
                                        printf(
                                            '<li class="cat-item cat-item-%1s %2s">
                                                <a href="%3s">%4s</a>
                                            </li>',
                                            $term->term_id,
                                            $current,
                                            get_term_link( $term->slug, $style_3 ),
                                            $term->name
                                        );
                                    }
                                ?>
                            <?php else : ?>
                                <?php
                                    if ($queried_object->term_id == $term->term_id) {
                                        $current = "current-cat";
                                    } else {
                                        $current = "";
                                    };
                                    printf(
                                        '<li class="cat-item cat-item-%1s %2s">
                                            <a href="%3s">%4s</a>
                                        </li>',
                                        $term->term_id,
                                        $current,
                                        get_term_link( $term->slug, $style_3 ),
                                        $term->name
                                    );
                                ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php
        echo $after_widget;

    }
    /**
     * Sanitize widget form values as they are saved
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array Updated safe values to be saved
     */
    function update( $new_instance, $old_instance )
    {
        return $new_instance;
    }


    /**
     * Displays the widget options
     *
     * @param array $instance
     *
     * @return void
     */
    function form( $instance )
    {
        $instance = wp_parse_args( $instance, $this->defaults );
        ?>
    <div style="float: left; width: 233px; border: 1px solid #DDD; padding: 10px 10px 0px 10px;">
        <p><strong><?php _e( 'Tab thứ 1', 'hrm' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_1' ) ); ?>" type="text" value="<?php echo $instance['title_1']; ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('style_1'); ?>"><?php _e('Chọn kiểu hiển thị:', 'hrm'); ?> </label>
            <select id="<?php echo $this->get_field_id('style_1'); ?>" name="<?php echo $this->get_field_name('style_1'); ?>">

                <option value="realty-sell" <?php echo 'realty-sell' == $instance ['style_1'] ? 'selected="selected"' : '' ?>><?php _e('Cần bán', 'hrm'); ?></option>
                <option value="realty-rent" <?php echo 'realty-rent' == $instance ['style_1'] ? 'selected="selected"' : '' ?>><?php _e('Cho thuê', 'hrm'); ?></option>
                <option value="realty-transfer" <?php echo 'realty-transfer' == $instance ['style_1'] ? 'selected="selected"' : '' ?>><?php _e('Sang nhượng', 'hrm'); ?></option>
            </select>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'limit_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit_1' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit_1']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit_1' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
        </p>

        <div style="clear: both;"></div>
    </div>
    <div style="float: left; width: 233px; border: 1px solid #DDD; padding: 10px 10px 0px 10px;">
        <p><strong><?php _e( 'Tab thứ 2', 'hrm' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_2' ) ); ?>" type="text" value="<?php echo $instance['title_2']; ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('style_2'); ?>"><?php _e('Chọn kiểu hiển thị:', 'hrm'); ?> </label>
            <select id="<?php echo $this->get_field_id('style_2'); ?>" name="<?php echo $this->get_field_name('style_2'); ?>">

                <option value="realty-sell" <?php echo 'realty-sell' == $instance ['style_2'] ? 'selected="selected"' : '' ?>><?php _e('Cần bán', 'hrm'); ?></option>
                <option value="realty-rent" <?php echo 'realty-rent' == $instance ['style_2'] ? 'selected="selected"' : '' ?>><?php _e('Cho thuê', 'hrm'); ?></option>
                <option value="realty-transfer" <?php echo 'realty-transfer' == $instance ['style_2'] ? 'selected="selected"' : '' ?>><?php _e('Sang nhượng', 'hrm'); ?></option>
                <option value="theo-gia" <?php echo 'theo-gia' == $instance ['style_2'] ? 'selected="selected"' : '' ?>><?php _e('Theo giá', 'hrm'); ?></option>
                <option value="dien-tich" <?php echo 'dien-tich' == $instance ['style_2'] ? 'selected="selected"' : '' ?>><?php _e('Diện tích', 'hrm'); ?></option>
            </select>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'limit_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit_2' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit_2']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit_2' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
        </p>

        <div style="clear: both;"></div>
    </div>

    <div style="float: left; width: 233px; border: 1px solid #DDD; padding: 10px 10px 0px 10px;">
        <p><strong><?php _e( 'Tab thứ 3', 'hrm' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_3' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_3' ) ); ?>" type="text" value="<?php echo $instance['title_3']; ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('style_3'); ?>"><?php _e('Chọn kiểu hiển thị:', 'hrm'); ?> </label>
            <select id="<?php echo $this->get_field_id('style_3'); ?>" name="<?php echo $this->get_field_name('style_3'); ?>">

                <option value="realty-sell" <?php echo 'realty-sell' == $instance ['style_3'] ? 'selected="selected"' : '' ?>><?php _e('Cần bán', 'hrm'); ?></option>
                <option value="realty-rent" <?php echo 'realty-rent' == $instance ['style_3'] ? 'selected="selected"' : '' ?>><?php _e('Cho thuê', 'hrm'); ?></option>
                <option value="realty-transfer" <?php echo 'realty-transfer' == $instance ['style_3'] ? 'selected="selected"' : '' ?>><?php _e('Sang nhượng', 'hrm'); ?></option>
                <option value="theo-gia" <?php echo 'theo-gia' == $instance ['style_3'] ? 'selected="selected"' : '' ?>><?php _e('Theo giá', 'hrm'); ?></option>
                <option value="dien-tich" <?php echo 'dien-tich' == $instance ['style_3'] ? 'selected="selected"' : '' ?>><?php _e('Diện tích', 'hrm'); ?></option>
            </select>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'limit_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit_3' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit_3']; ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit_3' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
        </p>

        <div style="clear: both;"></div>
    </div>
        <?php
    }
}