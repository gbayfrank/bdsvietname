<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define( 'DB_NAME', 'bdsanviet' );
/** Username của database */
define( 'DB_USER', 'root' );
/** Mật khẩu của database */
define( 'DB_PASSWORD', '' );
/** Hostname của database */
define( 'DB_HOST', 'localhost' );
/** Database charset sử dụng để tạo bảng database. */
define( 'DB_CHARSET', 'utf8mb4' );
/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');
/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'q<* A4Yg:>m$;q_HWo(t-rKEgk;!S7Me37Jw@N#LY%<Fs/ZQj`*$-Ly}5QtrE8U(' );
define( 'SECURE_AUTH_KEY',  'wig1&[9{}NgCa X*[eM/CN^Va!T/Lq)&J=].>uQG,m/yg;XvaZ;zpf!t2258a:y*' );
define( 'LOGGED_IN_KEY',    '|!vv0bdvgIwiNo[G1]+?D}[574+Q)xS:}=>XNI%_%`wv}&a8L(k}6Bb:Kj3:AR9y' );
define( 'NONCE_KEY',        'QzLPd{@[0T} E+>YA_b@v&dVDte~kJ,4cj{52/G1ERWKNPb.P#[sE6NMV!%.s=3B' );
define( 'AUTH_SALT',        'f?|N4J{}L&Um]o7M%|tOsgAX)8;WGr-`=tP~`;D6pFVZ$YOdS{kq1:#w?F7Sjugn' );
define( 'SECURE_AUTH_SALT', 'yEiLCWj~PFUSJwp3Z!W<PTM)L`w?}Cg1kM[t(*a_0[#c` h0F s>FV^Rh,2G,rk<' );
define( 'LOGGED_IN_SALT',   '5Z5WG+8lb||Yl *i#F8uyK0Lb)DYLJjXr>Dp6!;QW=sRl8x!?i^R>k!O+4e2N5s8' );
define( 'NONCE_SALT',       'y16C%v(%8XXneCy]/~IBzh,Ys@_X]k.HTe MRHCVPCqv9XJ*V`901c]$$m8B9P!V' );
/**#@-*/
/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix = 'wp_';
/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */
/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
