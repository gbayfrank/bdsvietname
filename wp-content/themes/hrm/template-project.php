<?php
/**
 * Template Name: Tìm kiếm dự án
 */
$cur_link = getCurrentPageURL();
$args = array(
    'post_type'      => 'project',
    'posts_per_page' => -1,
    'post_status' => 'publish',
);
if( isset($_GET['s']) && !empty($_GET['s']) )
{
    $search = $_GET['search'];
    $args['s'] = $search;
}
if( isset($_GET['project_cat']) && !empty($_GET['project_cat']) )
{
    $args['tax_query'][] = array(
        'taxonomy' => 'project_cat',
        'field'    => 'slug',
        'terms'    => $_GET['project_cat'],
    );
}
if( isset($_GET['quick-ward']) && !empty($_GET['quick-ward']) ) {
    $args['tax_query'][] = array(
        'relation' => 'AND',
        'taxonomy' => 'city-realty',
        'field'    => 'id',
        'terms'    => $_GET['quick-ward'],
    );
} else {
    if( isset($_GET['quick-district']) && !empty($_GET['quick-district']) ) {
        $args['tax_query'][] = array(
            'relation' => 'AND',
            'taxonomy' => 'city-realty',
            'field'    => 'id',
            'terms'    => $_GET['quick-district'],
        );
    } else {
        if( isset($_GET['quick-city']) && !empty($_GET['quick-city']) ) {
            $args['tax_query'][] = array(
                'relation' => 'AND',
                'taxonomy' => 'city-realty',
                'field'    => 'id',
                'terms'    => $_GET['quick-city'],
            );
        }
    }
}
// Show Query
$query = new WP_Query ( $args );
$display = 25;
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
get_header(); ?>
	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
			<div class="wrapper-realty">
				<header class="entry-header">
			        <div class="bor-bot">
			            <div class="title">
			                <h1 class="entry-title">
			                   Tìm kiếm dự án
			                </h1>
			                <span class="icon-house"></span>
			            </div>
			        </div>
			    </header><!-- .page-header -->
				<div class="quick-search">
			        <span class="right-result">
			            <?php 
			                printf( esc_html__( 'Có %s dự án tìm thấy.', 'hrm' ), '<span>' . $item_count . '</span>' );
			            ?>
			        </span>
			        <form method="post">
			            <select name="sort" id="sort" class="">   
			                <option <?php if(!isset($_GET['sort']) || $_GET['sort']=='') echo 'selected="selected"'; ?> value="df">Mặc định</option>
			                <option value="dd" <?php if($_GET['sort'] == 'dd') echo 'selected="selected"'; ?> >Mới nhất</option>
			                <option value="du" <?php if($_GET['sort'] == 'du') echo 'selected="selected"'; ?>>Cũ nhất</option>
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
			                                $sort = str_replace('&sort='.$sort_cu, '', $cur_link); ?>
			                                window.location.href = '<?php echo $sort ?>&sort='+sort;<?php
			                            } else { ?>
			                                window.location.href = '<?php echo $cur_link; ?>&sort='+sort;<?php
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
	                    
	                } else {
	                    /* The Query*/
	                    $loopargs = array(
	                        'post_status' => 'publish',
	                        'offset'         => $start,
	                        'posts_per_page' => $display,
				            'post_type' => 'project',
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
	                            default:
	                            # code...
	                            break;
	                        }
	                    }
	                    if( isset($_GET['s']) && !empty($_GET['s']) ){
	                        $loopargs['s'] = $search;
	                    }
	                    if( isset($_GET['quick-ward']) && !empty($_GET['quick-ward']) ) {
	                        $loopargs['tax_query'][] = array(
	                            'relation' => 'AND',
	                            'taxonomy' => 'city-realty',
	                            'field'    => 'id',
	                            'terms'    => $_GET['quick-ward'],
	                        );
	                    } else {
	                        if( isset($_GET['quick-district']) && !empty($_GET['quick-district']) ) {
	                            $loopargs['tax_query'][] = array(
	                                'relation' => 'AND',
	                                'taxonomy' => 'city-realty',
	                                'field'    => 'id',
	                                'terms'    => $_GET['quick-district'],
	                            );
	                        } else {
	                            if( isset($_GET['quick-city']) && !empty($_GET['quick-city']) ) {
	                                $loopargs['tax_query'][] = array(
	                                    'relation' => 'AND',
	                                    'taxonomy' => 'city-realty',
	                                    'field'    => 'id',
	                                    'terms'    => $_GET['quick-city'],
	                                );
	                            }
	                        }
	                    }
	                    if( isset($_GET['project_cat']) && !empty($_GET['project_cat']) )
						{
						    $loopargs['tax_query'][] = array(
						        'taxonomy' => 'project_cat',
						        'field'    => 'slug',
						        'terms'    => $_GET['project_cat'],
						    );
						}
						$tax_query=new WP_Query($loopargs);
						if ($tax_query->have_posts()) : ?>
					<ul>
						<?php while ( $tax_query -> have_posts()) : $tax_query -> the_post(); ?>
							<li>
							    <?php if (has_post_thumbnail()) : ?>
							        <a href="<?php the_permalink(); ?>">
							            <?php the_post_thumbnail('realty-thumbnail'); ?>
							        </a>
							    <?php else : ?>
							        <a href="<?php the_permalink(); ?>">
							            <img src="http://placehold.it/160x120">
							        </a>
							    <?php endif; ?>
							    <div class="info-realty info-project">
							    	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							    	<p><b>Địa chỉ: </b><?php echo rwmb_meta('address_project'); ?></p>
							    	<p><b>Điện thoại: </b><?php echo rwmb_meta('phone_project'); ?></p>
							    	<p><b>Loại hình: </b><?php the_terms( get_the_id(),'project_cat' ); ?></p>
							    </div>
							</li>
						<?php endwhile; ?>
					</ul><?php 
						else : ?>
							<?php _e( 'Hiện không có bài viết nào như bạn muốn tìm kiếm','hrm' ); ?>
						<?php endif; 
					}
				?>
				</div>
				
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
