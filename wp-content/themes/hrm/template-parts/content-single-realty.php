<?php
global $hrm_options;
$share_social = $hrm_options['enabled-social-share'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
   if ( is_single() ) {
    the_title( '<h1 class="entry-title">', '</h1>' );
  } else {
    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
  }
  ?>
</header><!-- .entry-header -->
<div class="slide-map clearfix clear">
  <?php
  $size = 'vertical-slider';
  $images = rwmb_meta('gallery','type=image_advanced&size='.$size, $post->ID);
  $maps = rwmb_meta('location');
  if( $images || $maps ) {  ?>
   <div class="realty-tabs">
     <!-- Nav tabs -->
     <ul class="nav nav-tabs" role="tablist">
      <?php if ($images) : ?>
        <li role="presentation" class="active">
          <a href="#images" aria-controls="images" role="tab" data-toggle="tab">
            <i class="fa fa-picture-o"></i><?php _e( 'Hình ảnh' , 'hrm' ); ?>
          </a>
        </li>
      <?php endif; ?>
      <?php if ($maps) : ?>
        <li role="presentation">
          <a href="#maps" aria-controls="maps" role="tab" data-toggle="tab">
            <i class="fa fa-map-marker"></i><?php _e( 'Bản đồ' , 'hrm' ); ?>
          </a>
        </li>
      <?php endif; ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <?php if ($images) { ?>
        <div role="tabpanel" class="tab-pane active" id="images">
          <div class="image-realty">
            <div id="sync1" class="owl-carousel">
              <?php foreach ($images as $img) : ?>
                <div class="item">
                  <li data-thumb="<?php echo $img['full_url']; ?>">
                    <a class="fancybox" href="<?php echo $img['full_url']; ?>" data-fancybox="gallery">
                      <img src="<?php echo $img['full_url']; ?>">
                    </a>
                  </li>
                </div>
              <?php endforeach; ?>
            </div>
            <div class="row">
              <div id="sync2" class="owl-carousel">
                <?php foreach ($images as $img) : ?>
                  <div class="item">
                    <img src="<?php echo $img['url']; ?>">
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if ($maps) { ?>
        <div role="tabpanel" class="tab-pane active" id="maps">
          <?php 
          $args = array(
            'js_options' => array(
              'zoom' => 15,
            )
          );
          echo rwmb_meta('location', $args); ?>
        </div>
      <?php } ?>
    </div>
  </div><!-- .realty-tabs -->
<?php } ?>
</div>
<div class="price-area">

  <?php $arrayMeta = array( 
    'Giá'                  => 'price-realty',
    'Giá đang cho thuê'    => 'p_rent',
    'Ngày đăng tin'        => 'begin_date',
    'Địa chỉ'              => 'address',
    'Kích thước'           => 'width',
    'Diện tích công nhận'  => 'area-realty',
    'Diện tích SD'         => 'sizeuse',
    'Số lầu'               => 'floor',
    'Số phòng'             => 'realty-bedroom',
    'Số WC'                => 'room_wc',
    'Ghi chú riêng'        => 'note',
    'Đang kinh doanh'      => 'incomehas',
    'Thu nhập từ bđs'      => 'income',
    'Hẻm xe hơi'           => 'hemoto',
    'Đường/Hẻm rộng'       => 'strtwidth',
    'Xe hơi để trong nhà?' => 'car_in',
    'Có tầng hầm'          => 'basement',
    'Nội thất'             => 'interiorwhat',
    'Thang máy'            => 'elevator',
    'Vị trí cầu thang'     => 'stair',
    'Hướng nhà đất'        => 'realty-quarter',
  ); ?>
  <div class="meta-info-da">
    <div class="meta">
      <span class="stt">1</span>
      <strong>Mã bất động sản: </strong><span class="value"><?php echo (rwmb_meta('_sku')) ? rwmb_meta('_sku') : get_the_ID(); ?></span>
    </div>
    <div class="meta">
      <span class="stt">2</span>
      <strong>Khu vực: </strong><span class="value"><?php the_terms(get_the_ID(),'city-realty'); ?></span>
    </div>
    <div class="meta">
      <span class="stt">3</span>
      <strong>Loại bất động sản: </strong>
      <span class="value">
        <?php
        $check_term = TRUE;
        switch ($check_term) {
          case get_the_terms(get_the_ID(), 'realty-sell' ):
          echo the_terms(get_the_ID(), 'realty-sell' );
          break;
          case get_the_terms(get_the_ID(), 'realty-rent' ):
          echo the_terms(get_the_ID(), 'realty-rent' );
          break;
          case get_the_terms(get_the_ID(), 'realty-transfer' ):
          echo the_terms(get_the_ID(), 'realty-transfer' );
          break;
          default:
                                            # code...
          break;
        } ?>
      </span>
    </div>
    <?php $count_mb = 2;
    foreach ($arrayMeta as $label => $value) { 
      if ( rwmb_meta($value) ) { $count_mb++; ?>
        <div class="meta">
          <span class="stt"><?php echo $count_mb; ?></span>
          <strong><?php echo $label ?>: </strong>
          <span class="value"><?php 

          switch ($value) {
            case 'price-realty':
            echo rwmb_meta('label') . ' ' . rwmb_meta('price-realty') . ' ' . rwmb_meta('label_after');
            break;
            case 'p_rent':
            echo rwmb_meta('p_rent');
            break;
            case 'hemoto': case 'car_in': case 'basement': case 'elevator' :
            echo 'Có';
            break;
            case 'area-realty': case 'sizeuse' :
            echo rwmb_meta($value) . ' m<sup>2</sup>' ;
            break;
            case 'strtwidth':
            echo rwmb_meta('strtwidth') . '+ mét';
            break;
            case 'address':
            echo rwmb_meta('address') . ' ' . rwmb_meta('street');
            break;
            case 'width': 
            echo rwmb_meta('width') . 'x' . rwmb_meta('long') . 'x' . rwmb_meta('width2') .' (Rộng x Dài X Nở hậu)';
            break;
            case 'realty-quarter' :
            $quarters = rwmb_meta('realty-quarter');
            foreach ($quarters as $quarter) {
              echo $quarter->name . ', ';
            }
            break;
            default:
            echo rwmb_meta($value);
            break;
          }

          ?></span>
        </div>
      <?php }
    } ?>
  </div>

</div><!-- .price-area -->
<div class="realty-des"></div><!-- .realty-des -->
<?php if ( 'post' === get_post_type() ) : ?>
  <div class="entry-meta">
   <?php get_template_part( 'lib/loops/meta-archive' ); ?>
 </div><!-- .entry-meta -->
 <?php
endif; ?>
<div class="entry-content">
  <div class="realty-infor">
   <h3 class="info-des"><?php _e( 'Thông tin BDS' ,'hrm' ); ?></h3>
   <?php the_content(); ?>
   <div class="so-hong clear clearfix">
     <?php if ( is_user_logged_in() ) {
       $size = 'vertical-slider';
       $legaldocs = rwmb_meta('legaldoc','type=image_advanced&size='.$size, $post->ID);
       if (count($legaldocs)) { ?>
         <div id="proj_slide" class="owl-carousel">
          <?php foreach ($legaldocs as $img) { ?>
            <div class="item">
                <a class="fancybox" href="<?php echo $img['full_url']; ?>" data-fancybox="gallery">
                  <img src="<?php echo $img['full_url']; ?>">
                </a>
            </div>
          <?php } ?>
        </div>
      <?php }
    } ?>
  </div>
</div><!-- .realty-infor -->

<div class="realty-contact">
  <div class="row">
    <div class="col-sm-12">
      <h3><?php _e( 'Thông tin liên hệ' ,'hrm' ); ?></h3>
      <ul>
        <li>
          <span class="key"><?php _e( 'Tên chủ nhà' , 'hrm' ); ?></span>
          <span class="value"><?php echo rwmb_meta('tenchunha') ; ?></span>
        </li>
        <li>
          <span class="key"><?php _e( 'Số chủ nhà' , 'hrm' ); ?></span>
          <span class="value">
            <a href="tel:<?php echo rwmb_meta('mobile') ; ?>">
              <?php echo rwmb_meta('mobile') ; ?>
            </a>
          </span>
        </li>
        <li>
          <span class="key"><?php _e( 'SĐT Môi giới Hỗ trợ' , 'hrm' ); ?></span>
          <span class="value">
            <a href="tel:<?php echo rwmb_meta('support') ; ?>">
              <?php echo rwmb_meta('support') ; ?>
            </a>
          </span>
        </li>
        <?php if (rwmb_meta('sold')) { ?>
          <li>
            <span class="key"><?php _e( 'Đã bán/Ngừng giao dịch' , 'hrm' ); ?></span>
            <span class="value"><?php echo rwmb_meta('end_date') ?></span>
          </li>
        <?php } ?>
        <li>
          <span class="key"><?php _e( 'Trạng thái' , 'hrm' ); ?></span>
          <span class="value"><?php echo rwmb_meta('p_status') ?></span>
        </li>

      </ul>
    </div>
  </div>
</div><!-- .realty-tabs -->
<?php if (is_single() && $share_social) : ?>
  <?php hrm_social_share(get_the_ID()); ?>
<?php endif; ?>
<div class="realty-form">
  <div class="title">
    <h3>
      <img src="<?php echo THEME_URL.'images/guibinhluan.png'; ?>"/>
      <?php _e( 'GỬI YÊU CẦU CHO BẤT ĐỘNG SẢN NÀY', 'hrm' ); ?>
    </h3>
  </div>
  <div class="form-body">
    <?php echo do_shortcode( '[ninja_forms id=3]' ); ?>
  </div>
</div><!-- .realty-form -->
</div><!-- .entry-content -->
</article><!-- #post-## -->
