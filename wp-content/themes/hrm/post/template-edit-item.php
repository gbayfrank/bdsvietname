<?php
/**
* Template name: Sửa tin
*/
if(!is_user_logged_in()) {
    wp_redirect( home_url('/dang-nhap'));
}
nocache_headers(); // don't cache anything
global $wpdb, $hrm_options;
$current_user = wp_get_current_user(); // grabs the user info and puts into vars
$user_id      = get_current_user_id();
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
$query = new WP_Query(
    array(
        'post_type'      => 'realty', 
        'posts_per_page' =>'-1',
        'p'              => $_GET['post'],

    ) 
);
if ($query->have_posts()) { 
    while ($query->have_posts()) { $query->the_post();
    $current_post = $_GET['post'];
    $title        = get_the_title();
    $content      = get_the_content();
    $posttags     = get_the_tags($current_post);
    if ($posttags) {
        foreach($posttags as $tag) {
            $tags_list = $tag->name . ' ';
        }
    }

    /* term taxonomy*/

    $khoang_gia = get_the_terms( $current_post, 'khoang-gia' );
    $khoang_gia_id = $khoang_gia[0]->slug;

    $term_sell = get_the_terms( $current_post, 'realty-sell' );
    $term_sell_id = $term_sell[0]->term_id;

    $term_rent = get_the_terms( $current_post, 'realty-rent' );
    $term_rent_id = $term_rent[0]->term_id;

    $term_transfer = get_the_terms( $current_post, 'realty-transfer' );
    $term_transfer_id = $term_transfer[0]->term_id;

    $term_quarter = get_the_terms( $current_post, 'quarter' );
    $term_quarter_id = $term_quarter[0]->term_id;

    $term_city1s = get_the_terms( $current_post, 'city-realty' );
    foreach ($term_city1s as $term_city1) {
        if ($term_city1->parent == 0) {
            $tc_id = $term_city1->term_id;
        }
        $term_cha_city1 = $term_city1->parent;
        $term_cha_city1s = get_term($term_cha_city1,'city-realty');

        if ($term_city1->parent != 0 && $term_cha_city1s->parent == 0) {
            $td_id = $term_city1->term_id;
        }
        if ($term_city1->parent != 0 && $term_cha_city1s->parent != 0) {
            $ta_id = $term_city1->term_id;
        }
    }
    $arg_ds = array(
        'child_of' => $tc_id,
        'hide_empty' => 0
    );
    $termds=  get_terms( 'city-realty' , $arg_ds );
    $arg_as = array(
        'child_of' => $td_id,
        'hide_empty' => 0
    );
    $termas=  get_terms( 'city-realty' , $arg_as );

        /*
        set custom field
        * tabs realty-info
        */
        $address     = get_post_meta( $current_post , 'address' , true );
        $street      = get_post_meta( $current_post , 'street' , true );
        $label       = get_post_meta( $current_post , 'label' , true );
        $post_price  = get_post_meta( $current_post , 'price-realty' , true );
        $label_after = get_post_meta( $current_post , 'label_after' , true );
        $p_rent      = get_post_meta( $current_post , 'p_rent' , true );
        $width       = get_post_meta( $current_post , 'width' , true );
        $long        = get_post_meta( $current_post , 'long' , true );
        $width2      = get_post_meta( $current_post , 'width2' , true );
        $area_realty = get_post_meta( $current_post , 'area-realty' , true );
        $sizeuse     = get_post_meta( $current_post , 'sizeuse' , true );
        $floor       = get_post_meta( $current_post , 'floor' , true );
        $realty_room = get_post_meta( $current_post , 'realty-bedroom' , true );
        $room_wc     = get_post_meta( $current_post , 'room_wc' , true );
        $note        = get_post_meta( $current_post , 'note' , true );
        $incomehas   = get_post_meta( $current_post , 'incomehas' , true );
        $income      = get_post_meta( $current_post , 'income' , true );

        $hemoto      = get_post_meta( $current_post , 'hemoto' , true );
        $car_in      = get_post_meta( $current_post , 'car_in' , true );
        $elevator    = get_post_meta( $current_post , 'elevator' , true );
        $interior    = get_post_meta( $current_post , 'interior' , true );
        $basement    = get_post_meta( $current_post , 'basement' , true );
        $sold        = get_post_meta( $current_post , 'sold' , true );

        $interiorwhat = get_post_meta( $current_post , 'interiorwhat' , true );
        $strtwidth    = get_post_meta( $current_post , 'strtwidth' , true );
        $stair        = get_post_meta( $current_post , 'stair' , true );

        $tenchunha    = get_post_meta( $current_post , 'tenchunha' , true );
        $mobile       = get_post_meta( $current_post , 'mobile' , true );
        $affiliate    = get_post_meta( $current_post , 'affiliate' , true );
        $support      = get_post_meta( $current_post , 'support' , true );
        $end_date     = get_post_meta( $current_post , 'end_date' , true );
        $p_status     = get_post_meta( $current_post , 'p_status' , true );
        $map_address = get_post_meta( $current_post , 'tim_map' , true );
        

        $post_map           = get_post_meta( $current_post , 'location' , true );

        /*
        * tabs realty-image
        */
        $post_gallery = rwmb_meta('gallery');
        $legaldoc = rwmb_meta('legaldoc');

        $meta = array(
            'gallery'       => isset( $_POST['gallery'] ) ? $_POST['gallery'] : array(),
        );
    } 
} else { 
    $not_tanh_toan_es = 'Tin này chưa được thanh toán';
    ?>
    <!-- <script>
        window.location.href = '<?php echo home_url(); ?>';
    </script> -->
    <?php  }
    if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

        if(trim($_POST['postTitle']) === '') {
            $postTitleError = 'Vui lòng điền tiêu đề.';
            $hasError = true;
        } else {
            $postTitle = trim($_POST['postTitle']);
        }

        if($hasError != true) {
            if(is_super_admin() ){
                $postStatus = 'publish';
            }elseif(!is_super_admin()){
				//trước khi Quang-antopho sửa  $postStatus = 'pending';
                $postStatus = 'publish';
            }            
            $post_information = array(
                'ID' => $current_post,
                'post_content' => strip_tags($_POST['postContent'], '<a><h1><h2><h3><strong><b>'),
                'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
                'post_status' => $postStatus,
                'post_excerpt' => strip_tags($_POST['shortDescription'], '<a><h1><h2><h3><strong><b>'),
            );
            wp_update_post( $post_information );

// update meta field
/*
* update custom field realty info
*/
// update_post_meta($current_post, '_sku', esc_attr( $current_post ) );

update_post_meta($current_post, 'address', wp_kses($_POST['address'], $allowed));
update_post_meta($current_post, 'street', wp_kses($_POST['street'], $allowed));
update_post_meta($current_post, 'street_ko_dau', wp_kses(stripUnicode($_POST['street']), $allowed));
update_post_meta($current_post, 'label', wp_kses($_POST['label_price'], $allowed));
update_post_meta($current_post, 'price-realty', wp_kses($_POST['post_price'], $allowed));
update_post_meta($current_post, 'label_after', wp_kses($_POST['label_after'], $allowed));
wp_set_object_terms( $current_post, $_POST['khoang-gia'], 'khoang-gia' );
update_post_meta($current_post, 'p_rent', wp_kses($_POST['p_rent'], $allowed));
update_post_meta($current_post, 'begin_date', date('d-m-Y') );
update_post_meta($current_post, 'width', wp_kses($_POST['post_width'], $allowed));
update_post_meta($current_post, 'long', wp_kses($_POST['post_long'], $allowed));
update_post_meta($current_post, 'width2', wp_kses($_POST['post_width2'], $allowed));
update_post_meta($current_post, 'area-realty', wp_kses($_POST['post_area'], $allowed));
update_post_meta($current_post, 'sizeuse', wp_kses($_POST['post_sizeuse'], $allowed));
update_post_meta($current_post, 'floor', wp_kses($_POST['floor'], $allowed));
update_post_meta($current_post, 'realty-bedroom', wp_kses($_POST['post_bedroom'], $allowed));
update_post_meta($current_post, 'note', wp_kses($_POST['note'], $allowed));
update_post_meta($current_post, 'room_wc', wp_kses($_POST['room_wc'], $allowed));
update_post_meta($current_post, 'incomehas', wp_kses($_POST['incomehas'], $allowed));
update_post_meta($current_post, 'income', wp_kses($_POST['income'], $allowed));
if( isset($_POST['hemoto']) ){
    update_post_meta($current_post, "hemoto", true );
}else{
    delete_post_meta($current_post, "hemoto");
}
if( isset($_POST['car_in']) ){
    update_post_meta($current_post, "car_in", true );
}else{
    delete_post_meta($current_post, "car_in");
}
if( isset($_POST['elevator']) ){
    update_post_meta($current_post, "elevator", true );
}else{
    delete_post_meta($current_post, "elevator");
}
if( isset($_POST['interior']) ){
    update_post_meta($current_post, "interior", true);
}else{
    delete_post_meta($current_post, "interior");
}
if( isset($_POST['basement']) ){
    update_post_meta($current_post, "basement", true);
}else{
    delete_post_meta($current_post, "basement");
}
update_post_meta($current_post, 'interiorwhat', wp_kses($_POST['interiorwhat'], $allowed));
update_post_meta($current_post, 'strtwidth', wp_kses($_POST['strtwidth'], $allowed));
update_post_meta($current_post, 'stair', wp_kses($_POST['stair'], $allowed));
wp_set_object_terms( $current_post, $_POST['quarter-realty'], 'quarter' );
update_post_meta($current_post, 'tim_map', wp_kses($_POST['map_address'], $allowed));

/*
* update custom field realty contact
*/
update_post_meta($current_post, 'tenchunha', wp_kses($_POST['post_name_contact'], $allowed));
update_post_meta($current_post, 'mobile', wp_kses($_POST['post_phone_contact'], $allowed));
update_post_meta($current_post, 'affiliate', wp_kses($_POST['post_affiliate'], $allowed));
update_post_meta($current_post, 'support', wp_kses($_POST['post_support'], $allowed));
update_post_meta($current_post, 'end_date', wp_kses($_POST['end_date'], $allowed));
update_post_meta($current_post, 'p_status', wp_kses($_POST['post_p_status'], $allowed));

if( isset($_POST['sold']) ) {
    update_post_meta($current_post, "sold", true );
} else{
    delete_post_meta($current_post, "sold");
}



foreach( $meta as $key => $value )
{
    $meta[$key] = get_post_meta( $realty['ID'], $key, true );
}
$location = explode( ',', $meta['location']);
$meta['location_lat'] = @$location[0];
$meta['location_lng'] = @$location[1];
update_post_meta( $current_post, 'location', $_POST['location_lat'] . ',' . $_POST['location_lng'] );

update_post_meta( $current_post, 'type-term', $_POST['type-realty'] );
/*
* Update term realty
*/
wp_set_object_terms( $current_post, $_POST['term-type'], $_POST['type-realty'] );
$city_slug     = get_term( $_POST['city'], 'city-realty')->slug;
$district_slug = get_term( $_POST['district'], 'city-realty')->slug;
$ward_slug     = get_term( $_POST['ward'], 'city-realty')->slug;
wp_set_object_terms( $current_post, array($city_slug,$district_slug, $ward_slug), 'city-realty' );

$permalink = get_permalink( $current_post );
delete_post_meta( $current_post, 'gallery' );
delete_post_meta( $current_post, 'legaldoc' );
for ($i=1; $i <= 16; $i++) { 
    $name_upload = "image_upload".$i;
    $namecu = "current".$i;
    if($_FILES[$name_upload]["name"]){
        $image_name     = $_FILES[$name_upload]["name"];
        $image_name     = str_replace(" ", "-", basename($image_name));
        $image_path     = $_FILES[$name_upload]["tmp_name"];
        $new_image_path = "./images/".$image_name;
        $image_upload   = move_uploaded_file($image_path, $new_image_path);
        $image_url      = home_url().'/images/'.$image_name;
        $upload_dir     = wp_upload_dir();
        $image_data     = ViewSource($image_url);
        $filename       = $post_id.basename($image_url);
        if(wp_mkdir_p($upload_dir['path']))     
            $file = $upload_dir['path'] . '/' . $filename;
        else                                    
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => $image_name,
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id   = wp_insert_attachment( $attachment, $file,$current_post );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1        = wp_update_attachment_metadata( $attach_id, $attach_data );
        if ($i <= 14) {
            add_post_meta( $current_post, 'gallery', $attach_id, false );
        } else {
            add_post_meta( $current_post, 'legaldoc', $attach_id, false );
        }
        $checki = get_the_post_thumbnail( $current_post );
        if(!$checki) {
            $res2 = set_post_thumbnail($current_post, $attach_id );
        }
        unlink($new_image_path);
    }
    if($_POST[$namecu] != '') {
        if ( $namecu == "current15" || $namecu == "current16" ) {
            add_post_meta( $current_post, 'legaldoc', $_POST[$namecu], false );
        } else {
            add_post_meta( $current_post, 'gallery', $_POST[$namecu], false );
        }

        $checki = get_the_post_thumbnail( $current_post );
        if(!$checki) {
            $res2= set_post_thumbnail($current_post, $_POST[$namecu] );
        }
    }
}
if($hrm_options['hrm_put_bill'] == 1 && !is_super_admin()) { ?>
    <script>
        window.location.href = '<?php echo home_url('thanh-toan/?post_id=').$current_post; ?>';
        </script><?php

    } else { ?>
        <script>
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
                <?php if ($not_tanh_toan_es) { ?>
                    <p><?php echo $not_tanh_toan_es ?></p>
                <?php } ?>
                    Số tiền để đăng bài viết là: <span><?php menhgia($hrm_options['price-post']); ?>.
                    </div>
                <?php } ?>
                <div class="shadowblock">
                    <form class="form-item" action="" id="primaryPostForm" method="POST" enctype="multipart/form-data">
                        <div class="realty-info">
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
                                            <option value="realty-sell" <?php if(get_post_meta($current_post,'type-term',true) == 'realty-sell' ) echo 'selected'; ?>>
                                                <?php _e('Cần Bán','hrm' ); ?>
                                            </option>
                                            <option value="realty-rent" <?php if(get_post_meta($current_post,'type-term',true) == 'realty-rent' ) echo 'selected'; ?>>
                                                <?php _e('Cho thuê','hrm' ); ?>
                                            </option>
                                            <option value="realty-transfer" <?php if(get_post_meta($current_post,'type-term',true) == 'realty-transfer' ) echo 'selected'; ?>>
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
                                            <?php

                                            $args_term = array(
                                                'taxonomy'           => get_post_meta($current_post,'type-term',true),
                                                'hide_empty'         => 0,
                                            );
                                            $terms = get_categories( $args_term );
                                            foreach ($terms as $term) {
                                                printf(
                                                    '<option value="%s" class="%2s" %3s>%4s</option>',
                                                    $term ->slug,
                                                    $term ->taxonomy,
                                                    $term ->slug == $term_sell[0]->slug ? 'selected="selected"' : '' || $term ->slug == $term_rent[0]->slug ? 'selected="selected"' : '' || $term ->slug == $term_transfer[0]->slug ? 'selected="selected"' : '',
                                                    $term ->name
                                                );
                                            }

                                            ?>
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
                                    <script>
                                        jQuery(document).ready(function($){
                                            <?php 
                                            if ($tc_id != '') { ?>
                                                setTimeout(function(){
                                                    $("#city").val("<?php echo $tc_id ?>").trigger('change');
                                                }, 2000);
                                            <?php } 
                                            if ($td_id != '') { ?>
                                                setTimeout(function(){
                                                    $("#district").val("<?php echo $td_id ?>").trigger('change');
                                                }, 4000);
                                            <?php } 
                                            if ($ta_id != '') { ?>
                                                setTimeout(function(){
                                                    $("#ward").val("<?php echo $ta_id ?>").trigger('change');
                                                }, 6000);
                                            <?php } ?>
                                        }); 
                                    </script>
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
                                        <input name="label_price" id="label_price" type="text" value="<?php echo $label ?>">
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Giá' ); ?>
                                            </label>
                                        </div>
                                        <input name="post_price" id="post_price" type="number" value="<?php echo $post_price ?>">
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Nhãn sau giá' ); ?>
                                            </label>
                                        </div>
                                        <input name="label_after" id="label_after" value="<?php echo $label_after ?>" type="text" placeholder="VD: Giá / tháng, Giá + còn TL,...">
                                    </div>
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
                                                'selected'         => $khoang_gia_id,
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
                                        <input name="p_rent" id="p_rent" type="text" value="<?php echo $p_rent ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row-item post-area">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Diện tích công nhận (m<sup>2</sup>)' ); ?>
                                            </label>
                                        </div>

                                        <input name="post_area" id="post_area" type="number" value="<?php echo $area_realty ?>" min="0" step="0.01">
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Diện tích sử dụng (m<sup>2</sup>)' ); ?>
                                            </label>
                                        </div>
                                        <input name="post_sizeuse" id="post_sizeuse" type="number" value="<?php echo $sizeuse ?>" min="0" step="0.01">
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
                                        <input name="post_width" id="post_width" type="number" value="<?php echo $width ?>" min="0" step="0.01">
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Dài (m)' ); ?>
                                            </label>
                                        </div>
                                        <input name="post_long" id="post_long" type="number" value="<?php echo $long ?>" min="0" step="0.01">
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Nở hậu' ); ?>
                                            </label>
                                        </div>
                                        <input name="post_width2" id="post_width2" type="number" value="<?php echo $width2 ?>" step="0.01">
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
                                        realty_dropdown( array( 'name' => 'floor', 'id' => 'floor', 'options' => $floors, 'selected' => $floor ) );
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
                                        realty_dropdown( array( 'name' => 'post_bedroom', 'id' => 'post_bedroom', 'options' => $rooms, 'selected' => $realty_room ) );
                                        ?>
                                    </div>
                                    <div class=" col-sm-4 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Số WC' ); ?>
                                            </label>
                                        </div>
                                        <?php
// Phòng wc
                                        $room_wcs = array(
                                            ''  => __( '- Số WC -', 'hrm' ),
                                            '1' => '1 Phòng',
                                            '2' => '2+ Phòng',
                                            '3' => '3+ Phòng',
                                            '4' => '4+ Phòng',
                                            '5' => '5+ Phòng',
                                        );
                                        realty_dropdown( array( 'name' => 'room_wc', 'id' => 'room_wc', 'options' => $room_wcs, 'selected' => $room_wc ) );
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
                                        <input name="incomehas" id="incomehas" type="text" value="<?php echo $incomehas ?>">
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Thu nhập từ BĐS' ); ?>
                                            </label>
                                        </div>
                                        <input name="income" id="income" type="text" value="<?php echo $income ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row-item post-area">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <input name="hemoto" id="hemoto" <?php echo ($hemoto)? 'checked="checked" ' : '' ?> type="checkbox"><?php _e( 'Hẻm xe hơi?' ); ?>
                                            </label>
                                        </div>
                                        <div class="labelwrapper">
                                            <label>
                                                <input name="car_in" id="car_in" <?php echo ($car_in)? 'checked="checked" ' : '' ?> type="checkbox" ><?php _e( 'Xe hơi để trong nhà?' ); ?>
                                            </label>
                                        </div>
                                        <div class="labelwrapper">
                                            <label>
                                                <input name="basement" id="basement" <?php echo ($basement)? 'checked="checked" ' : '' ?> type="checkbox" ><?php _e( 'Có tầng hầm?' ); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <input name="elevator" id="elevator" <?php echo ($elevator)? 'checked="checked" ' : '' ?> type="checkbox" ><?php _e( 'Có thang máy?' ); ?>
                                            </label>
                                        </div>
                                        <div class="labelwrapper">
                                            <label>
                                                <input name="interior" id="interior" <?php echo ($interior)? 'checked="checked" ' : '' ?> type="checkbox" ><?php _e( 'Nhà có sẵn nội thất?' ); ?>
                                                <script>
                                                    jQuery( document ).ready( function ( $ ){
                                                        ckbox = $('#interior');
                                                        if (ckbox.is(':checked')) {
                                                            jQuery( '#interiorwhat-wp' ).show();
                                                        } else {
                                                            jQuery( '#interiorwhat-wp' ).hide();
                                                        }
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
                                        <input name="strtwidth" id="strtwidth" type="number" value="<?php echo $strtwidth ?>">
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Vị trí cầu thang' ); ?>
                                            </label>
                                        </div>
                                        <?php $stairs = array(
                                            ''  => __( '- Vị trí cầu thang -', 'hrm' ),
                                            'Giữa' => 'Giữa nhà',
                                            'Cuối' => 'Cuối nhà',
                                        );
                                        realty_dropdown( array( 'name' => 'stair', 'id' => 'stair', 'options' => $stairs, 'selected' => $stair ) ); ?>
                                    </div>

                                    <div class="col-sm-4 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Hướng','hrm' ); ?>
                                            </label><br>
                                        </div>
                                        <?php
                                        $quarter_current = wp_get_post_terms($current_post,'quarter',array("parent" => 0));
                                        realty_dropdown_terms(
                                            array(
                                                'show_option_none' => __( '- Hướng -', 'hrm' ),
                                                'taxonomy'         => 'quarter',
                                                'hide_empty'       => 0,
                                                'name'             => 'quarter-realty',
                                                'id'               => 'quarter-realty',
                                                'selected'         => $quarter_current[0]->slug,
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

                        <div class="realty-contact">
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
                                        <input name="post_name_contact" id="post_name_contact" type="text" value="<?php echo $tenchunha ?>" required>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Số điện thoại' ); ?>
                                                <span class="colour">*</span>
                                            </label>
                                        </div>
                                        <input required name="post_phone_contact" id="post_phone_contact" type="text" value="<?php echo $mobile ?>"  data-pattern="^[0-9]+$">
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
                                        <input name="post_affiliate" id="post_affiliate" type="text" value="<?php echo $affiliate ?>">
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'SĐT Môi giới Hỗ trợ' ); ?>
                                            </label>
                                        </div>
                                        <input name="post_support" id="post_support" type="text"  value="<?php echo $support ?>" data-pattern="^[0-9]+$">
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
                                        <input name="post_p_status" id="post_p_status" type="text" value="<?php echo $p_status ?>" placeholder="Bán gấp, Đang mở cửa, Nợ ngân hàng,...">
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="labelwrapper">
                                            <label>
                                                <input name="sold" id="sold" <?php echo ($sold)? 'checked="checked" ' : '' ?>  type="checkbox" ><?php _e( 'Đã bán/Ngừng giao dịch?' ); ?>
                                                <script>
                                                    jQuery( document ).ready( function ( $ ){
                                                        ckbox2 = $('#sold');
                                                        if (ckbox2.is(':checked')) {
                                                            jQuery( '#end_date-wp' ).show();
                                                        } else {
                                                            jQuery( '#end_date-wp' ).hide();
                                                        }
                                                        $('#sold').click( function() {
                                                            jQuery( '#end_date-wp' ).slideToggle('slow');
                                                        } );
                                                    });
                                                </script>
                                            </label>
                                        </div>
                                        <div id="end_date-wp" style="display: none;">
                                            <input type="text" name="end_date" id="end-date" placeholder="Ngày ngừng bán" value="<?php echo $end_date ?>" class="datepicker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .realty-contact -->

                        <div class="realty-content">
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

                        <div class="realty-images">
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
                                <?php
                                for ($i=1; $i < 15 ; $i++) { ?>
                                    <div class="product-images fileUpload fileUpload<?php echo $i; ?>">
                                        <span><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png" alt="Ảnh mô tả" id="thumbimage<?php echo $i; ?>" class="thumbimage"></span>
                                        <input type="file" class="form-control upload" id="upload-file<?php echo $i; ?>" name="image_upload<?php echo $i; ?>">
                                        <input type="hidden" name="current<?php echo $i; ?>" id="current<?php echo $i; ?>">
                                        <div class="remove-bg">
                                            <button type="button" class="btn btn-xoa" onclick="xoaanh(<?php echo $i; ?>);">
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
                                                            <?php if($i==13) { ?>
                                                                $(".fileUpload1").css('display', 'inline-block');<?php
                                                            }?>
                                                        }
                                                        reader.readAsDataURL(input.files[0]);
                                                        $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                                        <?php if($i==13) { ?>
                                                            $(".fileUpload1").css('display', 'inline-block');<?php
                                                        }?>
                                                    }
                                                    else {
                                                        $("#thumbimage<?php echo $i; ?>").attr('src', input.value);
                                                        $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');
                                                        <?php if($i==13) { ?>
                                                            $(".fileUpload1").css('display', 'inline-block');<?php
                                                        }?>
                                                    }
                                                }
                                                $("#upload-file<?php echo $i; ?>").change(function() {
                                                    readURL(this);
                                                });
                                            });
                                        })
                                    </script>
                                <?php  } ?>
                                <script>
                                    jQuery( document ).ready( function ( $ ){
                                        jQuery("document").ready(function() {
                                            <?php 
                                            $y = 0;
                                            foreach ($post_gallery as $gallery) {
                                                $y ++;
                                                $z = $y+1;
                                                echo '$("#thumbimage'.$y.'").attr("src", "'.$gallery["full_url"].'");';
                                                echo '$(".fileUpload'.$z.'").css("display", "inline-block");';
                                                echo '$("#current'.$y.'").val("'.$gallery["ID"].'");';
                                            }
                                            ?>
                                        });
                                    })
                                </script>
                            </div>
                            <div class="row-item">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Hình ảnh sổ đỏ/ sổ hồng' ); ?>
                                    </label>
                                </div>
                                <?php
                                for ($i=15; $i <= 16 ; $i++) { ?>
                                    <div class="product-images fileUpload fileUpload<?php echo $i; ?>">
                                        <span><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png" alt="Ảnh mô tả" id="thumbimage<?php echo $i; ?>" class="thumbimage"></span>
                                        <input type="file" class="form-control upload" id="upload-file<?php echo $i; ?>" name="image_upload<?php echo $i; ?>">
                                        <input type="hidden" name="current<?php echo $i; ?>" id="current<?php echo $i; ?>">
                                        <div class="remove-bg">
                                            <button type="button" class="btn btn-xoa" onclick="xoaanh(<?php echo $i; ?>);">
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

                                                        }
                                                        reader.readAsDataURL(input.files[0]);
                                                        $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');

                                                    }
                                                    else {
                                                        $("#thumbimage<?php echo $i; ?>").attr('src', input.value);
                                                        $(".fileUpload<?php echo $i+1; ?>").css('display', 'inline-block');

                                                    }
                                                }
                                                $("#upload-file<?php echo $i; ?>").change(function() {
                                                    readURL(this);
                                                });
                                            });
                                        })
                                    </script>
                                <?php  } ?>
                                <script>
                                    jQuery( document ).ready( function ( $ ){
                                        jQuery("document").ready(function() {
                                            <?php 
                                            $y = 14;
                                            foreach ($legaldoc as $gallery) {
                                                $y ++;
                                                $z = $y+1;
                                                echo '$("#thumbimage'.$y.'").attr("src", "'.$gallery["full_url"].'");';
                                                echo '$(".fileUpload'.$z.'").css("display", "inline-block");';
                                                echo '$("#current'.$y.'").val("'.$gallery["ID"].'");';
                                            }
                                            ?>
                                        });
                                    })
                                </script>
                            </div>
                        </div><!-- .realty-images -->
                        <div class="realty-maps">
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
                                <input type="text" name="map_address" id="realty-address" value="<?php echo $map_address; ?>" class="wide">
                            </div>
                            <div class="row-item">
                                <div class="realty-wrap">
                                    <?php
                                    $address = get_infor_from_address($post_address);

                                    //var_dump($address);

                                    $lat_long_ar = explode(',', $post_map);
                                    $latitude    = $lat_long_ar[0];
                                    $longitude   = $lat_long_ar[1];
                                    
                                    // $latitude = $address->results[0]->geometry->location->lat;
                                    // $longitude =$address->results[0]->geometry->location->lng;
                                    ?>
                                    <input type="hidden" id="location-lat" name="location_lat" value="<?php echo $latitude; ?>">
                                    <input type="hidden" id="location-lng" name="location_lng" value="<?php echo $longitude; ?>">

                                    <div id="canvas-map" class="realty-map"></div>
                                </div>
                            </div>
                        </div><!-- .realty-map -->


                        <div class="publish-ad-button">
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