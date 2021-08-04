<?php
/**
 * Template name: Đăng ký
 */
global $hrm_options;

if(is_user_logged_in()) {
	wp_redirect( home_url() );
}
session_start();
$check_capt = '';
get_header(); ?>
<div class="login register">
	<div class="login-title">
		<h3>
			<?php 
			$err = ''; 
			$success = ''; 
			global $wpdb, $PasswordHash, $current_user, $user_ID; 
			if(isset($_POST['task']) && $_POST['task'] == 'register' ) {
				if ($_SESSION['answer'] == $_POST['answer'] ) {

					$pwd1 = $wpdb->escape(trim($_POST['pwd1']));
					$pwd2 = $wpdb->escape(trim($_POST['pwd2']));
					$email = $wpdb->escape(trim($_POST['email']));
					$username = $wpdb->escape(trim($_POST['username']));
					if( $email == "" || $pwd1 == "" || $pwd2 == "" || $username == "") {
						$err = 'Vui lòng không bỏ trống những thông tin bắt buộc!';
					} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$err = 'Địa chỉ Email không hợp lệ!.';
					} else if(email_exists($email) ) {
						$err = 'Địa chỉ Email đã tồn tại!.';
					} else if($pwd1 <> $pwd2 ){
						$err = '2 Password không giống nhau!.';
					} else {
						$user_id = wp_insert_user( 
							array (
								'user_pass' => apply_filters('pre_user_user_pass', $pwd1), 
								'user_login' => apply_filters('pre_user_user_login', $username), 
								'user_email' => apply_filters('pre_user_user_email', $email), 
								'role' =>'contributor' 
							) 
						);
						if( is_wp_error($user_id) ) {
							$err = 'Lỗi khởi tạo người dùng';
						} else {
							do_action('user_register', $user_id);
							$success = 'Bạn đã đăng ký thành công!';
							$current_user = get_user_by( 'id', $user_id );
								// set the WP login cookie
							$secure_cookie = is_ssl() ? true : false;
							wp_set_auth_cookie( $user_id, true, $secure_cookie ); ?>
							<script>
								alert('Đăng ký thành công');
								window.location.href = '<?php echo home_url('/dang-nhap'); ?>';
								</script><?php
								exit;
							}
						}
					}
					else {
						$check_capt = 'Sai captcha. Vui lòng nhập lại';
						$digit1 = mt_rand(1,20);
						$digit2 = mt_rand(1,20);
						if( mt_rand(0,1) === 1 ) {
							$math = "$digit1 + $digit2";
							$_SESSION['answer'] = $digit1 + $digit2;
						} else {
							$math = "$digit1 - $digit2";
							$_SESSION['answer'] = $digit1 - $digit2;
						}
					}
				} else {
					$digit1 = mt_rand(1,20);
					$digit2 = mt_rand(1,20);
					if( mt_rand(0,1) === 1 ) {
						$math = "$digit1 + $digit2";
						$_SESSION['answer'] = $digit1 + $digit2;
					} else {
						$math = "$digit1 - $digit2";
						$_SESSION['answer'] = $digit1 - $digit2;
					}
				}

				if (!empty($err)) { 
					echo $err;
				
					$digit1 = mt_rand(1,20);
					$digit2 = mt_rand(1,20);
					if( mt_rand(0,1) === 1 ) {
						$math = "$digit1 + $digit2";
						$_SESSION['answer'] = $digit1 + $digit2;
					} else {
						$math = "$digit1 - $digit2";
						$_SESSION['answer'] = $digit1 - $digit2;
					}

				} else {
					echo 'Đăng ký';
				}
				if(! empty($success) ) :
					?>
					<script>
						alert('Đăng ký thành công');
						window.location.href = '<?php echo home_url('/dang-nhap'); ?>';
						</script><?php
					endif;
					?>
				</h3>
				<div class="login-other">
					<span>Đã là thành viên? <a href="<?php echo home_url('/dang-nhap') ?>">Đăng nhập</a> tại đây</span>
				</div>
			</div>
			<div>
				<form class="form-horizontal" method="post" role="form">
					<div class="mod-login clearfix">
						<div class="mod-login-col1 clearfix">
							<?php if ( $check_capt ) { ?>
								<div class="alert alert-danger" role="alert"><?php echo $check_capt ?></div>
							<?php } ?>
							<div class="mod-input mod-login-input-email mod-input-id">
								<label>Tên đăng nhập</label>
								<input type="text" placeholder="Vui lòng nhập tên tài khoản" name="username" id="username" value="<?php echo ($_POST['username'])? trim($_POST['username']) : '' ?>" required />
								<b></b>
								<span></span>
							</div>

							<div class="mod-input mod-input-password mod-login-input-password mod-input-password">
								<label>Mật khẩu</label>
								<input type="password" name="pwd1" id="pwd1" placeholder="<?php _e('Mật khẩu','hrm'); ?>" value="<?php echo ($_POST['pwd1'])? trim($_POST['pwd1']) : '' ?>" required />
								<b></b>
								<span></span>
							</div>

							<div class="mod-input mod-input-password mod-login-input-re-password mod-input-re-password">
								<label>Nhập lại mật khẩu</label>
								<input type="password" name="pwd2" id="pwd2" placeholder="<?php _e('Nhập lại mật khẩu','hrm'); ?>" value="<?php echo ($_POST['pwd2'])? trim($_POST['pwd2']) : '' ?>" required />
								<b></b>
								<span></span>
								<div class="mod-input-password-icon"></div>
							</div>
							<div class="mod-input mod-input-captcha">
								<label><?php echo $math; ?> = ?</label>
								<input id="captcha" name="answer" type="number" />
							</div>
						</div>
						<div class="mod-login-col2 clearfix">
							<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
							<div class="mod-input mod-login-input-email mod-input-email">
								<label>Địa chỉ email</label>
								<input type="email" name="email" id="email" placeholder="Email" value="<?php echo ($_POST['email'])? trim($_POST['email']) : '' ?>" required />
								<b></b>
								<span></span>
							</div>
							<div class="mod-login-btn">
								<button type="submit" class="next-btn next-btn-primary next-btn-large">ĐĂNG KÍ</button>
								<input type="hidden" name="task" value="register" />
							</div>
							<div class="mod-login-third">
								<div class="mod-third-party-login">
									<div class="mod-third-party-login-line">
										<span>Hoặc kết nối với tài khoản mạng xã hội</span>
									</div>
									<div class="mod-third-party-login-bd">
										<a href="<?php echo home_url() ?>/wp-login.php?loginSocial=facebook" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="facebook" data-popupwidth="475" data-popupheight="175" class="btn-login-fb">
											<i class="fa fa-facebook" aria-hidden="true"></i> Facebook
										</a>
									</div>
									<div class="login-gg">
										<a href="<?php echo home_url() ?>/wp-login.php?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="btn-login-gg">
											<i class="fa fa-google-plus" aria-hidden="true"></i> Google
										</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			var password = document.getElementById("pwd1"), confirm_password = document.getElementById("pwd2");

			function validatePassword(){
				if(password.value != confirm_password.value) {
					confirm_password.setCustomValidity("Mật khẩu không trùng khớp");
				} else {
					confirm_password.setCustomValidity('');
				}
			}
			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
		</script>
		<style>
		.paper {
			background-color: #eff0f5;
		}
	</style>
	<?php
	get_footer();