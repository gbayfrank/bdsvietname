<?php
/**
 * Ham Rong Media functions and definitions.
 * @package Ham_Rong_Media
 * 
 */

define( 'THEME_VERSION', '1.0' );
define( 'HOME_URL', trailingslashit( home_url() ) );
define( 'THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'THEME_URL', trailingslashit( get_template_directory_uri() ) );

/**
 * HRM Theme Options
 */
if ( ! class_exists('ReduxFramework') ) {
	require_once( dirname( __FILE__ ) . '/ReduxCore/framework.php' );
}
if ( ! isset( $ready_theme ) ) {
	require_once( dirname( __FILE__ ) . '/ReduxCore/admin-init.php' );
}
/** remove redux menu under the tools **/
add_action( 'admin_menu', 'remove_redux_menu',12 );
function remove_redux_menu() {
	remove_submenu_page( 'tools.php','redux-about' );
}
if ( ! function_exists( 'hrm_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function hrm_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'hrm', THEME_DIR . '/languages' );

	// Add theme support
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list','gallery', 'caption',
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Menu Chính', 'hrm' ),
		'menu-thanhvien' => esc_html__( 'Menu Thành viên', 'hrm' ),
		'menu_footer' => esc_html__( 'Menu Footer', 'hrm' ),
	) );
}
endif;
add_action( 'after_setup_theme', 'hrm_setup' );

/**
 *
 * @global int $content_width
 */
function hrm_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hrm_content_width', 640 );
}
add_action( 'after_setup_theme', 'hrm_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function hrm_scripts() {
	wp_enqueue_style('bootstrap' , THEME_URL . 'css/bootstrap.min.css');
	wp_enqueue_style('fontawesome' , THEME_URL . 'css/font-awesome.min.css');
	wp_enqueue_style('owl-css' , THEME_URL . 'css/owl.css');
	wp_enqueue_style('ui-css' , THEME_URL . 'css/jquery-ui.min.css');
	wp_enqueue_style('select2-css' , THEME_URL . 'css/select2.min.css');
	wp_enqueue_style( 'hrm-style', get_stylesheet_uri() );

	wp_enqueue_script( 'navigation-skiplinkfocus', THEME_URL . '/js/navigation.min.js', array(), '20151215', true );
	wp_enqueue_script( 'fancybox' , THEME_URL . 'js/jquery.fancybox.min.js', array('jquery'), '3.1.20',true );
	wp_enqueue_script( 'bootstrap_js' , THEME_URL . 'js/bootstrap.min.js', array('jquery'), false,true );
	wp_enqueue_script( 'js_owl' , THEME_URL . 'js/owl.min.js', array('jquery'), false,true );
	wp_enqueue_script( 'jquery_ui' , THEME_URL . 'js/jquery-ui.min.js', array('jquery'), false,true );
	wp_enqueue_script( 'jquery_lazy' , THEME_URL . 'js/lazy-load.js', array('jquery'), false,true );
	wp_enqueue_script( 'datepicker' , THEME_URL . 'js/jquery.ui.datepicker-vi-VN.js', array('jquery'), false,true );
	wp_enqueue_script( 'js_marquee' , THEME_URL . 'js/jquery.marquee.min.js', array('jquery'), false,true );

	wp_enqueue_script( 'js_tinhthanh' , HOME_URL . 'cnd/tinhthanh.js', array('jquery'), false,true );
	wp_enqueue_script( 'js_tinhthanhp' , HOME_URL . 'cnd/tinhthanhp.js', array('jquery'), false,true );
	global $hrm_options;
	if ($hrm_options['hrm_api_map']) {
		wp_enqueue_script( 'map_api' , '//maps.googleapis.com/maps/api/js?key='.$hrm_options['hrm_api_map'].'&libraries=places&sensor=false', array(), true,true );
	}
	wp_enqueue_script( 'js_select2' , THEME_URL . 'js/select2.full.min.js', array('jquery'), false,true );

	wp_enqueue_script( 'js_map' , THEME_URL . 'js/map.js', array('jquery','map_api'), false,true );
	wp_enqueue_script( 'js_district_map' , THEME_URL . 'js/district.js', array('jquery'), false,true );
	wp_enqueue_script( 'hrm-js' , THEME_URL . 'js/hrm-custom.js', array('jquery'), false,true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hrm_scripts' );

/**
 * Implement the Custom Header feature.
 */
require THEME_DIR . '/inc/custom-header.php';
require THEME_DIR . '/inc/template-tags.php';
require THEME_DIR . '/inc/extras.php';
require THEME_DIR . '/inc/customizer.php';

/**
 * Hrm custom Theme.
*/

add_image_size( 'vertical-slider' , 757 , 570 , true );
add_image_size( 'post-news', 445, 295, true );
add_image_size( 'realty-thumbnail', 160 , 120, true );

add_filter( 'image_size_names_choose', 'hrm_custom_sizes' );

function hrm_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'vertical-slider'  => __( 'Vertical Slider' ),
		'post-news'        => __( 'Post News' ),
		'realty-thumbnail' => __( 'Realty Thumbnail' ),
	) );
}

