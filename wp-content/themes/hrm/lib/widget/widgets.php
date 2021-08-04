<?php
include ('hrm-show-post-home.php');
include ('hrm-post-tabs.php');
include ('hrm-type-tabs.php');
include ('hrm-form-tabs.php');
include ('hrm-realty-highlights.php');
include ('hrm-recent-post.php');
include ('hrm-list-term.php');
include ('hrm-city-district.php');
include ('hrm-term-city.php');
include ('hrm-tabs-city.php');
include ('hrm-list-city.php');
include ('hrm-show-widget-realty.php');
// include ('hrm-list-tin-vip-nb.php');
include ('hrm-du-an-post.php');
// include ('hrm-bds-feature.php');
// include ('support-online-widget.php');
include ('hrm-list-tin-nb.php');
include ('hrm-list-tin-vip.php');


add_action( 'widgets_init', 'hrm_register_widgets' );
/**
 * Register widgets
 *
 * @return void
 * @since 1.0
 */
function hrm_register_widgets()
{
	register_widget( 'Hrm_Show_Posts_Home' );
    // register_widget( 'Hrm_Show_BDS_Feature' );
	register_widget('Hrm_Post_Tabs');
    register_widget('Hrm_Type_Tabs');
    register_widget('Hrm_Widget_Tabs_City');
    register_widget('Hrm_Widget_List_City' );
    register_widget('Hrm_Form_Tabs');
	register_widget('Hrm_Widget_Realty_Highlights');
	register_widget('Hrm_Widget_Recent_Posts' );
	register_widget( 'Hrm_Widget_Tax_Realty' );
    register_widget( 'Hrm_Widget_Term_City' );
    register_widget('Hrm_Widget_Term_City_District');
    register_widget('Hrm_Widget_Widget_Realty');
    // register_widget('Hrm_tin_dac_biet');
    register_widget('Hrm_Widget_DA_Posts');
    register_widget('Hrm_tin_nb');
    register_widget('Hrm_tin_vip');
    // register_widget('HRM_Online_Support_Widget');
}
