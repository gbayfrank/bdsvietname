<?php
/**
 * 
 */
if(!is_user_logged_in()) {
	wp_redirect( home_url('/dang-nhap'));
}
nocache_headers(); // don't cache anything
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
get_header(); ?>
<?php
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
            for ($i=1; $i <= 16; $i++) { 
                $name_upload = "image_upload".$i;
                if($_FILES[$name_upload]["name"]){
                    $image_name     = $_FILES[$name_upload]["name"];
                    $image_name     = str_replace(" ", "-", basename($image_name));
                    $image_path     = $_FILES[$name_upload]["tmp_name"];
                    $new_image_path = './images/'.$image_name;
                    $image_upload   = move_uploaded_file($image_path, $new_image_path);
                    $image_url      = home_url().'/images/'.$image_name;
                    $upload_dir     = wp_upload_dir();
                    $image_data     = ViewSource($image_url);
                    $filename       = $post_id.basename($image_url);
                    if(wp_mkdir_p($upload_dir['path']))     
                        $file           = $upload_dir['path'] . '/' . $filename;
                    else                                    
                        $file           = $upload_dir['basedir'] . '/' . $filename;
                    file_put_contents($file, $image_data);

                    $wp_filetype = wp_check_filetype($filename, null );
                    $attachment  = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    );
                    $attach_id   = wp_insert_attachment( $attachment, $file, $post_id );
                    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                    $res1        = wp_update_attachment_metadata( $attach_id, $attach_data );
                    if ($i <= 14) {
                     add_post_meta( $post_id, 'gallery', $attach_id, false );
                 } else {
                    add_post_meta( $post_id, 'legaldoc', $attach_id, false );
                }
                
                $checki      = get_the_post_thumbnail( $post_id );
                if(!$checki) {
                    $res2= set_post_thumbnail( $post_id, $attach_id );
                }
                    // unlink($new_image_path); 
            }
        }

        if($hrm_options['hrm_put_bill'] == 1 && !is_super_admin()) { ?>
         <script>
            alert('Đăng tin thành công');
            window.location.href = '<?php echo home_url('thanh-toan/?post_id=').$post_id; ?>';
            </script><?php

        } else { ?>
            <script>
                alert('Đăng tin thành công');
                window.location.href = '<?php echo home_url('tin-da-dang'); ?>';
                </script><?php
            }

        }
    }
    ?>
    <div id="primary" class="content-area col-md-9">
        <?php while ( have_posts() ) : the_post(); ?>
            <main id="main" class="site-main" role="main">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e('Đăng tin mới', 'hrm'); ?></h1>
                </header>
                <?php if($hrm_options['hrm_put_bill'] == 1) { ?>
                    <div class="notes">          		
                        Số tiền để đăng bài viết là: <span><?php menhgia($hrm_options['price-post']); ?>.
                        </div>
                    <?php } ?>
                    <div class="shadowblock">
                        <form class="form-item" action="" id="primaryPostForm" method="POST" enctype="multipart/form-data">
                            <div class="realty-info clearfix">
                                <div class="row-item">
                                    <div class="h2">
                                        <span><?php _e( 'Thông tin cơ bản','hrm' ); ?></span>
                                    </div>
                                </div>
                                <div class="row-item">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Loại tin đăng' ); ?>
                                                    <span class="colour">*</span>
                                                </label>
                                            </div>
                                            <select id="type-realty" name="type-realty" class="type-realty">
                                                <option value="">--Loại tin đăng--</option>
                                                <option value="realty-sell">
                                                    <?php _e('Cần Bán','hrm' ); ?>
                                                </option>
                                                <option value="realty-rent">
                                                    <?php _e('Cho thuê','hrm' ); ?>
                                                </option>
                                                <option value="realty-transfer">
                                                    <?php _e('Sang nhượng','hrm' ); ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Mục đăng tin' ); ?>
                                                </label>
                                            </div>
                                            <select id="term-type" name="term-type" class="term-type">
                                                <option value="">-Chọn tin đăng-</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-item">
                                    <div class="labelwrapper">
                                        <label>
                                            <?php _e( 'Tiêu đề','hrm' ); ?>
                                            <span class="colour">*</span>
                                        </label><br>
                                    </div>
                                    <input name="postTitle" id="postTitle" type="text" value="<?php echo $title; ?>" placeholder="Hãy đặt tiêu đề đầy đủ nghĩa, khách sẽ quan tâm hơn" required>
                                </div>
                                <div class="row-item post-city">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Số nhà','hrm' ); ?>
                                                </label><br>
                                            </div>
                                            <input name="address" id="address" type="text" value="<?php echo $address; ?>" placeholder="Số nhà" >
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Tên Đường','hrm' ); ?>
                                                </label><br>
                                            </div>
                                            <input name="street" id="street" type="text" value="<?php echo $street; ?>" placeholder="Tên đường" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row-item post-city">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Tỉnh thành','hrm' ); ?>
                                                </label><br>
                                            </div>
                                            <select name="city" id="city" class="quick-city">
                                                <option value="">- Chọn tỉnh / thành phố -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Quận huyện','hrm' ); ?>
                                                </label><br>
                                            </div>
                                            <select id="district" class="quick-district" name="district" >
                                                <option value="" selected="selected">- Chọn quận / huyện -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Phường xã','hrm' ); ?>
                                                </label><br>
                                            </div>
                                            <select name="ward" id="ward" class="quick-ward">
                                                <option value="">- Chọn phường / xã -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-item post-prince">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Nhãn trước giá' ); ?>
                                                </label>
                                            </div>
                                            <input name="label_price" id="label_price" type="text" value="">
                                        </div>
                                        <div class="col-sm-4 col-xs-6">
                                            <div class="labelwrapper">
                                                <label>
                                                    <?php _e( 'Giá' ); ?>
                                                </label>
                                            </div>
                                            <input name="post_price" id="post_price" type="number" value="">
                                        </div>