// add_image_size( 'dashboard-thumbnail', 50 , 50, true );
// remove image size
add_filter( 'intermediate_image_sizes_advanced', 'prefix_remove_default_images', 9999 );
// Remove default image sizes here. 
function prefix_remove_default_images( $sizes ) {
	unset( $sizes['small']); // 150px
	unset( $sizes['medium']); // 300px
	unset( $sizes['large']); // 1024px
	unset( $sizes['medium_large']); // 768px
	return $sizes;
}
/*
* Remove title archive
*/
add_filter( 'get_the_archive_title', function ($title) {
	if ( is_category()) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>' ;
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}
	return $title;

});

require THEME_DIR . 'lib/theme-functions.php';
add_filter( 'widget_text', 'do_shortcode' );
function create_shortcode_terminal($vip) {
	$vip = $vip['vip'];
	if ( $vip == 1) {
		$terminal_query = new WP_Query(array(
			'posts_per_page' => 10,
			'post_status'         => 'publish',
			'post_type'           => 'realty',
			'meta_key' => 'vip_type',
			'meta_value' => 1
		));
	} else {
		$terminal_query = new WP_Query(array(
			'posts_per_page' => 10,
			'post_status'         => 'publish',
			'post_type'           => 'realty',
		));
	}
	ob_start();
	if ( $terminal_query->have_posts() ) :
	echo '<div class="list-realty "><ul>';
	while ( $terminal_query->have_posts() ) : $terminal_query->the_post();?>
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
		echo number_format($prince_realty,0,",",".") .' '.$key;
	} elseif ($prince_realty) {
		echo number_format($prince_realty,0,",",".") .' '.$par_value;
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
	endwhile; ?>
<?php if($vip == 0) { ?>
<div class="btnxemthem" style="float:right;">
	<a href="<?php echo get_post_type_archive_link( 'realty' ); ?>"><?php _e('Xem Thêm','hrm'); ?></a>
</div>
<?php } ?>
<style>
	.btnxemthem a {
		background: #FF9800;
		padding: 5px 10px;
		color: #fff;
	}
	.btnxemthem a:hover {
		color: #fff;
		background: red;
	}
</style><?php
	echo '</ul></div>';
	endif;
	$list_post = ob_get_contents(); //Lấy toàn bộ nội dung phía trên bỏ vào biến $list_post để return

	ob_end_clean();

	return $list_post;
}
add_shortcode('bang-tin', 'create_shortcode_terminal');
/*-----------------------------------------------------------------------------------*/
/**
 * count view post
 * @since 1.0.0
 */
