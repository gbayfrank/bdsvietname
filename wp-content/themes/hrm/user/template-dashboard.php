<?php
/*
 * Template Name: Dashboard
*/
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();
if(!is_super_admin()) {
	wp_redirect( home_url('/login' ) );
}
// grabs the user info and puts into vars
$current_user = wp_get_current_user();
$display_user_name = $current_user->display_name;
if(!is_super_admin()) {
	wp_redirect( home_url('/tin-da-dang') );
}

get_header(); ?>
<div id="primary" class="dash col-sm-12">
	<main id="main" class="site-main" role="main">
		<header class="entry-header">
			<h2><?php printf(__("Bảng quản trị %s's", 'hrm'), $display_user_name); ?></h2>
		</header>
		<div <?php post_class(); ?>>
			<p><?php _e('Dưới đây bạn sẽ tìm thấy một danh sách của tất cả các bài đăng của bạn. Nhấp chuột vào một trong các tùy chọn để thực hiện một nhiệm vụ cụ thể. Nếu bạn có bất kỳ câu hỏi, xin vui lòng liên hệ với người quản trị trang web.','hrm');?></p>
			<div class="filter-current-view clearfix">
				<input type="text" id="filter-view" placeholder="Lọc trong trang hiện tại...">
				<script>
					jQuery(document).ready(function($){
						jQuery('input#filter-view').on('input',function() {
							str = $(this).val() ;
							if (str != '') {
								setTimeout(function(){
									$('#list-item-bds tbody tr').hide();
									$("#list-item-bds h3 a:contains('"+str+"')" ).closest('tr').show();
								}, 500);
							} else {
								$('#list-item-bds tbody tr').show();
							}

						});
					}); 

				</script>
			</div>
			<table id="list-item-bds" border="0" cellpadding="4" cellspacing="1" class="table-my-ads">
				<thead>
					<tr>
						<th class="text-center" colspan="2"><?php _e('Tiêu đề','hrm');?></th>
						<th width="80px"><?php _e('Lượt xem','hrm');?></th>
						<th width="100px"><?php _e('Thanh toán','hrm');?></th>
						<th width="120px"><?php _e('Trạng thái','hrm');?></th>
						<th width="90px"><div style="text-align: center;"><?php _e('Tùy chỉnh','hrm');?></div></th>
					</tr>
				</thead>
				<tbody>
					<?php
							// setup the pagination and query
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$wp_query = new WP_Query(
						array(
							'posts_per_page' => 100,
							'post_type' => 'realty',
							'post_status' => 'publish, pending, draft',
							'paged' => $paged
						)
					);
							// build the row counter depending on what page we're on
					if($paged == 1) $i = 0; else $i = $paged * 10 - 10;
					?>
					<?php if(have_posts()) : ?>
						<?php while(have_posts()) : the_post(); $i++; ?>
							<?php
		                            // it's a live and published ad
							if ($post->post_status == 'publish') {
								$poststatus = '<h4 class="ad-status">';
								$poststatus .= __('Đã phê','hrm');
								$poststatus .= ' ' . __('duyệt','hrm') . '<br/><p class="small">(' . get_the_date('Y-m-d H:i:s') . ')</p>';
								$poststatus .= '</h4>';
		                            // it's a pending ad which gives us several possibilities
							} elseif ($post->post_status == 'pending') {
								$poststatus = '<h4 class="ad-status">';
								$poststatus .= __('Chờ phê duyệt','hrm');
								$poststatus .= '</h4>';
							} elseif ($post->post_status == 'draft') {
								$poststatus = '<h4 class="ad-status">';
								$poststatus .= __('Bản nháp','hrm');
								$poststatus .= '</h4>';
							}
							?>
							<tr class="even">
								<td class="text-center">
									<?php the_post_thumbnail('thumbnail'); ?>
								</td>
								<td>
									<h3>
										<?php if ($post->post_status == 'pending' || $post->post_status == 'draft' || $poststatus == 'ended' || $poststatus == 'offline') { ?>
											<?php the_title(); ?>
										<?php } else { ?>
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										<?php } ?>
									</h3>
									<div class="meta">
										<span class="folder">
											<span class="folder"><?php echo get_the_term_list(get_the_id(),'realty-sell', '', ', ', ''); ?></span>
											| <span class="clock"><span><?php the_time(get_option('date_format'))?></span></span>
										</span>
									</div><!-- div.meta -->
								</td>
								<td class="text-center"><?php echo postview_get(get_the_ID()); ?></td>
								<td class="text-center">
									<?php 
									if(rwmb_meta('thanh-toan') == 0 ) {
										echo 'Chưa thanh toán';
									} else {
										echo 'Đã thanh toán';
									}
									?>
								</td>

								<td class="text-center"><?php echo ucfirst($poststatus) ?></td>
								<td class="text-center">
									<a href="<?php echo home_url( 'sua-tin' ); ?>?post=<?php the_id(); ?>">
										<img src="<?php echo THEME_URL .'/images/pencil.png' ;?>" title="" alt="" border="0" />
									</a>&nbsp;&nbsp;
									<a onclick="return confirm_before_delete();" href="<?php echo get_delete_post_link( get_the_ID() ); ?>" title="<?php _e('Delete Ad', 'hrm'); ?>">
										<img src="<?php echo THEME_URL .'/images/close.png' ;?>" title="<?php _e('Xóa', 'hrm'); ?>" alt="<?php _e('Xóa', 'hrm'); ?>" border="0" />
									</a>&nbsp;&nbsp;
									<?php if($post->post_status != 'publish') { ?>
										<a onclick="duyetbai(<?php echo get_the_ID(); ?>);" id="check-<?php echo get_the_ID(); ?>" data-admin = "<?php echo $display_user_name; ?>" data-link = "<?php echo $cur_link; ?>" href="javascript:;" class="confirm" title="<?php _e('Duyệt Bài', 'hrm'); ?>">
											<i class="fa fa-check" aria-hidden="true"></i>
										</a>
									<?php } ?>
								</td>
							</tr>
						<?php endwhile; ?>
						<script type="text/javascript">
							/* <![CDATA[ */
							function confirm_before_delete() { return confirm("<?php _e('Bạn muốn xóa bài đăng này?', 'hrm'); ?>"); }

							/* ]]> */
						</script>
						<?php else : ?>
							<tr class="even">
								<td colspan="5">
									<div class="pad10"></div>
									<p class="text-center"><?php _e('Hiện bạn không có bài đăng nào.','hrm');?></p>
									<div class="pad25"></div>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table><!-- table -->
				<?php
				echo '<div class="hrm-pagenavi">';
				hrm_pagination();
				echo '</div>';
				?>
			</div><!-- div.post-class -->
		</main><!-- #main -->
	</div><!-- #primary -->
	<style>
	.paper {
		background-color: #eff0f5;
	}
</style>
<?php
get_footer();