<!---------------------------------------------------------antopho chinh sua---------------------------------------------------------------------->								
										<div class=" col-sm-4 col-xs-6">
											<div class="labelwrapper">
												<label>
													<?php _e( 'Mệnh giá' ); ?>
												</label>
											</div>
												<select name="par_value" id="par_value">
												<?php
												$pars = array(
													'' => '- Mệnh Giá-',
													'thoa-thuan' => 'Thỏa thuận',
													'Triệu' => 'Triệu',
													'Triệu/m2' => 'Triệu/m2',
													'Tỷ' => 'Tỷ',
												);
												foreach ($pars as $par => $value) {
													echo '<option value="'.$par.'" '.(($par==$post_par_value)?'selected="selected"':"").'>'.$value.'</option>';
												}
												?>
												</select>
										</div>
                                        <!--<div class="col-sm-4 col-xs-6">
                                        //    <div class="labelwrapper">
                                                <label>
                                                    <?php //_e( 'Nhãn sau giá' ); ?>
                                                </label>
                                            </div>
                                            <input name="label_after" id="label_after" type="text" placeholder="VD: Giá / tháng, Giá + còn TL,...">
                                        </div>-->
<!----------------------------------------------------antopho chinh sua end--------------------------------------------------------------------->
                                    </div>
                                </div>
                                <div class="row-item post-prince">
                                 <div class="row">
                                  <div class="col-sm-6 col-xs-6">
                                    <div class="labelwrapper">
                                        <label>
                                            <?php _e( 'Khoảng giá','hrm' ); ?>
                                        </label><br>
                                    </div>
                                    <?php
                                    realty_dropdown_terms(
                                        array(
                                            'show_option_none' => __( '- Khoảng giá -', 'hrm' ),
                                            'taxonomy'         => 'khoang-gia',
                                            'hide_empty'       => 0,
                                            'name'             => 'khoang-gia',
                                            'id'               => 'khoang-gia',
                                            'order'            => 'asc',
                                            'orderby'          => 'term_id',
                                            'selected'         => get_query_var( 'khoang-gia' ),
                                        )
                                    );
                                    ?>
                                </div>
                                <div class="col-xs-6">
                                    <div class="labelwrapper">
                                        <label>
                                            <?php _e( 'Giá đang cho thuê (nếu có)' ); ?>
                                        </label>
                                    </div>
                                    <input name="p_rent" id="p_rent" type="text" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row-item post-area">
                           <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Diện tích trên giấy tờ (m<sup>2</sup>)' ); ?>
                                    </label>
                                </div>
                                <input name="post_area" id="post_area" type="number" value="" min="0" step="0.01">
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Diện tích sử dụng (m<sup>2</sup>)' ); ?>
                                    </label>
                                </div>
                                <input name="post_sizeuse" id="post_sizeuse" type="number" value="" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="row-item post-area">
                     <div class="row">
                        <div class="col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Rộng (m)' ); ?>
                                </label>
                            </div>
                            <input name="post_width" id="post_width" type="number" value="" min="0" step="0.01">
                        </div>
                        <div class="col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Dài (m)' ); ?>
                                </label>
                            </div>
                            <input name="post_long" id="post_long" type="number" value="" min="0" step="0.01">
                        </div>
                        <div class="col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Nở hậu' ); ?>
                                </label>
                            </div>
                            <input name="post_width2" id="post_width2" type="number" value="" min="0" step="0.01">
                        </div>
                    </div>
                </div>
                <div class="row-item post-area">
                    <div class="row">
                        <div class=" col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Số tầng' ); ?>
                                </label>
                            </div>
                            <?php
                                        // floors 
                            $floors = array(
                                ''  => __( '- Số tầng -', 'hrm' ),
                                '1' => '1 trệt',
                                '1' => '1+ tầng',
                                '2' => '2+ tầng',
                                '3' => '3+ tầng',
                                '4' => '4+ tầng',
                                '5' => '5+ tầng',
                                '6' => '6+ tầng',
                                '7' => '7+ tầng',
                                '8' => '8+ tầng',
                                '9' => '9+ tầng',
                                '10' => '10+ tầng',
                            );
                            realty_dropdown( array( 'name' => 'floor', 'id' => 'floor', 'options' => $floors, 'selected' => get_query_var( 'floor' ) ) );
                            ?>
                        </div>
                        <div class=" col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Số phòng' ); ?>
                                </label>
                            </div>
                            <?php
                                        // Phòng 
                            $rooms = array(
                                ''  => __( '- Số Phòng -', 'hrm' ),
                                '1' => '1 Phòng',
                                '2' => '2+ Phòng',
                                '3' => '3+ Phòng',
                                '4' => '4+ Phòng',
                                '5' => '5+ Phòng',
                                '6' => '6+ Phòng',
                                '7' => '7+ Phòng',
                                '8' => '8+ Phòng',
                                '9' => '9+ Phòng',
                                '10' => '10+ Phòng',
                            );
                            realty_dropdown( array( 'name' => 'post_bedroom', 'id' => 'post_bedroom', 'options' => $rooms, 'selected' => get_query_var( 'post_bedroom' ) ) );
                            ?>
                        </div>
                        <div class=" col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Số WC' ); ?>
                                </label>
                            </div>
                            <?php
                                        // Phòng 
                            $room_wc = array(
                                ''  => __( '- Số WC -', 'hrm' ),
                                '1' => '1 Phòng',
                                '2' => '2+ Phòng',
                                '3' => '3+ Phòng',
                                '4' => '4+ Phòng',
                                '5' => '5+ Phòng',
                            );
                            realty_dropdown( array( 'name' => 'room_wc', 'id' => 'room_wc', 'options' => $room_wc, 'selected' => get_query_var( 'room_wc' ) ) );
                            ?>
                        </div>

                    </div>
                </div>
                <div class="row-item post-area">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'BĐS đang kinh doanh gì?' ); ?>
                                </label>
                            </div>
                            <input name="incomehas" id="incomehas" type="text" value="">
                        </div>
                        <div class="col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Thu nhập từ BĐS' ); ?>
                                </label>
                            </div>
                            <input name="income" id="income" type="text" value="">
                        </div>
                    </div>
                </div>
                <div class="row-item post-area">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <input name="hemoto" id="hemoto" type="checkbox"><?php _e( 'Hẻm xe hơi?' ); ?>
                                </label>
                            </div>
                            <div class="labelwrapper">
                                <label>
                                    <input name="car_in" id="car_in" type="checkbox" ><?php _e( 'Xe hơi để trong nhà?' ); ?>
                                </label>
                            </div>
                            <div class="labelwrapper">
                                <label>
                                    <input name="basement" id="basement" type="checkbox" ><?php _e( 'Có tầng hầm?' ); ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <input name="elevator" id="elevator" type="checkbox" ><?php _e( 'Có thang máy?' ); ?>
                                </label>
                            </div>
                            <div class="labelwrapper">
                                <label>
                                    <input name="interior" id="interior" type="checkbox" ><?php _e( 'Nhà có sẵn nội thất?' ); ?>
                                    <script>
                                        jQuery( document ).ready( function ( $ ){
                                            $('#interior').click( function() {
                                                jQuery( '#interiorwhat-wp' ).slideToggle('slow');
                                            } );
                                        });
                                    </script>
                                </label>
                            </div>
                            <div id="interiorwhat-wp" style="display: none;">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Nội thất có gì?' ); ?>
                                    </label>
                                </div>
                                <textarea name="interiorwhat" id="interiorwhat" cols="30" rows="3"><?php echo $interiorwhat ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="row-item post-area">
                    <div class="row">
                        <div class="col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Đường/Hẻm rộng (m+)' ); ?>
                                </label>
                            </div>
                            <input name="strtwidth" id="strtwidth" type="number" value="">
                        </div>
                        <div class="col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Vị trí cầu thang' ); ?>
                                </label>
                            </div>
                            <?php $stair = array(
                                ''  => __( '- Vị trí cầu thang -', 'hrm' ),
                                'Giữa' => 'Giữa nhà',
                                'Cuối' => 'Cuối nhà',
                            );
                            realty_dropdown( array( 'name' => 'stair', 'id' => 'stair', 'options' => $stair, 'selected' => get_query_var( 'stair' ) ) ); ?>
                        </div>

                        <div class="col-sm-4 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Hướng','hrm' ); ?>
                                </label><br>
                            </div>
                            <?php
                            realty_dropdown_terms(
                                array(
                                    'show_option_none' => __( '- Hướng -', 'hrm' ),
                                    'taxonomy'         => 'quarter',
                                    'hide_empty'       => 0,
                                    'name'             => 'quarter-realty',
                                    'id'               => 'quarter-realty',
                                    'selected'         => get_query_var( 'quarter' ),
                                )
                            );
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row-item post-area">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Ghi chú riêng','hrm' ); ?>
                                </label><br>
                            </div>
                            <textarea name="note" id="note" cols="30" rows="6"><?php echo $note ?></textarea>
                        </div>
                    </div>
                </div>

            </div><!-- .realty-info -->

            <div class="realty-contact clearfix">
                <div class="row-item">
                    <div class="h2">
                        <span><?php _e( 'Thông tin liên hệ','hrm' ); ?></span>
                    </div>
                </div>
                <div class="row-item">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Tên chủ nhà' ); ?>
                                    <span class="colour">*</span>
                                </label>
                            </div>
                            <input name="post_name_contact" id="post_name_contact" type="text" value=""> <!-- antopho bỏ required-->
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Số điện thoại' ); ?>
                                    <span class="colour">*</span>
                                </label>
                            </div>
                            <input name="post_phone_contact" id="post_phone_contact" type="text" value=""  data-pattern="^[0-9]+$"> <!-- antopho bỏ required-->
                        </div>
                    </div>
                </div>
                <div class="row-item">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Hoa hồng MG' ); ?>
                                </label>
                            </div>
                            <input name="post_affiliate" id="post_affiliate" type="text" value="">
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'SĐT Môi giới Hỗ trợ' ); ?>
                                </label>
                            </div>
                            <input name="post_support" id="post_support" type="text"  data-pattern="^[0-9]+$">
                        </div>
                    </div>
                </div>
                <div class="row-item">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="labelwrapper">
                                <label>
                                    <?php _e( 'Trạng thái' ); ?>
                                </label>
                            </div>
                            <input name="post_p_status" id="post_p_status" type="text" placeholder="Bán gấp, Đang mở cửa, Nợ ngân hàng,...">
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="labelwrapper">
                                <label>
                                    <input name="sold" id="sold" type="checkbox" ><?php _e( 'Đã bán/Ngừng giao dịch?' ); ?>
                                    <script>
                                        jQuery( document ).ready( function ( $ ){
                                            $('#sold').click( function() {
                                                jQuery( '#end_date-wp' ).slideToggle('slow');
                                            } );
                                        });
                                    </script>
                                </label>
                            </div>
                            <div id="end_date-wp" style="display: none;">
                                <input type="text" name="end_date" id="end-date" placeholder="Ngày ngừng bán" value="<?php echo $meta['end_date'] ?>" class="datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .realty-contact -->

                <div class="realty-content clearfix">
                    <div class="row-item">
                        <div class="h2">
                            <span><?php _e( 'Mô tả chi tiết','hrm' ); ?></span>
                            <span class="colour">*</span>
                        </div>
                    </div>
                    <div class="row-item">
                        <?php
                        $settings = array(
                            'wpautop' => true,
                            'postContent' => 'content',
                            'media_buttons' => true,
                            'tinymce' => array(
                                'theme_advanced_buttons1' => 'bold,italic,underline,blockquote,separator,strikethrough,bullist,numlist,justifyleft,justifycenter,justifyright,undo,redo,link,unlink,fullscreen',
                                'theme_advanced_buttons2' => 'pastetext,pasteword,removeformat,|,charmap,|,outdent,indent,|,undo,redo',
                                'theme_advanced_buttons3' => '',
                                'theme_advanced_buttons4' => ''
                            ),
                            'quicktags' => array(
                                'buttons' => 'b,i,ul,ol,li,link,close'
                            )
                        );
                        wp_editor( $content, 'postContent', $settings );
                        ?>
                    </div>
                </div><!-- .realty-content -->

            <div class="realty-images clearfix" style="margin-top: 15px;">
                <div class="row-item">
                    <div class="labelwrapper">
                        <label>
                            <?php _e( 'Hình ảnh' ); ?>
                            <span class="colour">*</span>
                        </label>
                    </div>
                    <p class="bg-danger text-danger">
                        <?php _e( '* Hình ảnh đầu tiên sẽ được chọn làm ảnh đại diện cho tin đăng','hrm' ); ?><br>
                        <?php _e( '* Chọn các ảnh có kích thước tối thiểu 757x570','hrm' ); ?><br>
                        <?php _e( '* Không upload các ảnh kích cỡ lớn, đồi trụy....','hrm' ); ?>
                    </p>
                </div>
                <div class="row-item">
