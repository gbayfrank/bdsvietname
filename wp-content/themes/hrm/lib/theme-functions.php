<?php
global $hrm_options;

function hrm_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('',  'hrm') . '</label>
	<input type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="" />
	<input type="submit" class="search-submit" value="Search">
</form>';
return $form;
}
add_filter( 'get_search_form', 'hrm_search_form' );
function getCurrentPageURL() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {
      if ($_SERVER['HTTPS'] == 'on') {
        $pageURL .= "s";
      }
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
require THEME_DIR . 'lib/functions/related-post.php';
require THEME_DIR . 'lib/functions/register-sidebar.php';
require THEME_DIR . 'lib/functions/social-share.php';
require THEME_DIR . 'lib/functions/custom_breadcrums.php';
require THEME_DIR . 'lib/functions/meta-boxes.php';
require THEME_DIR . 'lib/functions/pagination.php';
require THEME_DIR . 'lib/functions/register-post-type.php';
require THEME_DIR . 'lib/functions/search.php';
require THEME_DIR . 'lib/widget/widgets.php';
require THEME_DIR . 'lib/custom-login.php';
require THEME_DIR . 'lib/admin/check-login.php';
require THEME_DIR . 'lib/meta-box-group/meta-box-group.php';
require THEME_DIR . 'lib/mb-frontend-submission/mb-frontend-submission.php';
require THEME_DIR . 'lib/meta-box-columns/meta-box-columns.php';

//custom logo

function hrm_logo() {
  global $hrm_options;
  $logo = $hrm_options['hrm-logo'];
  $size = '';
  if ( $width = $hrm_options[ 'hrm-logo-dimensions'][ 'width' ] )
      $size .= ' width:' . esc_attr( $width ) . ';';
  if ( $height = $hrm_options[ 'hrm-logo-dimensions'][ 'height' ] )
      $size .= ' height:' . esc_attr( $height ) . '';
  echo '<a href="'.HOME_URL.'" rel="home">';
    if ( is_front_page() || is_home() ) { ?>
      <img class="img-responsive" src="<?php echo $logo['url'];?> " style="<?php echo $size; ?>">
      <h1 style="display: none;"><?php echo bloginfo( 'name' ); ?></h1>
    <?php } else { ?>
      <img class="img-responsive" src="<?php echo $logo['url'];?> " style="<?php echo $size; ?>">
      <h2 style="display: none;"><?php echo bloginfo( 'name' ); ?></h2>
    <?php }
  echo '</a>';
}
function menhgia($price) {
    if($price > 999) {
        $gia = number_format($price, 0, ',', ' ').' VNĐ';
    } else {
        $gia = $price.' VNĐ';
    }
    echo $gia;
}
add_action('wp_ajax_type_term', 'type_term');
add_action('wp_ajax_nopriv_type_term', 'type_term');
function type_term() {
    if(isset($_POST['type'])) {
        $args_term = array(
            'taxonomy'           => $_POST['type'],
            'hide_empty'         => 0,
        );
        $terms = get_categories( $args_term );
        foreach ($terms as $term) {
            $option .= '<option value="'.$term->slug.'">';
            $option .= $term->name;
            $option .= '</option>';
        }
        echo '<option value="" selected="selected">'.__('- Chọn tịn đăng -','hrm').'</option>'.$option;
        die();
    } // end if
}
add_action('wp_ajax_duyetbai', 'duyetbai');
add_action('wp_ajax_nopriv_duyetbai', 'duyetbai');
function duyetbai() {
    if(isset($_POST['id'])) {
        $post_information = array(
            'ID' => $_POST['id'],
            'post_status' => 'publish',
        );
        wp_update_post( $post_information );
        update_post_meta($_POST['id'], 'nguoi-duyet', wp_kses($_POST['name'], $allowed) );
        $post_author_id = get_post_field( 'post_author', $_POST['id'] );
        $score =  get_usermeta( $post_author_id, 'score-user' );
        $score1 = $score + 1;
        update_usermeta( $post_author_id, 'score-user', $score1 );
    die();
    } // end if
}

function hrm_hotline_rung() {
  global $hrm_options;
  $hotline = $hrm_options['hrm_hotline_rung']; ?>
  <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon" >
    <div class="phonering-alo-ph-circle"></div>
    <div class="phonering-alo-ph-circle-fill"></div>
    <div class="phonering-alo-ph-img-circle">
      <a href="tel:<?php echo $hotline; ?>" class="pps-btn-img " title="Liên hệ">
        <img src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50"
        onmouseover="this.src='//i.imgur.com/v8TniL3.png';"
        onmouseout="this.src='//i.imgur.com/v8TniL3.png';">
      </a>
    </div>
  </div>
  <div class="mobile-hotline" id="mobile-hotline">
    <a href="tel:<?php echo $hotline; ?>" title="tel:<?php echo $hotline; ?>">
      <span class="text-hotline"><?php echo $hrm_options['hrm_hotline_text'] ?></span>
    </a>
  </div>
<?php 
}

add_action('wp_footer', 'hrm_hotline_rung');