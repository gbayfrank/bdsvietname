<?php
/*
 * Add style login
 */
function hrm_login_admin() {
    wp_enqueue_style( 'custom-login-css', get_template_directory_uri() . '/css/login.css','0.0.1' );
}
add_action( 'login_enqueue_scripts', 'hrm_login_admin',10 );

function hrm_body_class( $classes ) {
    // Get selected style
    global $hrm_options;
    $select_style_login = $hrm_options['style-login-select'];
    $classes[] = $select_style_login;
    $classes[] = 'hrm_custom_login_page';

    return $classes;
}
add_filter( 'login_body_class','hrm_body_class' );

/*
 * Add logo login
 */
function hrm_login_logo() {
  global $hrm_options;
  $link_logo    = $hrm_options['hrm-logo-login'];
  $link_bg      = $hrm_options['hrm-bg-login'];
  ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background: url("<?php echo $link_logo['url'];?>")  no-repeat center top;;
            padding-bottom: 30px;
            width: auto;
            height: auto;
            line-height: 2.5;
        }
        html {
            background: url( "<?php echo $link_bg['url'];?>" ) center center no-repeat !important;
            background-size: cover !important;
            background-color: <?php echo $color_bg;?> !important;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'hrm_login_logo' );

add_filter( 'login_redirect', 'login_redirect', 10, 3 );
function login_redirect( $redirect_to, $request, $user ) {
    if ( is_array( $user->roles ) ) {
        if ( in_array( 'administrator', $user->roles ) )
            return home_url( '/wp-admin/' );
        else
            return home_url();
    }
}

add_action('wp_logout','my_logout');
function my_logout() {
    wp_redirect( home_url());
    exit();
}
function auth_redirect_login() {
    $user = wp_get_current_user();
    if ( $user->ID == 0 ) {
        nocache_headers();
        wp_redirect(get_option('siteurl') . '/dang-nhap');
        exit();
    }
}
function redirect_login_page() {
    $login_page  = home_url( '/dang-nhap/' );
    $page_viewed = basename($_SERVER['REQUEST_URI']);
    if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
}
add_action('init','redirect_login_page');
// Kết thúc Redirect khi đăng nhập
 
// Kiểm tra lỗi đăng nhập
function login_failed() {
    $login_page  = home_url( '/dang-nhap/' );
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
add_action( 'wp_login_failed', 'login_failed' );
function verify_username_password( $user, $username, $password ) {
    $login_page  = home_url( '/dang-nhap/' );
    if( $username == "" || $password == "" ) {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
add_filter( 'authenticate', 'verify_username_password', 1, 3);