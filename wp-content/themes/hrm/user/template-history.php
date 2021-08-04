<?php
/*
* Template Name: Lịch sử nạp
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
                  <h1><?php printf(__("Quản lý dữ liệu chính chủ", 'hrm')); ?></h1>
              </header>
              <table border="0" cellpadding="4" cellspacing="1" class="table-my-ads">
        					<thead>
        							<th>Mã giao dịch</th>
        							<th>Mã đơn hàng</th>
        							<th>Hình thức nạp</th>
											<th>Mệnh giá</th>
											<th>Thời gian nạp</th>
        					</thead>
        					<tbody>
        					<?php
		              		$ld_args = array(
													'post_type'      => 'lich-su-nap',
													'post_status' =>'publish',
							            'post_author' => $author_id,
											);
											$ld_abxf = new WP_Query ($ld_args);
											if($ld_abxf->have_posts()) { 
												 	while ( $ld_abxf->have_posts() ) { $ld_abxf->the_post(); ?>
		        							<tr>
		        									<td><?php echo get_the_ID(); ?></td>
		        									<td><?php echo get_post_meta( get_the_ID(), 'mdh', true ); ?></td>
		        									<td><?php echo get_post_meta( get_the_ID(), 'hinh-thuc-nap', true ); ?></td>
		        									<td><?php echo get_post_meta( get_the_ID(), 'menh-gia', true ); ?></td>
		        									<td><?php echo get_the_time('d/m/Y H:i:s'); ?></td>
		        							</tr><?php
		        							}
		        					}
        					?>
        					</tbody>
              </table>
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
