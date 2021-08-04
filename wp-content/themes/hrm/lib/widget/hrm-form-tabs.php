<?php
/**
 * Tab widget class
 * Author :DoBao
 */
class Hrm_Form_Tabs extends WP_Widget
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
     * @return Hrm_Form_Tabs
     */
    function __construct()
    {
        $this->defaults = array(
            'title_1'      => '',
            'form_1'     => '',


            'title_2'      => '',
            'form_2'     => '',
        );

        parent::__construct(
            'hrm-tabs-forms',
            __( '[HRM] Forms Tabs', 'hrm' ),
            array(
                'classname'   => 'tabs-form',
                'description' => __( 'Hiển thị form theo tab', 'hrm' ),
            ),
            array(
                'width'  => 515,
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
        echo '<div class="widget tabs-widget forms-tabs">';
        printf( '
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#form1" aria-controls="form1" role="tab" data-toggle="tab">%s</a></li>
                <li role="presentation"><a href="#form2" aria-controls="form2" role="tab" data-toggle="tab">%s</a></li>
            </ul>',
            $title_1,
            $title_2
        );

        ?>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="form1">
                <?php
                    if($form_1) {
                        echo do_shortcode( $form_1 );
                    } else {
                        echo 'Chưa có form';
                    }
                ?>
                
            </div>
            <div role="tabpanel" class="tab-pane" id="form2">
                <?php
                    if($form_2) {
                        echo do_shortcode( $form_2 );
                    } else {
                        echo 'Chưa có form';
                    }
                ?>
                
            </div>
        </div>
    </div>
    <?php
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
        $instance                  = $old_instance;
        $instance['title_1']         = strip_tags( $new_instance['title_1'] );
        $instance['form_1']         = strip_tags( $new_instance['form_1'] );

        $instance['title_2']         = strip_tags( $new_instance['title_2'] );
        $instance['form_2']         = strip_tags( $new_instance['form_2'] );
        return $instance;
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
        <p><strong><?php _e( 'Form 1', 'hrm' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_1' ) ); ?>" type="text" value="<?php echo $instance['title_1']; ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'form_1' ) ); ?>"><?php _e( 'Shortcode Form', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'form_1' ) ); ?>" type="text" value="<?php echo $instance['form_1']; ?>">
        </p>

        <div style="clear: both;"></div>
    </div>
    <div style="float: left; width: 233px; border: 1px solid #DDD; padding: 10px 10px 0px 10px;">
        <p><strong><?php _e( 'Form 2', 'hrm' ); ?></strong></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_2' ) ); ?>" type="text" value="<?php echo $instance['title_2']; ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'form_2' ) ); ?>"><?php _e( 'Shortcode Form', 'hrm' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'form_2' ) ); ?>" type="text" value="<?php echo $instance['form_2']; ?>">
        </p>

        <div style="clear: both;"></div>
    </div>
        <?php
    }
}