function postview_set($postID) {
	$count_key = 'postview_number';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

function postview_get($postID){
	$count_key = 'postview_number';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}
function ViewSource($url){
	$ch      = curl_init();
	$timeout = 3;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.69 Safari/537.36");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 1200);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
// get url page
add_action('wp_ajax_xoaimage', 'xoaimage');
add_action('wp_ajax_nopriv_xoaimage', 'xoaimage');
function xoaimage() {
	if(isset($_POST['id'])){
		wp_delete_attachment( $_POST['id'] );
		echo '<script>alert("Xóa thành công");</script>';
	} // end if
}
add_action('wp_ajax_duyetbai', 'duyetbai');
add_action('wp_ajax_nopriv_duyetbai', 'duyetbai');

// get location maps

function get_infor_from_address($address = null) {
	$prepAddr = str_replace(' ', '+', stripUnicode($address));
	$geocode = file_get_contents('//maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
	$output = json_decode($geocode);
	return $output;
}

// Loại bỏ dấu tiếng Việt để cho kết quả chính xác hơn
function stripUnicode($str){
	if (!$str) return false;
	$unicode = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'd'=>'đ|Đ',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ'
	);
	foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
	return $str;
}
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

// dang tin
add_action( 'wp_ajax_dang_tin', 'dang_tin_ajax' );
add_action( 'wp_ajax_nopriv_dang_tin', 'dang_tin_ajax' );
function dang_tin_ajax() {
	global $wpdb, $hrm_options;
	$current_user = wp_get_current_user(); // grabs the user info and puts into vars
	$user_id = get_current_user_id();
	// needed for image uploading and deleting to work
	if (defined('ABSPATH')) {
		include_once (ABSPATH . 'wp-admin/includes/file.php');
		include_once (ABSPATH . 'wp-admin/includes/image.php');
	} else {
		include_once ('../wp-admin/includes/file.php');
		include_once ('../wp-admin/includes/image.php');
	}
	$meta = array(
		'address'       => isset( $_POST['address'] ) ? $_POST['address'] : '',
		'gallery'       => isset( $_POST['gallery'] ) ? $_POST['gallery'] : array(),
		'location'      => isset( $_POST['location'] ) ? $_POST['location'] : '',
		'location_lat'  => isset( $_POST['location_lat'] ) ? $_POST['location_lat'] : '',
		'location_lng'  => isset( $_POST['location_lng'] ) ? $_POST['location_lng'] : '',
	);
	if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		if(trim($_POST['postTitle']) === '') {
			$postTitleError = 'Vui lòng điền tiêu đề.';
			$hasError       = true;
		} else {
			$postTitle = trim($_POST['postTitle']);
		}
	
		if($hasError != true) {
			if(is_super_admin() ){
				$postStatus = 'publish';
			}elseif(!is_super_admin()){
				$postStatus = 'pending';
			}            
			$post_information = array(
				'ID'             => $current_post,
				'post_content'   => strip_tags($_POST['postContent'], '<a><h1><h2><h3><strong><b>'),
				'post_title'     => esc_attr(strip_tags($_POST['postTitle'])),
				'post_type'      => 'realty',
				'comment_status' => 'open',
				'ping_status'    => 'open',
				'post_status'    => $postStatus,
				'post_author'    => $user_id,
			);
			$post_id = wp_insert_post($post_information);
	
				// update meta field
				/*
				* update custom field realty info
				*/
				update_post_meta($post_id, '_sku', esc_attr( $post_id ) );
	
				update_post_meta($post_id, 'address', wp_kses($_POST['address'], $allowed));
				update_post_meta($post_id, 'street', wp_kses($_POST['street'], $allowed));
				update_post_meta($post_id, 'street_ko_dau', wp_kses(stripUnicode($_POST['street']), $allowed));
				update_post_meta($post_id, 'label', wp_kses($_POST['label_price'], $allowed));
				update_post_meta($post_id, 'price-realty', wp_kses($_POST['post_price'], $allowed));
				update_post_meta($post_id, 'par_value', wp_kses($_POST['par_value'], $allowed)); //antopho đang sưa
				update_post_meta($post_id, 'label_after', wp_kses($_POST['label_after'], $allowed));
				wp_set_object_terms( $post_id, $_POST['khoang-gia'], 'khoang-gia' );
				update_post_meta($post_id, 'p_rent', wp_kses($_POST['p_rent'], $allowed));
				update_post_meta($post_id, 'begin_date', date('d-m-Y') );
				update_post_meta($post_id, 'width', wp_kses($_POST['post_width'], $allowed));
				update_post_meta($post_id, 'long', wp_kses($_POST['post_long'], $allowed));
				update_post_meta($post_id, 'width2', wp_kses($_POST['post_width2'], $allowed));
				update_post_meta($post_id, 'area-realty', wp_kses($_POST['post_area'], $allowed));
				update_post_meta($post_id, 'sizeuse', wp_kses($_POST['post_sizeuse'], $allowed));
				update_post_meta($post_id, 'floor', wp_kses($_POST['floor'], $allowed));
				update_post_meta($post_id, 'realty-bedroom', wp_kses($_POST['post_bedroom'], $allowed));
				update_post_meta($post_id, 'note', wp_kses($_POST['note'], $allowed));
				update_post_meta($post_id, 'room_wc', wp_kses($_POST['room_wc'], $allowed));
				update_post_meta($post_id, 'incomehas', wp_kses($_POST['incomehas'], $allowed));
				update_post_meta($post_id, 'income', wp_kses($_POST['income'], $allowed));
				if( isset($_POST['hemoto']) ){
					update_post_meta($post_id, "hemoto", true );
				}else{
					delete_post_meta($post_id, "hemoto");
				}
				if( isset($_POST['car_in']) ){
					update_post_meta($post_id, "car_in", true );
				}else{
					delete_post_meta($post_id, "car_in");
				}
				if( isset($_POST['elevator']) ){
					update_post_meta($post_id, "elevator", true );
				}else{
					delete_post_meta($post_id, "elevator");
				}
				if( isset($_POST['interior']) ){
					update_post_meta($post_id, "interior", true);
				}else{
					delete_post_meta($post_id, "interior");
				}
				if( isset($_POST['basement']) ){
					update_post_meta($post_id, "basement", true);
				}else{
					delete_post_meta($post_id, "basement");
				}
				update_post_meta($post_id, 'interiorwhat', wp_kses($_POST['interiorwhat'], $allowed));
				update_post_meta($post_id, 'strtwidth', wp_kses($_POST['strtwidth'], $allowed));
				update_post_meta($post_id, 'stair', wp_kses($_POST['stair'], $allowed));
				wp_set_object_terms( $post_id, $_POST['quarter-realty'], 'quarter' );
				update_post_meta($post_id, 'tim_map', wp_kses($_POST['map_address'], $allowed));
			   /*
				* update custom field realty contact
				*/
			   update_post_meta($post_id, 'tenchunha', wp_kses($_POST['post_name_contact'], $allowed));
			   update_post_meta($post_id, 'mobile', wp_kses($_POST['post_phone_contact'], $allowed));
			   update_post_meta($post_id, 'affiliate', wp_kses($_POST['post_affiliate'], $allowed));
			   update_post_meta($post_id, 'support', wp_kses($_POST['post_support'], $allowed));
			   update_post_meta($post_id, 'end_date', wp_kses($_POST['end_date'], $allowed));
			   update_post_meta($post_id, 'p_status', wp_kses($_POST['post_p_status'], $allowed));
	
			   if( isset($_POST['sold']) ) {
				update_post_meta($post_id, "sold", true );
			} else{
				delete_post_meta($post_id, "sold");
			}
	
			foreach( $meta as $key => $value )
			{
				$meta[$key] = get_post_meta( $realty['ID'], $key, true );
			}
			$location = explode( ',', $meta['location']);
			$meta['location_lat'] = @$location[0];
			$meta['location_lng'] = @$location[1];
			update_post_meta( $post_id, 'location', $_POST['location_lat'] . ',' . $_POST['location_lng'] );
	
			update_post_meta( $post_id, 'type-term', $_POST['type-realty'] );
				/*
				* Update term realty
				*/
				wp_set_object_terms( $post_id, $_POST['term-type'], $_POST['type-realty'] );
				$city_slug     = get_term( $_POST['city'], 'city-realty')->slug;
				$district_slug = get_term( $_POST['district'], 'city-realty')->slug;
				$ward_slug     = get_term( $_POST['ward'], 'city-realty')->slug;
				wp_set_object_terms( $post_id, array($city_slug,$district_slug, $ward_slug), 'city-realty' );
				
				$permalink = get_permalink( $post_id );
				delete_post_meta( $post_id, 'gallery' );
				delete_post_meta( $post_id, 'legaldoc' );
				if(isset($_FILES['bdsImages'])) {
					// Xoa anh
					if(isset($_POST['deleteImageBDS'])) {
						foreach($_POST['deleteImageBDS'] as $key => $deleteNameItem) {
							$index = array_keys($_FILES['bdsImages']['name'], $deleteNameItem);
							unset($_POST['deleteImageBDS'][$key]);
							unset($_FILES['bdsImages']['name'][$index[0]]);
							unset($_FILES['bdsImages']['type'][$index[0]]);
							unset($_FILES['bdsImages']['tmp_name'][$index[0]]);
							unset($_FILES['bdsImages']['error'][$index[0]]);
							unset($_FILES['bdsImages']['size'][$index[0]]);
						}
					}
					// Tien hanh upload
					foreach($_FILES['bdsImages']['name'] as $key => $image_name) {
						$image_data['name']     = $image_name;
						$image_data['tmp_name'] = $_FILES['bdsImages']["tmp_name"][$key];
						$image_data['type']     = $_FILES['bdsImages']["type"][$key];
						$image_data['error']    = $_FILES['bdsImages']["error"][$key];
						$image_data['size']     = $_FILES['bdsImages']["size"][$key];
						uploadImage($image_data, $post_id);
					}
				}
	
				if(isset($_FILES['sdshImage1'])) {
					uploadImage($_FILES['sdshImage1'], $post_id, 'legaldoc');
				}
	
				if(isset($_FILES['sdshImage2'])) {
					uploadImage($_FILES['sdshImage2'], $post_id, 'legaldoc');
				}
	
			//wp_redirect( home_url('/dang-nhap'));
			if($hrm_options['hrm_put_bill'] == 1 && !is_super_admin()) {
				wp_redirect( home_url('thanh-toan/?post_id=' . $post_id) );
			} else {
				wp_redirect( home_url('tin-da-dang') );
			}
		
			$url = ($hrm_options['hrm_put_bill'] == 1 && !is_super_admin()) ? home_url('thanh-toan/?post_id='). $post_id : home_url('tin-da-dang');
			$result = array(
				'sucess' => true,
				'url' => $url
			);
			echo json_encode($result);
		} else {
			echo json_encode(['sucess' => false]);
		}
	} else {
		echo json_encode(['sucess' => false]);
	}
	wp_die();
}

function uploadImage($image_data, $post_id, $add_post_meta = 'gallery') {
    $image_name     = str_replace(" ", "-", basename($image_data['name']));

    $wordpress_upload_dir = wp_upload_dir();
    $i = 1;
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $image_name;
    $new_file_mime = mime_content_type( $image_data['tmp_name'] );
    if( empty( $image_data ) )
	    return false;

    if( $image_data['error'] )
        return false;
        
    if( $image_data['size'] > wp_max_upload_size() )
        return false;
        
    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
        return false;
        
    while( file_exists( $new_file_path ) ) {
        $i++;
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $image_data['name'];
    }

    if( move_uploaded_file( $image_data['tmp_name'], $new_file_path ) ) {
        $upload_id = wp_insert_attachment( array(
            'guid'           => $new_file_path, 
            'post_mime_type' => $new_file_mime,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', $image_data['name'] ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ), $new_file_path );
    
        // Generate and save the attachment metas into the database
        $attach_data = wp_generate_attachment_metadata( $upload_id, $new_file_path );
        wp_update_attachment_metadata( $upload_id, $attach_data );
        add_post_meta( $post_id, $add_post_meta, $upload_id, false );
        $checki      = get_the_post_thumbnail( $post_id );
        if(!$checki) {
            $res2 = set_post_thumbnail( $post_id, $upload_id );
        }
    }

    return true;
}
?>