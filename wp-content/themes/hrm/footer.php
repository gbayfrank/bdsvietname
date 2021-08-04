<?php
	global $hrm_options;
	$back_top_top   = $hrm_options['back-to-top'];
	$layout_footer  = $hrm_options['hrm-footer-layout'];
	$footer_top     = $hrm_options['show-footer-top'];
	$paper     = $hrm_options['new-stay-we'];
	$show_menu     = $hrm_options['show-menu'];

	$footer_vars = array('%year%' , '%site%' , '%url%');
	$footer_val  = array( date('Y') , get_bloginfo('name') , home_url() );
	$hrm_coppyright  = str_replace( $footer_vars , $footer_val , $hrm_options['hrm-coppyright']);
	
	$column = '';
	$col = '';
	if ($layout_footer == '1') {
		$column = 1;
		$col = 12;
	} elseif ($layout_footer == '2') {
		$column = 2;
		$col = 6;
	} elseif ($layout_footer == '3') {
		$column = 3;
		$col = 4;
	}
	elseif ($layout_footer == '4') {
		$column = 4;
		$col = 3;
	}
?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ($paper) : ?>
			<div class="paper">
				<div class="container">
					<img src="<?php echo THEME_URL.'images/dia_oc_thu_do.png' ?>"/>
					<div class="paper-say">
						<div class="marquee-with-options">
							<?php
								foreach ($paper as $value) {
									printf(
										'<p><b>%1s:</b><a href="%2s">%3s</a></p>',
										$value['title'],
										$value['url'],
										$value['description']
									);
								}
							?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($show_menu) : ?>
			<div class="three-menu">
				<div class="container">
					<div class="row">
						<?php for ( $i = 1; $i <= 4; $i ++ ): ?>
							<div class="realty-menu col-md-3 col-sm-6">
								<?php
								if ( ! dynamic_sidebar( "footer-menu$i" ) )
									printf( __( 'This is the Footer Menu %s (widget area). Please go to <a href="%s">Appearance &rarr; Widgets</a> to add widgets to this area', 'hrm' ), $i, admin_url( 'widgets.php' ) );
								?>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div><!-- .three-menu -->
		<?php endif; ?>
		<?php if ($footer_top) : ?>
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<?php for ( $i = 1; $i <= $column; $i ++ ): ?>
							<div id="footer-sidebar-<?php echo $i ?>" class="footer-sidebar col-md-<?php echo $col; ?>">
								<?php
								if ( ! dynamic_sidebar( "footer-$i" ) )
									printf( __( 'This is the Footer Sidebar %s (widget area). Please go to <a href="%s">Appearance &rarr; Widgets</a> to add widgets to this area', 'hrm' ), $i, admin_url( 'widgets.php' ) );
								?>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div><!-- footer-top -->
		<?php endif; ?>
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php if ($back_top_top) : ?>
	<div id="topcontrol" class="icon-up-open" title="Scroll To Top">
		<i class="fa fa-angle-up"></i>
	</div>
<?php endif; ?>
<?php echo $hrm_options['hrm-footer-code']; ?>

<?php wp_footer(); ?>
<script>
	// var get_city = get('quick-city');
	var dataCities = JSON.parse(JSON.stringify(citiescc));
	var option_html = '';
	option_html += '<option value="">-- Chọn Tỉnh/ Thành --</option>';
	for(var i = 0; i < dataCities.length; i++){
		var district = dataCities[i];
		// if (district.id)
		option_html += '<option value="'+ district.id +'">'+ district.name +'</option>';
	}
	jQuery('.quick-city').html(option_html);

	var dataCitiesp = JSON.parse(JSON.stringify(citiesccc));
	var option_htmlp = '';
	option_htmlp += '<option value="">-- Chọn Tỉnh/ Thành --</option>';
	for(var i = 0; i < dataCitiesp.length; i++){
		var districtp = dataCitiesp[i];
		// if (district.id)
		option_htmlp += '<option value="'+ districtp.id +'">'+ districtp.name +'</option>';
	}
	jQuery('.quick-cityp').html(option_htmlp);
</script>
</body>
</html>
