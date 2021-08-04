<?php
/**
 * Template name: Đăng nhập
 */
global $hrm_options;
if(is_user_logged_in()) {
  if(is_super_admin()) { ?>
    <script>
      window.location.href = '<?php echo home_url('dashboard'); ?>';
    </script><?php
  } else { ?>
    <script>
      window.location.href = '<?php echo home_url('tin-da-dang'); ?>';
    </script><?php
  }
}
get_header(); ?>
	<div class="login">
		<div class="login-title">
			<h3>
				<?php
					$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
					if ( $login === "failed" ) {
					    echo 'Sai tài khoản hoặc mật khẩu.';
					} elseif ( $login === "empty" ) {
					    echo 'Tài khoản và mật khẩu không thể bỏ trống';
					} elseif ( $login === "false" ) {
					    echo 'Bạn đã thoát ra.';
					} else {
							echo 'Đăng nhập';
					}
              	?>
			</h3>
			<div class="login-other">
				<span>Thành viên mới? <a href="<?php echo home_url('/dang-ky') ?>">Đăng kí</a> tại đây</span>
			</div>
		</div>
		<div>
			
			<div class="mod-login clearfix">
				<div class="mod-login-col1 clearfix">
					<?php
                        $args = array(
							'redirect'       => site_url( $_SERVER['REQUEST_URI'] ),
							'form_id'        => 'dangnhap', //Để dành viết CSS
							'label_username' => __( 'Tên tài khoản' ),
							'label_password' => __( 'Mật khẩu' ),
							'label_remember' => __( 'Ghi nhớ' ),
							'label_log_in'   => __( 'Đăng nhập' ),
                        );
                      	wp_login_form($args);
                      ?>
                      <div class="forgot">
                      	<a href="<?php echo home_url('/reset-password') ?>">Quên mật khẩu ?</a>
                      </div>
				</div>
			<div class="mod-login-col2 clearfix">
				<div class="mod-login-third">
					<div class="mod-third-party-login mod-login-third-btns">
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
			</div>
			
		</div>
	</div>
	<style>
		.paper {
			background-color: #eff0f5;
		}
	</style>

<?php
get_footer();