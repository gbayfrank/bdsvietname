<?php
global $hrm_options;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php echo $hrm_options[ 'hrm-favicon' ]['url']; ?>" />
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<?php wp_head(); ?>
<?php if ($hrm_options['quick_css']) { ?>
	<style><?php echo $hrm_options['quick_css'] ?></style>
<?php } ?>
<script>
	base_url = '<?php echo home_url(); ?>';
	style_url = '<?php echo get_stylesheet_directory_uri(); ?>';
	ajax_url = '<?php echo home_url(); ?>/wp-admin/admin-ajax.php';
	search_url = '<?php echo home_url(); ?>/tim-kiem';
	setTimeout(function() {
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0&appId=1748349635396853";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	}, 3000);	
	
</script>
</head>
<body <?php body_class(); ?>>
	<div class="menu-responsive hidden-lg">
	  <div class="menu-close">
	    <i class="fa fa-bars"></i>
	    <span>Menu</span>
	    <i class="fa fa-times"></i>
	  </div>
		<?php
		wp_nav_menu( array(
			'theme_location'  => 'primary',
		) );
		?>
	</div>
<div id="page" class="site">
	<?php
		$phone = $hrm_options['hrm-phone'];
		$logo = $hrm_options['hrm-logo'];
	?>
	<header id="masthead" class="site-header" role="banner">
		<div class="menu-icon hidden-lg hidden-md">
			<div class="menu-open">
				<div class="pull-right">
					<div class="icon-click">
						<i class="fa fa-bars"></i>
					</div>
				</div>
			</div>
		</div> <!-- Menu-mobile	 -->

		<div class="top-bar">
			<div class="container">
				<div class="row">
					<div class="top-phone col-xs-4">
						<?php  if ($phone) : ?>
							<a href="tel:<?php echo $phone; ?>">
								<i class="fa fa-phone" aria-hidden="true"></i>
								<span><?php _e( 'Hotline :' ); ?> <?php echo $phone; ?></span>
							</a>
						<?php endif; ?>
					</div><!-- div.top-phone -->
					<div class="login-logout col-xs-8">
						<?php hrm_login_head(); ?>
					</div><!-- div.login-logout -->
				</div>
			</div>
		</div><!-- div.top-bar -->

		<div class="site-branding container">
			<div class="row">
				<div class="logo col-sm-4">
					<?php hrm_logo(); ?>
				</div><!-- div.logo -->
				<div class="hrm-banner col-xs-8">
					<?php
						$banner_ads = $hrm_options['hrm-banner-ads'];
						if ( $banner_ads) :
					?>
					<a href="<?php echo $hrm_options['hrm-banner-link'] ?>">
						<img class="img-responsive lazy" src="<?php echo $banner_ads['url'] ?>" alt="banner_ads">
					</a>
					<?php endif; ?>
				</div><!-- .hrm-banner -->
			</div>
		</div><!-- .site-branding -->

		<div id="main-menu">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="navbar-header visible-lg visible-md">
							<nav id="site-navigation" class="site-navigation">
								<?php
								wp_nav_menu( array(
									'theme_location'  => 'primary',
									'menu_id'         => 'navigation',
								) );
								?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div><!-- .menu -->

		<?php if (is_front_page()) : ?>
			<div class="advanced-search">
				<div class="filter-search container">
					<div class="form-search">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#sell" aria-controls="sell" role="tab" data-toggle="tab">		<?php _e( 'Bất động sản' , 'hrm' ); ?>
								</a>
							</li>
							<li role="presentation">
								<a href="#project-property" aria-controls="project-property" role="tab" data-toggle="tab">
									<?php _e( 'Dự án', 'hrm' ); ?>
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="sell">
								<?php get_template_part( 'template-parts/form/form-realty' ); ?>
							</div>
							<div role="tabpanel" class="tab-pane" id="project-property">
								<?php get_template_part( 'template-parts/form/form-project' ); ?>
							</div>
							
						</div>
					</div>
				</div><!-- .filter-search -->
			</div><!-- div.advanced-search -->
		<?php endif; ?>
		
	</header><!-- #masthead -->
	<?php
		$sidebar = $hrm_options['default-sidebar-postion'];
	?>
	<div id="content" class="site-content <?php echo $sidebar; ?>">
		<div class="container">
			<?php if(!is_front_page()) : ?>
				<div class="hrm-breadcrums">
					<?php hrm_breadcrumbs(); ?>
				</div>
			<?php endif; ?>
			<div class="row">

