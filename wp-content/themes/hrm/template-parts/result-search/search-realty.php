<?php
$cur_link = getCurrentPageURL();
$args = array(
    'post_type'           => 'realty',
    'posts_per_page'      => -1,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true, 
);

if( isset($_GET['key']) && !empty($_GET['key']) )
{
    $search = $_GET['key'];
    $args['s'] = $search;
}
if( isset($_GET['cate-realty']) && !empty($_GET['cate-realty'])) {
    $dm_goc = $_GET['cate-realty'];
    $loaic = substr($dm_goc, 0, 1);
    $id_dm = filter_var($dm_goc, FILTER_SANITIZE_NUMBER_INT);
    switch ($loaic) {
        case 'b':
        $args['tax_query'][] = array(
            'taxonomy' => 'realty-sell',
            'field'    => 'id',
            'terms'    => $id_dm,
        );
        break;
        case 't':
        $args['tax_query'][] = array(
            'taxonomy' => 'realty-rent',
            'field'    => 'id',
            'terms'    => $id_dm,
        );
        break;
        case 's':
        $args['tax_query'][] = array(
            'taxonomy' => 'realty-transfer',
            'field'    => 'id',
            'terms'    => $id_dm,
        );
        break;
    }         
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
if( isset( $_GET['ten-duong'] ) && !empty($_GET['ten-duong']) ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'street_ko_dau',
        'value'   => stripUnicode($_GET['ten-duong']),
        'compare' => 'LIKE',
    );

}
if( isset( $_GET['price'] ) && !empty($_GET['price']) ) {
    $args['tax_query'][] = array(
        'relation' => 'AND',
        'taxonomy' => 'khoang-gia',
        'field'    => 'slug',
        'terms'    => $_GET['price'],
    );
}
if( !empty($_GET['width'])  ) {
    $min_width = (int)$_GET['width'] - 2;
    $max_width = (int)$_GET['width'] + 2;

    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'width',
        'value'   => array($min_width, $max_width),
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC',
    );
}
if( !empty($_GET['long'])  ) {
    $min_long = (int)$_GET['long'] - 2;
    $max_long = (int)$_GET['long'] + 2;

    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'long',
        'value'   => array($min_long, $max_long),
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC',
    );
}

if( !empty($_GET['area'])  ) {
    $areas = array_map('intval', explode('-', $_GET['area']));
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'area-realty',
        'value'   => $areas,
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC',
    );
}
if( !empty($_GET['sizeuse']) && empty($_GET['area'])  ) {
    $areas = array_map('intval', explode('-', $_GET['area']));
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'sizeuse',
        'value'   => $areas,
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC',
    );
}

if( $_GET['floor'] ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'floor',
        'value'   => $_GET['floor'],
        'compare' => '=',
    );
}
if( $_GET['bedroom'] ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'realty-bedroom',
        'value'   => $_GET['bedroom'],
        'compare' => '=',
    );
}
if(isset($_GET['income']) ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'income',
        'value'   => array(''),
        'compare' => 'NOT IN'
    );
}
if( $_GET['interior'] ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'interior',
        'value'   => 1,
        'compare' => '=',
    );
}
if( $_GET['elevator'] ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'elevator',
        'value'   => 1,
        'compare' => '=',
    );
}
if( $_GET['hemoto'] ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'hemoto',
        'value'   => 1,
        'compare' => '=',
    );
}
if( $_GET['strtwidth'] ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'strtwidth',
        'value'   => (int)$_GET['strtwidth'],
        'compare' => '=',
    );
}
if( isset( $_GET['stair'] ) && !empty($_GET['stair']) ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'stair',
        'value'   => $_GET['stair'],
        'compare' => 'LIKE',
    );

}
if( isset($_GET['quarter']) && !empty($_GET['quarter']) ){
    $args['tax_query'][] = array(
        'taxonomy' => 'quarter',
        'field'    => 'slug',
        'terms'    => $_GET['quarter'],
    );
}

