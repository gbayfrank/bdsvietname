<?php
/* Template Name: Hoàn tất thanh toán */
 // * 
if(!is_user_logged_in()) {
	wp_redirect( home_url('/dang-nhap'));
}
global $hrm_options;
$user_id = get_current_user_id();
$post_id = $_GET['post_id'];
require_once( dirname( __FILE__ ).'/config.php');
require_once( dirname( __FILE__ ).'/include/lib/nusoap.php');
require_once( dirname( __FILE__ ).'/include/nganluong.microcheckout.class.php');
	//khai bao
	$obj = new NL_MicroCheckout(MERCHANT_ID, MERCHANT_PASS, URL_WS);
	
	if ($obj->checkReturnUrlAuto()) {
		$inputs = array(
			'token'		=> $obj->getTokenCode(),//$token_code,
		);
	
		$result = $obj->getExpressCheckout($inputs);
		if ($result != false) {
			if ($result['result_code'] != '00') {
				die('Mã lỗi '.$result['result_code'].' ('.$result['result_description'].') ');
			}
		} else {
			die('Lỗi kết nối tới cổng thanh toán Ngân Lượng');
		}
	} else {
		die('Tham số truyền không đúng');
	}
get_header(); ?>
	<div id="primary" class="content-area col-md-9">
        <?php while ( have_posts() ) : the_post(); ?>
        <main id="main" class="site-main" role="main">
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <div class="form-payment">
            	<?php
					if (isset($result) && !empty($result)) {
						if ($result['result_code'] == '00') {
							$ld_args = array(
								'post_type'      => 'lich-su-nap',
								's' => $_GET['order_code'],
								'exact' => true, 
							);
							$ld_abxf = new WP_Query ($ld_args);
							if($ld_abxf->have_posts()) {
								echo 'Giao dịch đã thực hiện lần trước không thể tiếp tục thao tác';
							} else {
								if (isset($_GET['post_id'])) {
									if(get_post_meta( $post_id, 'thanh-toan')[0] == 0 || get_post_meta( $post_id, 'thanh-toan')[0] == NULL) {
										update_post_meta( $post_id, 'thanh-toan', 1);
										$post_information = array(
							                'ID' => $post_id,
							                'post_status' => 'publish'
							            );
							            $post_id = wp_insert_post($post_information); 
							            echo 'Bài viết đã được kích hoạt thành công.';
									} else { 
							            echo 'Bài viết đã được thanh toán bạn không thể tiếp tục thanh toán. Vui lòng liên hệ lại chúng tôi để được hỗ trợ.');
									}
								}
								$post_information = array(
					                'post_title' => esc_attr($_GET['order_code']),
					                'post_type' => 'lich-su-nap',
					                'post_status' =>'publish',
					                'post_author' => $user_id,
					            );
					            $post_ids = wp_insert_post($post_information);
					            update_post_meta($post_ids, 'mdh', $_GET['order_code']);
					            update_post_meta($post_ids, 'hinh-thuc-nap', $result['method_payment_name']);
								update_post_meta($post_ids, 'menh-gia',  $result['amount']);
								update_post_meta($post_ids, 'ten-nguoi-mua', $result['payer_name']);
								update_post_meta($post_ids, 'email-nguoi-mua',  $result['payer_email']);
								update_post_meta($post_ids, 'sdt-nguoi-mua',  $result['payer_mobile']);
							} ?>
							<table border="1" cellpadding="3" class="table table-responsive table-striped">
								<tr><th colspan="2">Thông tin đơn hàng</th></tr>
								<tr><td width="200">Mã đơn hàng</td><td><?php echo @$_GET['order_code'];?></td></tr>
								<tr><td>Mã giao dịch</td><td><?php echo $result['transaction_id'];?></td></tr>
								<tr><td>Loại giao dịch</td><td><?php echo ($result['transaction_type'] == 1 ? 'Thanh toán ngay' : 'Thanh toán tạm giữ');?></td></tr>
								<tr><td>Trạng thái</td><td><?php echo $result['transaction_status'];?></td></tr>
								<tr><td>Số tiền</td><td><?php echo $result['amount'];?></td></tr>
								<tr><td>Hình thức thanh toán</td><td><?php echo $result['method_payment_name'];?></td></tr>
								<tr><td>Tên người mua</td><td><?php echo $result['payer_name'];?></td></tr>
								<tr><td>Email người mua</td><td><?php echo $result['payer_email'];?></td></tr>
								<tr><td>Điện thoại người mua</td><td><?php echo $result['payer_mobile'];?></td></tr>
							</table><?php			
						} else {
							echo $result['result_description'];
						}
					}
				?>
            </div>
        </main>
      	<?php endwhile; ?>
    </div>
<?php
get_sidebar();
get_footer();
