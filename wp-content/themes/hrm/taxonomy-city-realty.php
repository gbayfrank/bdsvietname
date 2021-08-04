<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hrm
 * 
 */
$cur_link = getCurrentPageURL();
$term_current = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
get_header(); ?>
	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
			<?php if ( have_posts() ) : ?>
			<div class="wrapper-realty">
				<header class="entry-header">
			        <div class="bor-bot">
			            <div class="title">
			                <h1 class="entry-title">
			                   <?php
									printf('Bất động sản khu vực: %1s', get_the_archive_title());
								?>
			                </h1>
			                <span class="icon-house"></span>
			            </div>
			        </div>
			    </header><!-- .page-header -->
				<?php
					$args=array(
			            'posts_per_page'=> -1,
			            'post_status' => 'publish',
			            'post_type' => 'realty',
			            'tax_query' => array(
		            	'relation' => 'AND',
							array(
								'taxonomy' => 'city-realty',
						        'field' => 'term_id',
						        'terms' => $term_current->term_id,
						   )
						)
			        );
			        $query = new WP_Query ( $args );
				    $display = 3;
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
				?>
				<div class="quick-search">
			        <span class="right-result">
			            <?php 
			                printf( esc_html__( 'Có %s bất động sản được tìm thấy.', 'hrm' ), '<span>' . $item_count . '</span>' );
			            ?>
			        </span>
			        <form method="post">
			            <select name="sort" id="sort" class="">   
			                <option <?php if(!isset($_GET['sort']) || $_GET['sort']=='') echo 'selected="selected"'; ?> value="df">Mặc định</option>
			                <option value="dd" <?php if($_GET['sort'] == 'dd') echo 'selected="selected"'; ?> >Mới nhất</option>
			                <option value="du" <?php if($_GET['sort'] == 'du') echo 'selected="selected"'; ?>>Cũ nhất</option>
			                <option value="pd" <?php if($_GET['sort'] == 'pd') echo 'selected="selected"'; ?>>Giá cao nhất</option>
			                <option value="pu" <?php if($_GET['sort'] == 'pu') echo 'selected="selected"'; ?>>Giá thấp nhất</option>
			            </select>
			        </form>   
			        <script>
			            jQuery( document ).ready( function ( $ ){
			                jQuery("document").ready(function() {  
			                    $('#sort').on('change', function() {
			                        sort = $('#sort').val();
			                        <?php 
			                            if(isset($_GET['sort'])) {
			                                $sort_cu = $_GET['sort'];
			                                $sort_moi = $_POST['sort'];
			                                $sort = str_replace('&sort='.$sort_cu, '', $cur_link);
			                                 ?>
			                                window.location.href = '<?php echo $sort ?>&sort='+sort;<?php
			                            } else { 
			                            	if(isset($_GET['start'])) { ?>
							    				window.location.href = '<?php echo $cur_link; ?>&sort='+sort;<?php
							    			} else { ?>
							    				window.location.href = '<?php echo $cur_link; ?>?sort='+sort;<?php
							    			}
			                            }
			                        ?>
			                        
			                    });
			                });
			            });
			        </script>      
			    </div><!-- .quick-search -->
				<div class="list-realty">
				<?php
					if ( $start < 0 || $start >= $item_count ) {
	                    _e('Không có bài viết nào được tìm thấy','hrm');
	                } else {
	                    /* The Query*/
	                    $loopargs = array(
	                        'post_status' => 'publish',
	                        'offset'         => $start,
	                        'posts_per_page' => $display,
				            'post_type' => 'realty',
				            'tax_query' => array(
			            		'relation' => 'AND',
								array(
									'taxonomy' => 'city-realty',
							        'field' => 'term_id',
							        'terms' => $term_current->term_id,
							   )
							)
	                    );
					    if (isset($_GET['sort'])) {
	                        switch ($_GET['sort']) {
	                            case 'dd':
	                                $array_moi = array(
	                                    'orderby' => 'date',
	                                    'order' => 'DESC'
	                                );
	                                $loopargs = array_replace($loopargs, $array_moi);
	                                break;
	                            case 'du':
	                                $array_moi = array(
	                                    'orderby' => 'date',
	                                    'order' => 'ASC'
	                                );
	                                $loopargs = array_replace($loopargs, $array_moi);
	                                break;
	                            case 'pd':
	                                $array_moi = array(
	                                    'orderby' => 'meta_value_num',
	                                    'meta_key' => 'price-realty',
	                                    'order' => 'DESC'
	                                );
	                                $loopargs = array_replace($loopargs, $array_moi);
	                                break;
	                            case 'pu':
	                                $array_moi = array(
	                                    'orderby' => 'meta_value_num',
	                                    'meta_key' => 'price-realty',
	                                    'order' => 'ASC'
	                                );
	                                $loopargs = array_replace($loopargs, $array_moi);
	                                break;
	                            default:
	                            # code...
	                            break;
	                        }
	                    }
						$tax_query=new WP_Query($loopargs);
						if ($tax_query->have_posts()) : ?>
					<ul>
						<?php while ( $tax_query -> have_posts() ) : $tax_query -> the_post(); ?>
							<?php get_template_part( 'template-parts/content-archive', 'realty' );	?>
						<?php endwhile; ?>
					</ul><?php else : ?>
							<?php _e( 'Hiện không có bài viết nào như bạn muốn tìm kiếm','hrm' ); ?>
						<?php endif; 
					}
				?>
				</div>
			</div>
			<div class="panigation-page clearclearfix col-xs-12">
		        <ul class="page-numbers pagination">
		            <?php
		            /* Tính tổng số trang cần hiển thị.*/
		            if ( isset( $_GET[ 'page' ] ) && (int)$_GET[ 'page' ] ) {
		                $page = $_GET[ 'page' ];
		            } else { /* Nếu chưa xác định thì tìm số trang.*/
		                $item_count = $tax_query->found_posts;

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
		                if(!isset($_GET['start'])) {
		                	if(isset($_GET['sort'])) {
			                	$pavi = $cur_link.'&start=';
			                } else {
			                	$pavi = $cur_link.'?start=';
			                }
		                    if ( $current != 1 ) {
		                        echo '<li><a class="pagebutton" href="'.$pavi.$prev . '">« Lùi</a></li>';
		                    }

		                    for ( $i = 1 ; $i <= $page ; $i++ ) {
		                        if ( $current == $i )
		                            echo '<li><a class="pagebutton current" href="'.$pavi.$display * ( $i - 1 ) . '">' . $i . '</a></li>';
		                        else
		                            echo '<li><a class="pagebutton" href="'.$pavi.$display * ( $i - 1 ) . '">' . $i . '</a></li>';
		                    }

		                    /* Hiển thị trang next.*/
		                    if ( $current != $page ) {
		                        echo '<li><a class="pagebutton" href="'.$pavi.$next . '">Tiến »</a></li>';
		                    }
		                } else {
		                    $start_cu = $_GET['start'];
		                    if ( $current != 1 ) {
		                        
		                        $prev_new = str_replace('start='.$start_cu, 'start='.$prev, $cur_link);
		                        echo '<li><a class="pagebutton" href="'.$prev_new. '">« Lùi</a></li>';
		                    }
		                    for ( $i = 1 ; $i <= $page ; $i++ ) {
		                        $dis_moi = $display * ( $i - 1 );
		                        $dis_new = str_replace('start='.$start_cu, 'start='.$dis_moi, $cur_link);
		                        if ( $current == $i )
		                            echo '<li><a class="pagebutton current" href="'.$dis_new. '">' . $i . '</a></li>';
		                        else
		                            echo '<li><a class="pagebutton" href="'.$dis_new. '">' . $i . '</a></li>';
		                    }
		                    if ( $current != $page ) {
		                        $next_new = str_replace('start='.$start_cu, 'start='.$next, $cur_link);
		                        echo '<li><a class="pagebutton" href="'.$next_new. '">Tiến »</a></li>';
		                    }
		                }
		            }
		            ?>
		        </ul>
		    </div><!--end .panigation-page-->
			<?php
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
