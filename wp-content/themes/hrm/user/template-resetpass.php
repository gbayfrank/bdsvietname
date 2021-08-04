<?php
/**
 * Template name: Reset password
 */
global $hrm_options,$wpdb;
if(is_user_logged_in()) {
    wp_redirect( home_url() );
}
$err = ''; 
$success = ''; 
get_header(); ?>
	<div class="login register">
		<div class="login-title">
			<h3>
				<?php 
					
				// check if we're in reset form
		        if( isset( $_POST['action'] ) && 'reset' == $_POST['action'] ) 
		        {
		            $email = trim($_POST['user_login']);
		            
		            if( empty( $email ) ) {
		                $error = __('Enter a username or e-mail address..','hrm');
		            } else if( ! is_email( $email )) {
		                $error = __('Invalid username or e-mail address.','hrm');
		            } else if( ! email_exists( $email ) ) {
		                $error = __('There is no user registered with that email address.','hrm');
		            } else {
		                
		                $random_password = wp_generate_password( 12, false );
		                $user = get_user_by( 'email', $email );
		                
		                $update_user = wp_update_user( array (
		                        'ID' => $user->ID, 
		                        'user_pass' => $random_password
		                    )
		                );
		                
		                // if  update user return true then lets send user an email containing the new password
		                if( $update_user ) {
		                    $to = $email;
		                    $subject = __('Your new password','hrm');
		                    $sender = get_option('name');
		                    
		                    $message = __('Your new password is: '.$random_password,'hrm');
		                    
		                    $headers[] = 'MIME-Version: 1.0' . "\r\n";
		                    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		                    $headers[] = "X-Mailer: PHP \r\n";
		                    $headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";
		                    
		                    $mail = wp_mail( $to, $subject, $message, $headers );
		                    if( $mail )
		                        $success = __('Check your email address for you new password.','hrm');
		                        
		                } else {
		                    $error = __('Oops something went wrong updaing your account.','hrm');
		                }
		                
		            }
		            
		            if( ! empty( $error ) )
		                echo $error;
		            
		            if( ! empty( $success ) )
		                echo $success;
		        }
                 ?>
			</h3>
			<div class="login-other">
				<span>Đã là thành viên? <a href="<?php echo home_url('/dang-nhap') ?>">Đăng nhập</a> tại đây</span>
			</div>
		</div>
		<div>
			<form method="post">
	              
	                <div class="mod-login clearfix">
						<div class="mod-login-reset clearfix">
							  <p><?php _e('Nhập địa chỉ email của bạn, chúng tôi sẽ gửi mật khẩu mới vào email.','hrm'); ?></p>
							<div class="mod-input mod-login-input-email mod-input-id">
								<label for="user_login">Tài khoản hoặc E-mail:</label>
								<?php $user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : ''; ?>
			                    <input type="text" name="user_login" id="user_login" value="<?php echo $user_login; ?>" />
			                    
							</div>
							<div class="mod-login-btn">
								<input type="hidden" name="action" value="reset" />
			                    <input type="submit" value="<?php _e('Nhận mật khẩu mới','hrm') ?>" class="button" id="submit" />
							</div>
						</div>
					</div>
	        </form>
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
