<aside id="secondary" class="widget-area col-md-3" role="complementary">
	<div class="widget-advanced-search">
		<div class="widget-search">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="sell active">
						<a href="#widget-sell" aria-controls="widget-sell" role="tab" data-toggle="tab">
							<?php _e( 'Tìm kiếm bất động sản' , 'hrm' ); ?>
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="widget-sell">
						<?php get_template_part( 'template-parts/form/form-realty-widget' ); ?>
					</div>

				</div>
		</div>
	</div>
	<!-- div.advanced-search -->
	<?php dynamic_sidebar( 'left-primary' ); ?>
</aside><!-- #secondary -->