<?php
	global $hrm_options;
	header("Content-Type: text/html; charset=utf-8");	
	define('URL_WS','https://www.nganluong.vn/micro_checkout_api.php?wsdl');	
	define('RECEIVER',$hrm_options['merchant-email']); // Email tài khoản Ngân Lượng
	define('MERCHANT_ID', $hrm_options['merchant-id']); // Mã kết nối
	define('MERCHANT_PASS', $hrm_options['merchant-pass']); // Mật khẩu kết nối
?>


	