<!-------------------------------------------------------------------chu ý------------------------------------------------------------------------------->
                    <div class="labelwrapper">
                        <label>
                            <?php _e( 'Hình ảnh BĐS' ); ?>
                        </label>
                    </div>
                    <?php
                    for ($i=1; $i < 15 ; $i++) { ?>
                        <div class="product-images fileUpload fileUpload<?php echo $i; ?>">
                            <span><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png" alt="Ảnh mô tả" id="thumbimage<?php echo $i; ?>" class="thumbimage"></span>
                            <input type="file" class="form-control upload" id="upload-file<?php echo $i; ?>" name="image_upload<?php echo $i; ?>" multiple>
                            <div class="remove-bg">
                                <button type="button" class="btn btn-xoa btn-xoa<?php echo $i; ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Xóa
                                </button>
                            </div>
                        </div>
                        <script>
                           jQuery( document ).ready( function ( $ ){
                            jQuery("document").ready(function() {
                                function readURL(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (e) {
                                            $("#thumbimage<?php echo $i; ?>").attr('src', e.target.result);
                                            $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                            <?php if($i==8) { ?>
                                                $(".fileUpload1").css('display', 'inline-block');<?php
                                            }?>
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                        $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                        <?php if($i==8) { ?>
                                            $(".fileUpload1").css('display', 'inline-block');<?php
                                        }?>
                                    }
                                    else {
                                        $("#thumbimage<?php echo $i; ?>").attr('src', input.value);
                                        $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                        <?php if($i==8) { ?>
                                            $(".fileUpload1").css('display', 'inline-block');<?php
                                        }?>
                                    }
                                }
                                $("#upload-file<?php echo $i; ?>").change(function() {
                                  readURL(this);
                              });
                                $('.btn-xoa<?php echo $i; ?>').on('click', function() {
                                            // $(".fileUpload<?php echo $i; ?>").css('display', 'none');
                                            $("#upload-file<?php echo $i; ?>").val('');
                                            $("#thumbimage<?php echo $i; ?>").attr('src', '<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png');
                                        });
                            });
                        })
                    </script>
                <?php } ?>
            </div>