$query = new WP_Query ( $args );
$display = 25;
$page = 1;
/* T??nh t???ng s??? trang c???n hi???n th???.*/
if ( isset( $_GET[ 'page' ] ) && (int)$_GET[ 'page' ] ) {
    $page = $_GET[ 'page' ];
} else { /* N???u ch??a x??c ?????nh th?? t??m s??? trang.*/
    $item_count = $query->found_posts;
    if ( $item_count > $display ) {
        $page = ceil( $item_count / $display ); /* S??? trang hi???n th???.*/
    } else {
        $page = 1;
    }
}
$start = ( isset( $_GET[ 'start' ] ) && (int)$_GET[ 'start' ] ) ? $_GET[ 'start' ] : 0;
?>
<div class="wrapper-realty">
    <header class="entry-header clearfix">
        <div class="bor-bot">
            <div class="title">
                <h1 class="entry-title">T??m ki???m b???t ?????ng s???n</h1>
                <span class="icon-house"></span>
            </div>
        </div>
    </header><!-- .page-header -->
    <div class="title-search clearfix clear">
        B???n ??ang t??m B??S 
        <?php 
        if ($_GET['key']) {
            echo $_GET['key'];
        }
        if ($_GET['price']) {
            $price = get_term_by( 'slug', $_GET['price'], 'khoang-gia' );
            echo ', gi?? kho???ng ' . $price->name .' ';
        }
        if ($_GET['ten-duong'] || $_GET['quick-city'] || $_GET['quick-district']) {
            $term_ward     =  get_term( (int)$_GET['quick-ward'], 'city-realty' );
            $term_city     = get_term( (int)$_GET['quick-city'], 'city-realty' );
            $term_district = get_term( (int)$_GET['quick-district'], 'city-realty' );
            $duong         = '';
            if ($_GET['ten-duong']) {
                $duong = '???????ng ' . $_GET['ten-duong'] .' - ';
            }
            echo ', ??? '.  $duong . ' - ' . $term_ward->name . ' - ' . $term_district->name . ' - ' . $term_city->name .' ';
        }
        if ($_GET['width']&&$_GET['long']) {
            echo ', k??ch th?????c kho???ng '.  $_GET['width'] . 'm x ' . $_GET['long'] . 'm';
        }
        if ($_GET['area']) {
            echo ', di???n t??ch c??ng nh???n '.  $_GET['area'] . '<sup>2</sup> ' ;
        }
        if ($_GET['sizeuse']&&empty($_GET['area'])) {
            echo ', di???n t??ch s??? d???ng '.  $_GET['sizeuse'] . '<sup>2</sup> ' ;
        }
        if ($_GET['floor']) {
            echo ', '.  $_GET['floor'] . ' t???ng' ;
        }
        if ($_GET['bedroom']) {
            echo ', '.  $_GET['bedroom'] . '+ ph??ng' ;
        }
        if ($_GET['income']) {
            echo ', ??ang c?? thu nh???p t??? BDS' ;
        }
        if ($_GET['interior']) {
            echo ', c?? s???n n???i th???t' ;
        }
        if ($_GET['elevator']) {
            echo ', c?? thang m??y' ;
        }  
        if ($_GET['hemoto']) {
            echo ', c?? h???m ?? t??' ;
        }
        if ($_GET['strtwidth']) {
            echo ', ???????ng/h???m r???ng'.  $_GET['strtwidth'] . '+ m??t' ;
        }
        if ($_GET['stair']) {
            echo ', c???u thang '.  $_GET['stair'] . ' nh??' ;
        }
        if ($_GET['quarter']) {
            $quarter = get_term_by( 'slug', $_GET['quarter'], 'quarter' );
            echo ', h?????ng nh?? ' . $quarter->name .' ';
        }
        ?>
    </div>
    <div class="quick-search">
        <span class="right-result">
            <?php 
            printf( esc_html__( 'C?? %s b???t ?????ng s???n ???????c t??m th???y.', 'hrm' ), '<span>' . $item_count . '</span>' );
            ?>
        </span>
        <form method="post">
            <select name="sort" id="sort" class="">   
                <option <?php if(!isset($_GET['sort']) || $_GET['sort']=='') echo 'selected="selected"'; ?> value="df">M???c ?????nh</option>
                <option value="dd" <?php if($_GET['sort'] == 'dd') echo 'selected="selected"'; ?> >M???i nh???t</option>
                <option value="du" <?php if($_GET['sort'] == 'du') echo 'selected="selected"'; ?>>C?? nh???t</option>
                <option value="pd" <?php if($_GET['sort'] == 'pd') echo 'selected="selected"'; ?>>Gi?? cao nh???t</option>
                <option value="pu" <?php if($_GET['sort'] == 'pu') echo 'selected="selected"'; ?>>Gi?? th???p nh???t</option>
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
    <div class="list-realty list-result-search-realty">
        <ul>
            <?php
            if ( $start < 0 || $start >= $item_count ) {
                _e('Kh??ng c?? b??i vi???t n??o ???????c t??m th???y','hrm');
            } else {
                /* The Query*/
                $loopargs = array(
                    'post_type'      => 'realty',
                    'post_status'    => 'publish',
                    'offset'         => $start,
                    'posts_per_page' => $display,
                );

                if( isset($_GET['key']) && !empty($_GET['key']) )
                {
                    $search = $_GET['key'];
                    $loopargs['s'] = $search;
                }
                if( isset($_GET['cate-realty']) && !empty($_GET['cate-realty'])) {
                    $dm_goc = $_GET['cate-realty'];
                    $loaic = substr($dm_goc, 0, 1);
                    $id_dm = filter_var($dm_goc, FILTER_SANITIZE_NUMBER_INT);
                    switch ($loaic) {
                        case 'b':
                        $loopargs['tax_query'][] = array(
                            'taxonomy' => 'realty-sell',
                            'field'    => 'id',
                            'terms'    => $id_dm,
                        );
                        break;
                        case 't':
                        $loopargs['tax_query'][] = array(
                            'taxonomy' => 'realty-rent',
                            'field'    => 'id',
                            'terms'    => $id_dm,
                        );
                        break;
                        case 's':
                        $loopargs['tax_query'][] = array(
                            'taxonomy' => 'realty-transfer',
                            'field'    => 'id',
                            'terms'    => $id_dm,
                        );
                        break;
                    }         
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
                if( isset( $_GET['ten-duong'] ) && !empty($_GET['ten-duong']) ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'street_ko_dau',
                        'value'   => stripUnicode($_GET['ten-duong']),
                        'compare' => 'LIKE',
                    );

                }
                if( isset( $_GET['price'] ) && !empty($_GET['price']) ) {
                    $loopargs['tax_query'][] = array(
                        'relation' => 'AND',
                        'taxonomy' => 'khoang-gia',
                        'field'    => 'slug',
                        'terms'    => $_GET['price'],
                    );
                }
                if( !empty($_GET['width'])  ) {
                    $min_width = (int)$_GET['width'] - 2;
                    $max_width = (int)$_GET['width'] + 2;

                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'width',
                        'value'   => array($min_width, $max_width),
                        'compare' => 'BETWEEN',
                        'type'    => 'NUMERIC',
                    );
                }
                if( !empty($_GET['long'])  ) {
                    $min_long = (int)$_GET['long'] - 2;
                    $max_long = (int)$_GET['long'] + 2;

                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'long',
                        'value'   => array($min_long, $max_long),
                        'compare' => 'BETWEEN',
                        'type'    => 'NUMERIC',
                    );
                }

                if( !empty($_GET['area'])  ) {
                    $areas = array_map('intval', explode('-', $_GET['area']));
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'area-realty',
                        'value'   => $areas,
                        'compare' => 'BETWEEN',
                        'type'    => 'NUMERIC',
                    );
                }
                if( !empty($_GET['sizeuse']) && empty($_GET['area'])  ) {
                    $areas = array_map('intval', explode('-', $_GET['area']));
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'sizeuse',
                        'value'   => $areas,
                        'compare' => 'BETWEEN',
                        'type'    => 'NUMERIC',
                    );
                }

                if( $_GET['floor'] ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'floor',
                        'value'   => $_GET['floor'],
                        'compare' => '=',
                    );
                }
                if( $_GET['bedroom'] ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'realty-bedroom',
                        'value'   => $_GET['bedroom'],
                        'compare' => '=',
                    );
                }
                if( $_GET['income'] ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'income',
                        'value'   => array(''),
                        'compare' => 'NOT IN'
                    );
                }
                if( $_GET['interior'] ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'interior',
                        'value'   => 1,
                        'compare' => '=',
                    );
                }
                if( $_GET['elevator'] ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'elevator',
                        'value'   => 1,
                        'compare' => '=',
                    );
                }
                if( $_GET['hemoto'] ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'hemoto',
                        'value'   => 1,
                        'compare' => '=',
                    );
                }
                if( $_GET['strtwidth'] ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'strtwidth',
                        'value'   => (int)$_GET['strtwidth'],
                        'compare' => '>=',
                    );
                }
                if( isset( $_GET['stair'] ) && !empty($_GET['stair']) ) {
                    $loopargs['meta_query']['relation'] = 'AND';
                    $loopargs['meta_query'][] = array(
                        'key'     => 'stair',
                        'value'   => $_GET['stair'],
                        'compare' => 'LIKE',
                    );

                }
                if( isset($_GET['quarter']) && !empty($_GET['quarter']) ){
                    $loopargs['tax_query'][] = array(
                        'taxonomy' => 'quarter',
                        'field'    => 'slug',
                        'terms'    => $_GET['quarter'],
                    );
                }

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
                        break;
                    }
                }

                $the_query = new WP_Query( $loopargs );
                $i = 0;
                /* The Loop*/
                if ( $the_query->have_posts() ) {  
                    while ( $the_query->have_posts() ) { $the_query->the_post(); 
                        get_template_part( 'template-parts/content-archive', 'realty' );
                    }
                }
                wp_reset_postdata();
                wp_reset_query();
            }
            ?>          
        </ul>

    </div>
    <div class="panigation-page clearclearfix col-xs-12">
        <ul class="page-numbers pagination">
            <?php
            /* T??nh t???ng s??? trang c???n hi???n th???.*/
            if ( isset( $_GET[ 'page' ] ) && (int)$_GET[ 'page' ] ) {
                $page = $_GET[ 'page' ];
            } else { /* N???u ch??a x??c ?????nh th?? t??m s??? trang.*/
                $item_count = $query->found_posts;

                if ( $item_count > $display ) {
                    $page = ceil( $item_count / $display ); /* S??? trang hi???n th???.*/
                } else {
                    $page = 1;
                }
            }
            if ( $page > 1 ) { /* N???u s??? trang l???n h??n 1 m???i hi???n th??? s??? trang.*/
                $next = $start + $display;
                $prev = $start - $display;
                $current = ( $start / $display ) + 1;
                $pavi = $cur_link.'&start=';
                /* Hi???n th??? trang previous.*/
                if(!isset($_GET['start'])) {
                    if ( $current != 1 ) {
                        echo '<li><a class="pagebutton" href="'.$pavi.$prev . '">?? L??i</a></li>';
                    }

                    for ( $i = 1 ; $i <= $page ; $i++ ) {
                        if ( $current == $i )
                            echo '<li><a class="pagebutton current" href="'.$pavi.$display * ( $i - 1 ) . '">' . $i . '</a></li>';
                        else
                            echo '<li><a class="pagebutton" href="'.$pavi.$display * ( $i - 1 ) . '">' . $i . '</a></li>';
                    }

                    /* Hi???n th??? trang next.*/
                    if ( $current != $page ) {
                        echo '<li><a class="pagebutton" href="'.$pavi.$next . '">Ti???n ??</a></li>';
                    }
                } else {
                    $start_cu = $_GET['start'];
                    if ( $current != 1 ) {

                        $prev_new = str_replace('start='.$start_cu, 'start='.$prev, $cur_link);
                        echo '<li><a class="pagebutton" href="'.$prev_new. '">?? L??i</a></li>';
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
                        echo '<li><a class="pagebutton" href="'.$next_new. '">Ti???n ??</a></li>';
                    }
                }
            }
            ?>
        </ul>
    </div><!--end .panigation-page-->
</div>