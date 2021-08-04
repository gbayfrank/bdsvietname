<?php
/**
 * Template name: Đăng tin
 */
if(!is_user_logged_in()) {
	wp_redirect( home_url('/dang-nhap'));
}
nocache_headers(); // don't cache anything
    get_header(); 
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
                <div class="row-item" id="img-main-bds">
<!-------------------------------------------------------------------chu ý------------------------------------------------------------------------------->
                    <div class="labelwrapper">
                        <label>
                            <?php _e( 'Hình ảnh BĐS' ); ?>
                        </label>
                    </div>
                    <div class="product-images fileUpload fileUpload1">
                        <span><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png" alt="Ảnh mô tả" id="thumbimage1" class="thumbimage"></span>
                        <input type="file" class="form-control upload" id="upload-filemain" name="bdsImages[]" multiple="multiple" onchange="uploadImageBDS(this);">
                    </div>
                    
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
                for ($i=1; $i <= 2 ; $i++) { ?>
                    <div class="product-images fileUpload fileUpload<?php echo $i; ?>" style="display: inline-block;">
                        <span><img src="<?php echo get_stylesheet_directory_uri();?>/images/placeholder.png" alt="Ảnh mô tả" id="sdshpreview<?php echo $i; ?>" class="thumbimage"></span>
                        <input type="file" class="form-control upload" id="upload-file<?php echo $i; ?>" name="image_upload<?php echo $i; ?>" onchange="uploadImageSDSH(this, <?php echo $i; ?>);">
                        <div class="remove-bg">
                            <button type="button" class="btn btn-xoa btn-xoa<?php echo $i; ?>" onclick="deleteImgSDSH(<?php echo $i; ?>);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Xóa
                            </button>
                        </div>
                    </div>
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
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const form              = document.querySelector('form');
        const formData          = new FormData();
        let i = 0;
        const previewImages = (files) => {  
            files = [...files]
            if (files) {
                files.forEach.call(files, readAndPreview);
            }
        }

        const readAndPreview = (file) => {
            // Make sure `file.name` matches our extensions criteria
            if (!/\.(jpe?g|png|gif|jfif)$/i.test(file.name)) {
                return alert("Bạn không được phép upload tập tin " + file.name + "!");
            } // else...
            const imgMainBds    = document.getElementById('img-main-bds');
            const reader        = new FileReader();
            reader.addEventListener("load", function() {
                let htmlPreview =  `<div class="product-images fileUpload gbay-img-main" style="display: inline-block;">
                                        <span><img src="${this.result}" alt="${file.name}" class="thumbimage"></span>
                                        <div class="remove-bg">
                                            <button type="button" class="btn btn-xoa" onclick="deletePreview(this, '${file.name}')">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Xóa
                                            </button>
                                        </div>
                                    </div>`;
                imgMainBds.innerHTML += htmlPreview;
            });
        
            reader.readAsDataURL(file);
        }

        deletePreview = (obj, fileName) => {
            obj.parentElement.parentElement.remove();
            formData.append('deleteImageBDS[]', fileName)
        }

        uploadImageBDS = (obj) => {
            previewImages(obj.files);
            for (let i = 0; i < obj.files.length; i++) {
                let file = obj.files[i]
                formData.append('bdsImages[]', file);
            }
        }

        uploadImageSDSH = (obj, id) => {
            let file = obj.files[0];
            if (!/\.(jpe?g|png|gif|jfif)$/i.test(file.name)) {
                return alert("Bạn không được phép upload tập tin " + file.name + "!");
            }
            formData.append('sdshImage' + id, file);
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                const sdshpreview = document.getElementById('sdshpreview' + id);
                sdshpreview.src = this.result;
            });
        
            reader.readAsDataURL(file);
        }

        deleteImgSDSH = (id) => {
            formData.delete('sdshImage' + id);
            const sdshpreview = document.getElementById('sdshpreview' + id);
            sdshpreview.src = "<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.png";
        }

        form.addEventListener('submit', e => {
            e.preventDefault();      
            const typeRealty        = document.getElementById('type-realty');
            const termType          = document.getElementById('term-type');
            const postTitle         = document.getElementById('postTitle');
            const address           = document.getElementById('address');
            const street            = document.getElementById('street');
            const city              = document.getElementById('city');
            const district          = document.getElementById('district');
            const ward              = document.getElementById('ward');
            const label_price       = document.getElementById('label_price');
            const post_price        = document.getElementById('post_price');
            const par_value         = document.getElementById('par_value');
            const khoangGia         = document.getElementById('khoang-gia');
            const p_rent            = document.getElementById('p_rent');
            const post_area         = document.getElementById('post_area');
            const post_sizeuse      = document.getElementById('post_sizeuse');
            const post_width        = document.getElementById('post_width');
            const post_long         = document.getElementById('post_long');
            const post_width2       = document.getElementById('post_width2');
            const floor             = document.getElementById('floor');
            const post_bedroom      = document.getElementById('post_bedroom');
            const room_wc           = document.getElementById('room_wc');
            const incomehas         = document.getElementById('incomehas');
            const income            = document.getElementById('income');
            // Checkbox
            const hemoto            = document.getElementById('hemoto');
            const elevator          = document.getElementById('elevator');
            const car_in            = document.getElementById('car_in');
            const interior          = document.getElementById('interior');
            const interiorwhat      = document.getElementById('interiorwhat');
            const basement          = document.getElementById('basement');
            // Checkbox End
            const strtwidth         = document.getElementById('strtwidth');
            const stair             = document.getElementById('stair');
            const quarterRealty     = document.getElementById('quarter-realty');
            const note              = document.getElementById('note');
            const post_name_contact = document.getElementById('post_name_contact');
            const post_phone_contact= document.getElementById('post_phone_contact');
            const post_affiliate    = document.getElementById('post_affiliate');
            const post_support      = document.getElementById('post_support');
            const post_p_status     = document.getElementById('post_p_status');
            const sold              = document.getElementById('sold');
            const postContent       = document.getElementById('postContent');
            const map_address       = document.getElementById('realty-address');
            const location_lat      = document.getElementById('location-lat');
            const location_lng      = document.getElementById('location-lng');
            const end_date          = document.getElementById('end-date');
            const submitted         = document.getElementById('submitted');
            const post_nonce_field  = document.getElementById('post_nonce_field');

            formData.append('action', 'dang_tin');
            formData.append('type-realty', typeRealty.value);
            formData.append('term-type', termType.value);
            formData.append('postTitle', postTitle.value);
            formData.append('address', address.value);
            formData.append('street', street.value);
            formData.append('city', city.value);
            formData.append('district', district.value);
            formData.append('ward', ward.value);
            formData.append('label_price', label_price.value);
            formData.append('post_price', post_price.value);
            formData.append('par_value', par_value.value);
            formData.append('khoang-gia', khoangGia.value);
            formData.append('p_rent', p_rent.value);
            formData.append('post_area', post_area.value);
            formData.append('post_sizeuse', post_sizeuse.value);
            formData.append('post_width', post_width.value);
            formData.append('post_long', post_long.value);
            formData.append('post_width2', post_width2.value);
            formData.append('floor', floor.value);
            formData.append('post_bedroom', post_bedroom.value);
            formData.append('room_wc', room_wc.value);
            formData.append('incomehas', incomehas.value);
            formData.append('interiorwhat', interiorwhat.value);
            formData.append('income', income.value);
            // Checkbox
            formData.append('hemoto', hemoto.value);
            formData.append('elevator', elevator.value);
            formData.append('car_in', car_in.value);
            formData.append('interior', interior.value);
            formData.append('basement', basement.value);
            // Checkbox End
            formData.append('strtwidth', strtwidth.value);
            formData.append('stair', stair.value);
            formData.append('quarter-realty', quarterRealty.value);
            formData.append('note', note.value);
            formData.append('post_name_contact', post_name_contact.value);
            formData.append('post_phone_contact', post_phone_contact.value);
            formData.append('post_affiliate', post_affiliate.value);
            formData.append('post_support', post_support.value);
            formData.append('post_p_status', post_p_status.value);
            formData.append('sold', sold.value);
            formData.append('postContent', postContent.value);
            formData.append('map_address', map_address.value);
            formData.append('location_lat', location_lat.value);
            formData.append('location_lng', location_lng.value);
            formData.append('end_date', end_date.value);
            formData.append('submitted', submitted.value);
            formData.append('post_nonce_field', post_nonce_field.value);
            // Append files to files array            
            async function postData(url = '', data = {}, ld = false) {
                if(ld == true) loading();
                // Default options are marked with *
                const response = await fetch(url, {
                    method: 'POST', 
                    body: data
                });
                return response.json(); // parses JSON response into native JavaScript objects
            }

            postData('<?php echo admin_url('admin-ajax.php'); ?>', formData, true)
            .then(data => {
                if(data.sucess == true) {
                    alert('Đăng tin thành công');
                    window.location.href = data.url;
                } else {
                    alert('Bạn cần nhập tiêu đề');
                }
            });
        })
        loading = () => {
            var divloading = document.createElement('div');
            divloading.classList.add('loading');
            document.body.appendChild(divloading);
        }
    })            
</script>
<style>
    /* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
<?php
get_footer();