<!-------------------------------------------------------------------chu ý end------------------------------------------------------------------------------->			
            <hr />
            <div class="row-item">
                <div class="labelwrapper">
                    <label>
                        <?php _e( 'Hình ảnh sổ đỏ/ sổ hồng' ); ?>
                    </label>
                </div>
                <?php
                for ($i=1; $i <= 16 ; $i++) { ?>
                    <div class="product-images fileUpload fileUpload<?php echo $i; ?>">
                        <span><img src="<?php echo get_stylesheet_directory_uri();?>/images/placeholder.png" alt="Ảnh mô tả" id="thumbimage<?php echo $i; ?>" class="thumbimage"></span>
                        <input type="file" class="form-control upload" id="upload-file<?php echo $i; ?>" name="image_upload<?php echo $i; ?>">
                        <div class="remove-bg">
                            <button type="button" class="btn btn-xoa btn-xoa<?php echo $i; ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Xóa
                            </button>

                        </div>
                    </div>
                   <script>
                       jQuery( document ).ready( function ( $ ){
                        jQuery("document").ready(function() {
                            function readURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        $("#thumbimage<?php echo $i; ?>").attr('src', e.target.result);
                                        $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                        <?php if($i==8) { ?>
                                            $(".fileUpload1").css('display', 'inline-block');<?php
                                        }?>
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                    $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                    <?php if($i==8) { ?>
                                        $(".fileUpload1").css('display', 'inline-block');<?php
                                    }?>
                                }
                                else {
                                    $("#thumbimage<?php echo $i; ?>").attr('src', input.value);
                                    $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                    <?php if($i==8) { ?>
                                        $(".fileUpload1").css('display', 'inline-block');<?php
                                    }?>
                                }
                            }
                            $("#upload-file<?php echo $i; ?>").change(function() {
                              readURL(this);
                          });
                            $('.btn-xoa<?php echo $i; ?>').on('click', function() {
                                $("#upload-file<?php echo $i; ?>").val('');
                                $("#thumbimage<?php echo $i; ?>").attr('src', '<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png');
                            });
                        });
                    })
                </script>
            <?php } ?>
        </div>
    </div><!-- .realty-images -->

    <div class="realty-maps clearfix">
        <div class="row-item">
            <div class="h2">
                <span><?php _e( 'Bản đồ','hrm' ); ?></span>
            </div>
        </div>
        <div class="row-item">
         <div class="labelwrapper">
            <label>
                <?php _e( 'Nhập địa chỉ tìm vị trí trên bản đồ, sau đó click lên bản đồ để lưu vị trí' ); ?>
            </label>
        </div>
        <input type="text" name="map_address" id="realty-address" value="<?php echo $meta['address'] ?>" placeholder="Địa chỉ trên bản đồ" class="wide">
    </div>
    <div class="row-item">
        <div class="realty-wrap">
            <input type="hidden" id="location-lat" name="location_lat" value="<?php echo $meta['location_lat'] ?>">
            <input type="hidden" id="location-lng" name="location_lng" value="<?php echo $meta['location_lng'] ?>">

            <div id="canvas-map" class="realty-map"></div>
        </div>
    </div>
</div><!-- .realty-map -->


<div class="publish-ad-button clearfix">
    <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
    <input type="hidden" name="submitted" id="submitted" value="true" />
    <button class="btn form-submit" id="edit-submit" name="op" value="Publish Ad" type="submit"><?php _e('Đăng tin', 'agrg') ?></button>
</div>
</form>
</div>
</main><!-- #main -->
<?php endwhile; ?>
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php
get_footer();
