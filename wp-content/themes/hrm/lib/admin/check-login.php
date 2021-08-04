<?php
// display the login message in the header
if (!function_exists('hrm_login_head')) {
    function hrm_login_head() {
        if (is_user_logged_in()) :
            global $current_user;
            $current_user = wp_get_current_user();
            $logout_url = wp_logout_url( home_url() );
            $display_user_name = $current_user->display_name;
            ?>
            <ul>
                <li class="welcome">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <?php _e('Hi:','hrm'); ?> <strong><?php echo $display_user_name; ?></strong>
                </li>
				<li>
                    <a href="<?php echo home_url(); ?>/dang-tin">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <?php _e( 'Đăng tin Bán/Cho thuê' ,'hrm' ); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo home_url(); ?>/dashboard">
                        <i class="fa fa-tachometer" aria-hidden="true"></i>
                        <?php _e('Q.lý tin','hrm'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $logout_url; ?>">
                        <i class="fa fa-key" aria-hidden="true"></i>
                        <?php _e('Thoát','hrm'); ?>
                    </a>
                </li>
            </ul>
        <?php else : ?>
            <ul>
                <li>
                    <a href="<?php echo HOME_URL. 'dang-tin'; ?>">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <?php _e( 'Đăng tin Bán/Cho thuê' ,'hrm' ); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo HOME_URL. 'dang-ky/'; ?>">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <?php _e('Đăng ký','hrm'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo HOME_URL. 'dang-nhap/'; ?>">
                        <i class="fa fa-key" aria-hidden="true"></i>
                        <?php _e('Đăng nhập','hrm'); ?>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
            <?php
    }
}
?>