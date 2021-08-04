<?php
    /**
     * HRM Theme Options
     * HRM Config
     *
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "hrm_options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'theme_opt/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'hrm' ),
        'page_title'           => __( 'Theme Options', 'hrm' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'hrm' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'hrm' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'hrm' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'hrm' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '', 'hrm' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Cài đặt', 'hrm' ),
        'id'               => 'hrm-settings',
        'customizer_width' => '400px',
        'icon'             => 'el el-cog',
        'fields'           => array(
            array(
                'title'     => __( 'Hotline text' ,'hrm'),
                'id'        => 'hrm_hotline_text',
                'type'      => 'text',
            ),
            array(
                'title'     => __( 'Hotline' ,'hrm'),
                'id'        => 'hrm_hotline_rung',
                'type'      => 'text',
                'validate' => 'numeric',
            ),
            array(
                'title'     => __( 'Google Map API' ,'hrm'),
                'id'        => 'hrm_api_map',
                'type'      => 'text',
            ),
            array(
                'title'     => __( 'Header code' ,'hrm'),
                'subtitle'     => __( '' , 'hrm' ) ,
                'id'        => 'hrm-header-code',
                'desc'      => __('Nhập mã được chèn vào tiêu đề' , 'hrm'),
                'type'      => 'textarea',
                'default'   => ''
            ),
            array(
                'title'     => __( 'Footer code' ,'hrm'),
                'subtitle'     => __( '' , 'hrm' ) ,
                'id'        => 'hrm-footer-code',
                'desc'      => __('Nhập mã được chèn vào chân trang' , 'hrm'),
                'type'      => 'textarea',
                'default'   => ''
            ),
        ),
    ) );

    /*----------------------------------------------------------------------*/
    /* Header Section
    /*----------------------------------------------------------------------*/
    Redux::setSection( $opt_name, array(
        'title' => __('Cấu hình đầu trang', 'hrm'),
        'id'               => 'hrm-settings-general-h',
        'icon'             => 'el el-screen',
        'fields'           => array(
            array(
                'id'       => 'hrm-logo',
                'type'     => 'media',
                'title'    => __( 'Logo', 'hrm' ),
                'subtitle' => __( 'Cài đặt logo.', 'hrm' ),
                'desc'     => __( 'Thay đổi logo tại đây.', 'hrm' ),
            ),
            array(
                'id'       => 'hrm-logo-dimensions',
                'type'     => 'dimensions',
                'title'    => __( 'Kích thước logo', 'hrm' ),
                'units'    => array('em','px','%'),
                'default'  => array(
                    'Width'   => '240',
                    'Height'  => '63'
                ),
            ),
            array(
                'id'       => 'hrm-favicon',
                'type'     => 'media',
                'title'    => __( 'Favicon', 'hrm' ),
                'subtitle' => __( 'Cài đặt Favicon.', 'hrm' ),
                'desc'     => __( 'Thay đổi favicon.', 'hrm' ),
            ),
            array(
                'id'       => 'hrm-phone',
                'type'     => 'text',
                'title'    => __( 'Phone', 'hrm' ),
            ),
            array(
                'id'       => 'hrm-banner-link',
                'type'     => 'text',
                'title'    => __( 'Đường dẫn banner', 'hrm' ),
            ),
            array(
                'id'       => 'hrm-banner-ads',
                'type'     => 'media',
                'title'    => __( 'Banner Ads', 'hrm' ),
                'subtitle' => __( 'Cấu hình Banner Ads.', 'hrm' ),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Cài đặt thanh toán', 'hrm' ),
        'id'               => 'hrm-settings-pay',
        'icon'             => 'el el-shopping-cart',
        'fields'           => array(
            array(
                'id'       => 'hrm_put_bill',
                'type'     => 'switch',
                'title'    => __( 'Bật tắt thanh toán bài viết', 'hrm' ),
            ),
            array(
                'id'       => 'price-post',
                'type'     => 'text',
                'title'    => __( 'Giá tiền đăng bài viết', 'hrm' ),
                'required' => array( 'hrm_put_bill', '=', '1' ),
            ),
            array(
                'id'       => 'merchant-id',
                'type'     => 'text',
                'title'    => __( 'Nhập Merchant ID', 'hrm' ),
                'required' => array( 'hrm_put_bill', '=', '1' ),
            ),
            array(
                'id'       => 'merchant-email',
                'type'     => 'text',
                'title'    => __( 'Nhập Merchant Email', 'hrm' ),
                'required' => array( 'hrm_put_bill', '=', '1' ),
            ),
            array(
                'id'       => 'merchant-pass',
                'type'     => 'text',
                'title'    => __( 'Nhập Merchant Pass', 'hrm' ),
                'required' => array( 'hrm_put_bill', '=', '1' ),
            ),
        ),
    ) );
    // -> START Select Fields
    Redux::setSection( $opt_name, array(
        'title' => __( 'Cấu hình sidebar', 'hrm' ),
        'id'    => 'hrm-sidebar-setting',
        'icon'  => 'el el-website',
        'fields'     => array(
            array(
                'id'       => 'default-sidebar-postion',
                'type'     => 'image_select',
                'title'    => __( 'Vị trí sidebar mặc định', 'hrm' ),
                'options'  => array(
                    'sidebar-left' => array(
                        'alt' => '1 Column',
                        'img' => THEME_URL . 'lib/admin/images/sidebar-left.png'
                    ),
                    'sidebar-right' => array(
                        'alt' => '2 Column',
                        'img' => THEME_URL . 'lib/admin/images/sidebar-right.png'
                    ),
                ),
                'default'  => 'sidebar-left'
            ),
        ),
    ) );
    // -> START Select Fields
    Redux::setSection( $opt_name, array(
        'title' => __( 'Cấu hình lưu trữ', 'hrm' ),
        'id'    => 'hrm-archive-setting',
        'icon'  => 'el el-adjust-alt',
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Cấu hình chung', 'hrm' ),
        'id'         => 'archive-ganeral-setting',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'arc_show_meta',
                'type'     => 'switch',
                'title'    => __( 'Hiển thị meta', 'hrm' ),
                'default'  => 1,
                'on'       => 'Enabled',
                'off'      => 'Disabled',
            ),
            array(
                'id'       => 'arc_meta_author',
                'type'     => 'switch',
                'title'    => __( 'Bật / Tắt tác giả', 'hrm' ),
                'required' => array( 'arc_show_meta', '=', '1' ),
                'default'  => true,
            ),
            array(
                'id'       => 'arc_meta_date',
                'type'     => 'switch',
                'title'    => __( 'Bật / Tắt Ngày đăng', 'hrm' ),
                'required' => array( 'arc_show_meta', '=', '1' ),
                'default'  => true,
            ),
            array(
                'id'       => 'arc_meta_cats',
                'type'     => 'switch',
                'required' => array( 'arc_show_meta', '=', '1' ),
                'title'    => __( 'Bật / Tắt chuyên mục', 'hrm' ),
                'default'  => true,
            ),
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Kiểu hiển thị lưu trữ', 'hrm' ),
        'id'         => 'archive-default-setting',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'archive-default-layout',
                'type'     => 'image_select',
                'title'    => __( 'Chọn kiểu hiển thị mặc định', 'hrm' ),
                'options'  => array(
                    'excerpt' => array(
                        'alt' => '1 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-1.png'
                    ),
                    'full_thumb' => array(
                        'alt' => '2 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-2.png'
                    ),
                    'content' => array(
                        'alt' => '3 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-3.png'
                    ),
                    'masonry' => array(
                        'alt' => '4 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-4.png'
                    ),
                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'category-default-layout',
                'type'     => 'image_select',
                'title'    => __( 'Chọn kiểu hiển thị chuyên mục', 'hrm' ),
                'options'  => array(
                    'excerpt' => array(
                        'alt' => '1 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-1.png'
                    ),
                    'full_thumb' => array(
                        'alt' => '2 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-2.png'
                    ),
                    'content' => array(
                        'alt' => '3 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-3.png'
                    ),
                    'masonry' => array(
                        'alt' => '4 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-4.png'
                    ),
                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'search-default-layout',
                'type'     => 'image_select',
                'title'    => __( 'Chọn kiểu hiển thị tìm kiếm', 'hrm' ),
                'options'  => array(
                    'excerpt' => array(
                        'alt' => '1 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-1.png'
                    ),
                    'full_thumb' => array(
                        'alt' => '2 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-2.png'
                    ),
                    'content' => array(
                        'alt' => '3 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-3.png'
                    ),
                    'masonry' => array(
                        'alt' => '4 Column',
                        'img' => THEME_URL . 'lib/admin/images/arc-4.png'
                    ),
                ),
                'default'  => '3'
            ),
        ),
    ) );
    // -> START Select Fields
    Redux::setSection( $opt_name, array(
        'title' => __( 'Cấu hình bài viết', 'hrm' ),
        'id'    => 'hrm-post-setting',
        'icon'  => 'el el-list-alt'
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Cấu hình bài viết', 'hrm' ),
        'id'         => 'post-setting',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'enabled-related',
                'type'     => 'switch',
                'title'    => __( 'Hiển thị bài viết liên quan', 'hrm' ),
                'default'  => true,
            ),
            array(
                'id'       => 'enabled-social-share',
                'type'     => 'switch',
                'title'    => __( 'Chia sẻ bài viết' ),
                'default'  => 0,
                'on'       => 'Enabled',
                'off'      => 'Disabled',
            ),
            array(
                'id'       => 'enabled-social-face',
                'type'     => 'switch',
                'title'    => __( 'Chia sẻ trên facebook' ),
                'required' => array( 'enabled-social-share', '=', '1' ),
                'default'  => false,
                'on'       => 'On',
                'off'      => 'Off',
            ),
            array(
                'id'       => 'enabled-social-google',
                'type'     => 'switch',
                'title'    => __( 'Chia sẻ trên google' ),
                'required' => array( 'enabled-social-share', '=', '1' ),
                'default'  => false,
                'on'       => 'On',
                'off'      => 'Off',
            ),
            array(
                'id'       => 'enabled-social-twitter',
                'type'     => 'switch',
                'title'    => __( 'Chia sẻ trên twitter' ),
                'required' => array( 'enabled-social-share', '=', '1' ),
                'default'  => false,
                'on'       => 'On',
                'off'      => 'Off',
            ),
            array(
                'id'       => 'enabled-social-linkedIn',
                'type'     => 'switch',
                'title'    => __( 'Chia sẻ trên linkedIn' ),
                'required' => array( 'enabled-social-share', '=', '1' ),
                'default'  => false,
                'on'       => 'On',
                'off'      => 'Off',
            ),
            array(
                'id'       => 'enabled-social-pinterest',
                'type'     => 'switch',
                'title'    => __( 'Chia sẻ trên pinterest' ),
                'required' => array( 'enabled-social-share', '=', '1' ),
                'default'  => false,
                'on'       => 'On',
                'off'      => 'Off',
            ),

        ),
    ) );

    /*----------------------------------------------------------------------*/
    /* Styling Section
    /*----------------------------------------------------------------------*/
    Redux::setSection( $opt_name, array(
        'title' => __('Styling', 'hrm'),
        'icon'      => 'el el-brush'
    ) );


     Redux::setSection( $opt_name, array(
        'title' => __('Header', 'hrm'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'        => 'header_background',
                'type'     => 'color_rgba',
                'mode'      => 'background-color',
                'output'    => array('.site-header'),
                'title'     => __('Màu mền đầu trang', 'hrm'),
                'default'  => array(
                    'color' => '#000000',
                    'alpha' => '.'
                    ),
            ),
            array(
                'id'        => 'menu_background',
                'type'      => 'color',
                'mode'      => 'background-color',
                'output'    => array('#main-menu'),
                'title'     => __('Màu nền menu', 'hrm'),
                'desc'     => 'default: #292A32',
                'default'   => '#292A32'
            ),
            array(
                'id'        => 'header_nav_text_color',
                'type'      => 'color',
                'transparent' => false,
                'output'    => array('ul#navigation li a'),
                'title'     => __('Màu sắc chữ menu', 'hrm'),
                'desc'  => 'default: #fff',
                'default'   => '#fff',
                'validate'  => 'color'
            ),
            array(
                'id'        => 'header_nav_hover_bg_color',
                'type'      => 'color',
                'mode'      => 'background-color',
                'output'    => array('ul#navigation li:hover, ul#navigation li:focus, ul#navigation li.current-menu-item'),
                'title'     => __('Màu nền khi hover menu', 'hrm'),
                'desc'  => 'default: #3A3B42',
                'default'   => '#3A3B42',
                'validate'  => 'color'
            ),
            array(
                'id'        => 'header_nav_hover_text_color',
                'type'      => 'color',
                'transparent' => false,
                'output'    => array('ul#navigation li:hover a, ul#navigation li:focus a, ul#navigation li.active a'),
                'title'     => __('Thay đổi màu sắc khi hover chữ trên menu', 'hrm'),
                'desc'  => 'default: #ffffff',
                'default'   => '#ffffff',
                'validate'  => 'color'
            ),
            array(
                'id'        => 'form_search_background',
                'type'     => 'background',
                'output'    => array('.advanced-search'),
                'title'     => __('Nền form search', 'hrm'),
            ),
        ),
    ) );


    // -> START Editors
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Cấu hình chân trang', 'hrm' ),
        'id'         => 'hrm-footer',
        'icon'  => 'el el-cog',
        'fields'     => array(
            array(
                'id'          => 'new-stay-we',
                'type'        => 'slides',
                'title'       => __( 'Báo chí nói về chúng tôi', 'hrm' ),
                'show' => array(
                    'title'       => true,
                    'description' => true,
                    'url'         => true,
                ),
                'placeholder' => array(
                    'title'       => __( 'Tên báo chí', 'hrm' ),
                    'description' => __( 'Tiêu đề báo chí nói', 'hrm' ),
                    'url'         => __( 'Đường dẫn báo chí nói', 'hrm' ),
                ),
            ),
            array(
                'id'       => 'show-menu',
                'type'     => 'switch',
                'title'    => 'Show menu sidebar',
                'subtitle' => 'Ẩn hoặc hiện',
                'default'  => true
            ),
            array(
                'id'       => 'show-footer-top',
                'type'     => 'switch',
                'title'    => 'Hiển thị chân trang top',
                'default'  => true
            ),
            array(
                'id'       => 'hrm-footer-layout',
                'type'     => 'image_select',
                'title'    => __( 'Kiểu hiển thị', 'hrm' ),
                'required' => array( 'show-footer-top', '=', true ),
                'options'  => array(
                    '1' => array(
                        'alt' => '1 Column',
                        'img' => THEME_URL . 'lib/admin/images/footer-1c.png'
                    ),
                    '2' => array(
                        'alt' => '2 Column',
                        'img' => THEME_URL . 'lib/admin/images/footer-2c.png'
                    ),
                    '3' => array(
                        'alt' => '3 Column',
                        'img' => THEME_URL . 'lib/admin/images/footer-3c.png'
                    ),
                    '4' => array(
                        'alt' => '4 Column',
                        'img' => THEME_URL . 'lib/admin/images/footer-4c.png'
                    ),
                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'back-to-top',
                'type'     => 'switch',
                'title'    => __( 'Về đầu trang', 'hrm' ),
                'subtitle' => __( 'Hiển thị hoặc tắt nút về đầu trang', 'hrm' ),
                'default'  => true,
            ),
        ),
    ) );


    /*----------------------------------------------------------------------*/
    /* Social Section
    /*----------------------------------------------------------------------*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Mạng xã hội', 'hrm' ),
        'id'               => 'hrm-settings-general-th',
        'icon'             => 'el el-cogs',
        'fields'           => array(
            array(
                'id'       => 'hrm_fb',
                'type'     => 'text',
                'title'    => __( 'Facebook', 'hrm' ),
                ),
            array(
                'id'       => 'hrm_gplus',
                'type'     => 'text',
                'title'    => __( 'Google+', 'hrm' ),
                ),
            array(
                'id'       => 'hrm_twitter',
                'type'     => 'text',
                'title'    => __( 'Twitter', 'hrm' ),
                ),
            array(
                'id'       => 'hrm_pinterest',
                'type'     => 'text',
                'title'    => __( 'Pinterest', 'hrm' ),
                ),
            array(
                'id'       => 'hrm_youtube',
                'type'     => 'text',
                'title'    => __( 'Youtube', 'hrm' ),
                ),
            ),
        ) );

    /*----------------------------------------------------------------------*/
    /* Social Section
    /*----------------------------------------------------------------------*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Trang quản trị', 'hrm' ),
        'id'               => 'hrm-settings-admin',
        'icon'             => 'el el-wrench',
        'fields'           => array(
            array(
                'id'       => 'hrm-logo-login',
                'type'     => 'media',
                'title'    => __( 'Logo trang quản trị', 'hrm' ),
                'desc'     => __( 'Thay đổi logo quản trị tại đây.', 'hrm' ),
                'default'  => array(
                    'url'  => THEME_URL . 'images/logo-admin.png'
                ),
            ),
             array(
                'id'       => 'hrm-bg-login',
                'type'     => 'media',
                'title'    => __( 'Background trang đăng nhập', 'hrm' ),
                'desc'     => __( 'Thay đổi Background đăng nhập ', 'hrm' ),
            ),
        ),
    ) );

    // -> START Editors
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Tùy chỉnh CSS', 'hrm' ),
        'id'               => 'hrm-custom-style',
        'customizer_width' => '500px',
        'icon'             => 'el el-edit',
        'fields'           => array(
            array(
                'id'        => 'quick_css',
                'type'      => 'ace_editor',
                'title'     => __('Thêm CSS', 'hrm'),
                'mode'      => 'css',
                'theme'     => 'monokai'
            )
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'icon'            => 'el el-list-alt',
        'title'           => __( 'Customizer Only', 'hrm' ),
        'desc'            => __( '<p class="description">This Section should be visible only in Customizer</p>', 'hrm' ),
        'customizer_only' => true,
        'fields'          => array(
            array(
                'id'              => 'opt-customizer-only',
                'type'            => 'select',
                'title'           => __( 'Customizer Only Option', 'hrm' ),
                'subtitle'        => __( 'The subtitle is NOT visible in customizer', 'hrm' ),
                'desc'            => __( 'The field desc is NOT visible in customizer.', 'hrm' ),
                'customizer_only' => true,
                //Must provide key => value pairs for select options
                'options'         => array(
                    '1' => 'Opt 1',
                    '2' => 'Opt 2',
                    '3' => 'Opt 3'
                ),
                'default'         => '2'
            ),
        )
    ) );
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'hrm' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'hrm' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

