<?php
/* Template Name: Thanh toán */
if(!is_user_logged_in()) {
	wp_redirect( home_url('/dang-nhap'));
}
global $hrm_options;
$user_id = get_current_user_id();
$post_id = $_GET['post_id'];
require_once( dirname( __FILE__ ).'/config.php');
require_once( dirname( __FILE__ ).'/include/lib/nusoap.php');
require_once( dirname( __FILE__ ).'/include/nganluong.microcheckout.class.php');
	$return_url = home_url().'/hoan-tat-thanh-toan/';
	$cancel_url = $_SERVER['HTTP_REFERER'];
	$name = 'Trả phí đăng bài viết';
	$amount = $hrm_options['price-post'];
	$items = array(
		'item_name'		=> $name,
		'item_amount'	=> $amount,
		'item_id'	=> $post_id,
		'user_id' => $user_id
	);
	//$receiver = '';
	$inputs = array(
		'receiver'		=> RECEIVER,
		'order_code'	=> 'Đơn hàng-'.date('His-dmY'),
		'amount'		=> $amount,
		'currency_code'	=> 'vnd',
		'tax_amount'	=> '0',
		'discount_amount'	=> '0',
		'fee_shipping'	=> '0',
		'request_confirm_shipping'	=> '0',
		'no_shipping'	=> '1',
		'return_url'	=> $return_url,
		'cancel_url'	=> $cancel_url,
		'language'		=> 'vi',
		'items'			=> $items
	);
	$link_checkout = '';
	$obj = new NL_MicroCheckout(MERCHANT_ID, MERCHANT_PASS, URL_WS);
	$result = $obj->setExpressCheckoutPayment($inputs);
	if ($result != false) {
		if ($result['result_code'] == '00') {
			$link_checkout = $result['link_checkout'];
			
		} else {
			die('Mã lỗi '.$result['result_code'].' ('.$result['result_description'].') ');
		}
	} else {
		die('Lỗi kết nối tới cổng thanh toán Ngân Lượng');
	}
	
get_header(); ?>
	<div id="primary" class="content-area col-md-9">
        <?php while ( have_posts() ) : the_post(); ?>
        <main id="main" class="site-main" role="main">
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <div class="form-bill">
            	<input class="button" type="button" id="btn_payment" value="Thanh toán" />
            </div>
        </main>
      	<?php endwhile; ?>
    </div>
    <script language="javascript" src="<?php echo get_template_directory_uri(); ?>/post/include/nganluong.apps.mcflow.js"></script>
  	<script language="javascript">
		var mc_flow = new NGANLUONG.apps.MCFlow({trigger:'btn_payment',url:'<?php echo @$link_checkout;?>'});
	</script>
<?php
get_sidebar();
get_footer();
