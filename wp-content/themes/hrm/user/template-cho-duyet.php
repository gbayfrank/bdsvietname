<?php
/*
 * Template Name: Chờ duyệt
 * 
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
                  <h1><?php printf(__("Quản lý tin", 'hrm')); ?></h1>
                </header>
                <table border="0" cellpadding="4" cellspacing="1" class="table-my-ads">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="2"><?php _e('Tiêu đề','hrm');?></th>
                            <th width="80px"><?php _e('Lượt xem','hrm');?></th>
                            <th width="100px"><?php _e('Thanh toán','hrm');?></th>
                            <th width="90px"><div style="text-align: center;"><?php _e('Tùy chỉnh','hrm');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                       // Trước khi Quang-antopho sửa 'post_status' => array('pending','draft'),
						$args = array(
                            'posts_per_page' => -1,
                            'post_type' => 'realty',
                            'post_status' => array('pending','draft'),
                            'author' => $author_id
                        );
                        $query = new WP_Query ( $args );
                        /*Xác định số lượng hiển thị trong 1 trang.*/
                        $display = get_option('posts_per_page');
                        $page = 1;
                        /* Tính tổng số trang cần hiển thị.*/
                        if ( isset( $_GET[ 'page' ] ) && (int)$_GET[ 'page' ] ) {
                            $page = $_GET[ 'page' ];
                        } else { /* Nếu chưa xác định thì tìm số trang.*/
                            $item_count = $query->found_posts;
                            if ( $item_count > $display ) {
                                $page = ceil( $item_count / $display ); /* Số trang hiển thị.*/
                            } else {
                                $page = 1;
                            }
                        }
                        $start = ( isset( $_GET[ 'start' ] ) && (int)$_GET[ 'start' ] ) ? $_GET[ 'start' ] : 0;
                        if ( $start < 0 || $start >= $item_count ) {
                          /* nothing to do here*/
                        } else {
                            /* The Query*/
							//Trước khi Quang-antopho sửa  'post_status' => array('pending','draft'),
                            $loopargs = array(
                                'post_type' => 'realty',
                               'post_status' => array('pending','draft'),
                                'author' => $author_id,
                                'offset'         => $start,
                                'posts_per_page' => $display,
                            );
                            $the_query = new WP_Query( $loopargs );
                            if ( $the_query->have_posts() ) {  
                                while ( $the_query->have_posts() ) { $the_query->the_post();  ?>
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
                                              echo 'Chưa <a href="'.home_url('thanh-toan?post_id=').get_the_ID().'">thanh toán</a>';
                                            } else {
                                              echo 'Đã thanh toán';
                                            }
                                          ?>
                                        </td>
                                        
                                        <td class="text-center">
                                          <a href="<?php echo home_url( 'sua-tin' ); ?>?post=<?php the_id(); ?>">
                                            <img src="<?php echo THEME_URL .'/images/pencil.png' ;?>" title="" alt="" border="0" />
                                          </a>  
                                          <a onclick="return confirm_before_delete();" href="<?php echo get_delete_post_link( get_the_ID() ); ?>" title="<?php _e('Delete Ad', 'hrm'); ?>">
                                            <img src="<?php echo THEME_URL .'/images/close.png' ;?>" title="<?php _e('Xóa', 'hrm'); ?>" alt="<?php _e('Xóa', 'hrm'); ?>" border="0" />
                                         </a>  
                                        </td>
                                    </tr>
                                <?php
                              }
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        }
                    ?>
                    </tbody>
                </table><!-- table -->
                <div class="panigation-page clearclearfix col-xs-12">
                  <ul class="page-numbers pagination">
                    <?php
                    /* Tính tổng số trang cần hiển thị.*/
                    if ( isset( $_GET[ 'page' ] ) && (int)$_GET[ 'page' ] ) {
                      $page = $_GET[ 'page' ];
                    } else { /* Nếu chưa xác định thì tìm số trang.*/
                      $item_count = $query->found_posts;

                      if ( $item_count > $display ) {
                        $page = ceil( $item_count / $display ); /* Số trang hiển thị.*/
                      } else {
                        $page = 1;
                      }
                    }
                    if ( $page > 1 ) { /* Nếu số trang lớn hơn 1 mới hiển thị số trang.*/
                      $next = $start + $display;
                      $prev = $start - $display;
                      $current = ( $start / $display ) + 1;

                      /* Hiển thị trang previous.*/
                      if ( $current != 1 ) {
                        echo '<li><a class="pagebutton" href="?start=' . $prev . '">« Lùi</a></li>';
                      }

                      for ( $i = 1 ; $i <= $page ; $i++ ) {
                        if ( $current == $i )
                          echo '<li><a class="pagebutton current" href="?start=' . $display * ( $i - 1 ) . '">' . $i . '</a></li>';
                        else
                          echo '<li><a class="pagebutton" href="?start=' . $display * ( $i - 1 ) . '">' . $i . '</a></li>';
                      }

                      /* Hiển thị trang next.*/
                      if ( $current != $page ) {
                        echo '<li><a class="pagebutton" href="?start=' . $next . '">Tiến »</a></li>';
                      }
                    }
                    ?>
                  </ul>
                </div><!--end .panigation-page-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function confirm_before_delete() { return confirm("<?php _e('Bạn muốn xóa bài đăng này?', 'hrm'); ?>"); }
</script>
<style>
    .paper {
      background-color: #eff0f5;
    }
  </style>
<?php
get_footer();