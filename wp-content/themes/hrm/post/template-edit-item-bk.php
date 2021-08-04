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
$query = new WP_Query(
    array(
        'post_type'      => 'realty', 
        'posts_per_page' =>'-1',
        'p'              => $_GET['post'],

    ) 
);
if ($query->have_posts()) { while ($query->have_posts()) { $query->the_post();
    $current_post = $_GET['post'];
    $title = get_the_title();
    $content = get_the_content();
    $posttags = get_the_tags($current_post);
    if ($posttags) {
      foreach($posttags as $tag) {
        $tags_list = $tag->name . ' ';
    }
}

        // term taxonomy

$khoang_gia = get_the_terms( $current_post, 'khoang-gia' );
$khoang_gia_id = $khoang_gia[0]->term_id;

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
        // set custom field
        /*
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
        $area_realty = get_post_meta( $current_post , 'area_realty' , true );
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

        $post_map           = get_post_meta( $current_post , 'location' , true );


        /*
        * tabs realty-image
        */
        $post_gallery = rwmb_meta('gallery');

        $meta = array(
            'gallery'       => isset( $_POST['gallery'] ) ? $_POST['gallery'] : array(),
        );
    } 
} else { ?>
    <script>
        window.location.href = '<?php echo home_url(); ?>';
        </script><?php
    }
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
                $postStatus = 'pending';
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
            update_post_meta($current_post, '_sku', esc_attr( $current_post ) );

            update_post_meta($current_post, 'address', wp_kses($_POST['address'], $allowed));
            update_post_meta($current_post, 'street', wp_kses($_POST['street'], $allowed));
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
                    var_dump($_POST[$namecu]);
                    $image_name = $_FILES[$name_upload]["name"];
                    $image_name = str_replace(" ", "-", basename($image_name));
                    $image_path = $_FILES[$name_upload]["tmp_name"];
                    $new_image_path = "./images/".$image_name;
                    $image_upload = move_uploaded_file($image_path, $new_image_path);
                    $image_url = home_url().'/images/'.$image_name;
                    $upload_dir = wp_upload_dir();
                    $image_data = ViewSource($image_url);
                    $filename = $post_id.basename($image_url);
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
                       add_post_meta( $post_id, 'gallery', $attach_id, false );
                    } else {
                        add_post_meta( $post_id, 'legaldoc', $attach_id, false );
                    }
                  $checki = get_the_post_thumbnail( $current_post );
                  if(!$checki) {
                    $res2 = set_post_thumbnail($current_post, $attach_id );
                }
                unlink($new_image_path);
            }
            if($_POST[$namecu] != '') {
                add_post_meta( $current_post, 'gallery', $_POST[$namecu], false );
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
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Tỉnh thành','hrm' ); ?>
                                            </label><br>
                                        </div>
                                        <select name="city" id="city" class="quick-city-edit">
                                            <option value="">- Chọn tỉnh / thành phố -</option>
                                            <?php
                                            $args_city = array(
                                                'child_of'               => 0,
                                                'parent'                 => 0,
                                                'hide_empty'        => 0,
                                            );
                                            $term_citys = get_terms( 'city-realty' , $args_city );
                                            foreach ($term_citys as $term_city) { 
                                                if($term_city->term_id == $tc_id) {?>
                                                    <option value="<?php echo $term_city->term_id; ?>" selected="selected"><?php echo $term_city->name; ?></option><?php
                                                } else { ?>
                                                    <option value="<?php echo $term_city->term_id; ?>" ><?php echo $term_city->name; ?></option><?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Quận huyện','hrm' ); ?>
                                            </label><br>
                                        </div>
                                        <select id="district" class="quick-district" name="district" >
                                            <option value="">- Chọn Quận / huyện -</option>
                                            <?php
                                            foreach ($termds as $termd) {
                                                $cha_tad = $termd->parent;
                                                $term_cha_tad = get_term( $cha_tad, 'city-realty');
                                                if ($termd->parent != 0 && $term_cha_tad->parent == 0) {
                                                    if ($td_id == $termd->term_id) {
                                                        $optiond .= '<option value="'.$termd->term_id.'" selected="selected">';
                                                        $optiond .= $termd->name;
                                                        $optiond .= '</option>';
                                                    } else {
                                                        $optiond .= '<option value="'.$termd->term_id.'">';
                                                        $optiond .= $termd->name;
                                                        $optiond .= '</option>';
                                                    }   
                                                }
                                            }
                                            echo $optiond;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row-item post-city">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Phường xã','hrm' ); ?>
                                            </label><br>
                                        </div>
                                        <select name="ward" id="ward" class="quick-ward">
                                            <option value="">- Chọn phường / xã -</option>
                                            <?php
                                            foreach ($termas as $terma) {
                                                $cha_taa = $terma->parent;
                                                $term_cha_taa = get_term( $cha_taa, 'city-realty');
                                                if ($terma->parent != 0 && $term_cha_taa->parent != 0) {
                                                    if ($ta_id == $terma->term_id) {
                                                        $optiona .= '<option value="'.$terma->term_id.'" selected="selected">';
                                                        $optiona .= $terma->name;
                                                        $optiona .= '</option>';
                                                    } else {
                                                        $optiona .= '<option value="'.$terma->term_id.'">';
                                                        $optiona .= $terma->name;
                                                        $optiona .= '</option>';
                                                    }   
                                                }
                                            }
                                            echo $optiona;
                                            ?>
                                        </select>
                                    </div>
                                    <script>

                                    </script>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Thuộc dự án','hrm' ); ?>
                                            </label><br>
                                        </div>
                                        <select name="inproject" id="inproject" class="inproject">
                                            <option value="">- Chọn dự án -</option>
                                            <?php
                                            $args_project = array(
                                                'child_of'               => 0,
                                                'parent'                 => 0,
                                                'hide_empty'        => 0,
                                            );
                                            $term_projects = get_terms( 'project_cat' , $args_project );
                                            foreach ($term_projects as $term_project) { 
                                                if($term_project->term_id == $post_project) { ?>
                                                    <option value="<?php echo $term_project->term_id; ?>" selected><?php echo $term_project->name; ?></option><?php
                                                } else { ?>
                                                    <option value="<?php echo $term_project->term_id; ?>"><?php echo $term_project->name; ?></option><?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row-item post-prince">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Giá' ); ?>
                                            </label>
                                        </div>
                                        <input name="post_price" id="post_price" type="text" value="<?php echo $post_price; ?>" >
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="labelwrapper">
                                            <label>
                                                <?php _e( 'Chọn mệnh giá' ); ?>
                                            </label>
                                        </div>
                                        <select name="par_value" id="par_value">
                                            <?php
                                            $pars = array(
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
                                </div>
                            </div>
                            <div class="row-item post-area">
                             <div class="row">
                              <div class="col-sm-6 col-xs-12">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Hướng','hrm' ); ?>
                                    </label><br>
                                </div>
                                <select id="quarter-realty" name="quarter-realty">
                                    <?php
                                    $quarter_current = wp_get_post_terms($current_post,'quarter',array("parent" => 0));
                                    $args = array(
                                        'child_of'               => 0,
                                        'parent'                 => 0,
                                        'hide_empty'            => 0
                                    );
                                    $terms = get_terms( 'quarter' , $args );
                                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                                        foreach ( $terms as $term ) {
                                            echo '<option value="'.$term->slug.'" '.(($term->slug==$quarter_current[0]->slug)?'selected="selected"':"").'>'.$term->name.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Diện tích' ); ?>
                                    </label>
                                </div>
                                <input name="post_area" id="post_area" type="number" value="<?php echo $post_area; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row-item post-area">
                        <div class="row">

                            <div class="col-sm-6 col-xs-12">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Số phòng ngủ' ); ?>
                                    </label>
                                </div>
                                <select name="post_bedroom" id="post_bedroom">
                                    <option value="">- Số phòng ngủ -</option>
                                    <?php
                                    $bedrooms = array(
                                        'khong-xac-dinh' => 'Không xác định',
                                        '1' => '1+',
                                        '2' => '2+',
                                        '3' => '3+',
                                        '4' => '4+',
                                        '5' => '5+',
                                    );
                                    foreach ($bedrooms as $bedroom => $value ) {
                                        echo '<option value="'.$bedroom.'" '.(($bedroom==$post_bedroom)?'selected="selected"':"").'>'.$value.'</option>';
                                    }
                                    ?>
                                </select>
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
                                        <?php _e( 'Tên liên hệ' ); ?>
                                        <span class="colour">*</span>
                                    </label>
                                </div>
                                <input required name="post_name_contact" id="post_name_contact" type="text" value="<?php echo $post_name_contact; ?>">
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Số điện thoại' ); ?>
                                        <span class="colour">*</span>
                                    </label>
                                </div>
                                <input required name="post_phone_contact" id="post_phone_contact" type="text" value="<?php echo $post_phone_contact; ?>"  data-pattern="^[0-9]+$">
                            </div>
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Zalo liên hệ' ); ?>

                                    </label>
                                </div>
                                <input name="post_zalo_contact" id="post_zalo_contact" type="text" value="<?php echo $post_zalo_contact; ?>">
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Skype liên hệ' ); ?>
                                    </label>
                                </div>
                                <input name="post_skype_contact" id="post_skype_contact" type="text" value="<?php echo $post_skype_contact; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="labelwrapper">
                                    <label>
                                        <?php _e( 'Email liên hệ' ); ?>
                                    </label>
                                </div>
                                <input name="post_email_contact" id="post_email_contact" type="email" value="<?php echo $post_email_contact; ?>">
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
                        for ($i=1; $i < 9 ; $i++) { ?>
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
                                });
                            })
                               </script><?php
                           } ?>
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
                </div><!-- .realty-images -->
                <div class="realty-map">
                    <div class="row-item">
                        <div class="h2">
                            <span><?php _e( 'Bản đồ','hrm' ); ?></span>
                        </div>
                    </div>
                    <div class="row-item">
                        <input type="text" name="address" id="realty-address" value="<?php echo $post_address; ?>" class="wide">
                    </div>
                    <div class="row-item">
                        <div class="realty-wrap">
                            <?php
                            $address = get_infor_from_address($post_address);
                            $latitude = $address->results[0]->geometry->location->lat;
                            $longitude =$address->results[0]->geometry->location->lng;
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
