<?php
/*
 * Template Name: Đổi mật khẩu
  * @primary-color
*/
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();
// grabs the user info and puts into vars
$current_user = wp_get_current_user();
$author_id = get_current_user_id();
$display_user_name = $current_user->display_name;
$args = array(
    'post_type'  => 'page',
    'meta_key'   => '_wp_page_template',
    'meta_value' => 'template-edit-item.php'
);
$pages = get_pages( $args );
$link_p = get_permalink( $pages[0] );

get_header(); ?>
	<div class="body-content mgt30 setting-user">
      <div class="container">
          <div class="row">
              <div class="col-xs-12 col-md-3">
                  <div class="mu-title">
                      <h3>BẢNG ĐIỀU KHIỂN</h3>
                  </div>
                   <?php
                      wp_nav_menu( array(
                          'theme_location'  => 'menu-thanhvien',
                      ) );
                  ?>
              </div>
              <div class="col-xs-12 col-md-9">
                  <header class="entry-header">
                      <h1><?php printf(__("Đổi mật khẩu", 'hrm')); ?></h1>
                   
                  </header>
                    <div class="entry-content">
                        <div id="pnlchangepass" class="form-horizontal" >
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="txtOldEmail" class="col-md-3 control-label">Mật khẩu cũ</label>
                                    <div class="col-md-9">
                                        <input name="txtOldPass" min="8" type="password" id="txtOldPass" class="form-control" required="required" >
                                        <label for="txtOldPass" class="text-danger"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtNewPass" class="col-md-3 control-label">Mật khẩu mới</label>
                                    <div class="col-md-9">
                                        <input name="txtNewPass" min="8" type="password" id="txtNewPass" class="form-control" required="required">
                                        <label for="txtNewPass" class="text-danger"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtNewPass2" class="col-md-3 control-label">Xác nhận mật khẩu mới</label>
                                    <div class="col-md-9">
                                        <input name="txtNewPass2" min="8" type="password" id="txtNewPass2" class="form-control" required="required">
                                        <label for="txtNewPass2" class="text-danger"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button value="submit" id="btnChangeEmail" name="submit-user-info" class="btn btn-primary"><span>Thay đổi mật khẩu</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
              </div>
          </div>
      </div>
	</div>
<?php 
    if(isset($_POST['submit-user-info'])) {
        $oldemail = $_POST['txtOldPass'];
        $newemail = $_POST['txtNewPass'];
        if (wp_check_password( $oldemail, $current_user->user_pass, $author_id) ) {
            wp_set_password( $newemail, $author_id );
            echo '<script>alert("Đổi mật khẩu thành công, vui lòng đăng nhập lại !")</script>';
        } else {
            echo '<script>alert("Mật khẩu cũ không đúng !")</script>';
        }
        ?>
        <script>
            window.location.href = '<?php the_permalink(); ?>';
        </script><?php
    }
?>
<script>
    var password = document.getElementById("txtNewPass"), confirm_password = document.getElementById("txtNewPass2");

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
