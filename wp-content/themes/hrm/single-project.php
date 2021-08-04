<?php
global $hrm_options;

get_header(); ?>
<div id="primary" class="content-area col-md-12">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header clearfix">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
				<div class="new_pro_detail_img">
					<ul style="list-style: none" id="proj_slide" class="proj_slide">
						<?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');  ?>
						<li class="item" >
							<img src="<?php echo $featured_img_url; ?>" data-src="<?php echo $featured_img_url; ?>" />
						</li>
						<?php $images = rwmb_meta('pro_imgs', array( 'size' => 'full' ));
						foreach ($images as $img) { ?>
							<li class="item"  >
								<img src="<?php echo $img['full_url']; ?>" data-src="<?php echo $img['full_url']; ?>" />
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="entry-content clearfix">
					<div class="project-detail-wrap-tab">
						<div class="project-detail-wrap-ul">
							<ul id="project-detail-box-ul" class="nav nav-pills project-detail-box-ul">
								<li id="overview" class="project-detail-tab-item active">
									<a href="#1a" data-toggle="tab" class="project-detail-tab-item-a" aria-expanded="false">
										<div id="overview-1" class="project-detail-tongquan img-tab">
											<span class="icon-tongquan"></span>
											Tổng quan
										</div>
									</a>
								</li>
								<li id="location" class="project-detail-tab-item">
									<a href="#2a" data-toggle="tab" class="project-detail-tab-item-a" aria-expanded="true">
										<div id="location-1" class="project-detail-vitri img-tab">
											<span class="icon-location"></span>
											Vị trí
										</div>
									</a>
								</li>
								<li id="document" class="project-detail-tab-item">
									<a href="#3a" data-toggle="tab" class="project-detail-tab-item-a">
										<div id="document-1" class="project-detail-tailieu img-tab" >
											<span class="icon-document"></span>
											Tài liệu bh
										</div>
									</a>
								</li>
							</ul>
						</div>

						<div class="tab-content" id="project-detail-wrap-content">

							<!-- tab1 -->
							<div class="tab-pane active" id="1a">
								<?php if ( rwmb_meta('khuyen_mai') ) { ?>
									<div class="khuyen-mai-block">
										<?php echo wpautop( rwmb_meta('khuyen_mai') ); ?>
									</div>
								<?php } ?>
								<div class="project-detail-wrap-tab1">
									<div class="project-detail-instruction">
										<?php the_content(); ?>
									</div>
								</div>
							</div>

							<!-- tab2 -->
							<div class="tab-pane tab2" id="2a">
								<div class="project-detail-goolge-map">
									<?php echo rwmb_meta('bando') ?>
								</div>

								<div class="project-detail-wrap-item">
									<?php $vi_tri_group = rwmb_meta('vi_tri_group');
									if ($vi_tri_group) { ?>
										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
											<?php $count_cl = 0;
											foreach ($vi_tri_group as $vi_tri) {
												$count_cl++; ?>

												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="heading_<?php echo $count_cl ?>">
														<h4 class="panel-title">
															<a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $count_cl ?>" aria-expanded="false" aria-controls="collapse_<?php echo $count_cl ?>">
																<?php echo $vi_tri['title'] ?>
															</a>
														</h4>
													</div>
													<div id="collapse_<?php echo $count_cl ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $count_cl ?>">
														<div class="panel-body">
															<?php echo $vi_tri['noi_dung'] ?>
														</div>
													</div>
												</div>

											<?php } ?>
										</div>
									<?php } ?>

								</div>
							</div>

							<!-- tab3 -->
							<div class="tab-pane" id="3a">
								<div class="project-detail-document">
									<?php $tai_lieu_group = rwmb_meta('tai_lieu_group');
									if ($tai_lieu_group) { ?>
										<ul>
											<?php foreach ($tai_lieu_group as $tai_lieu) { ?>
												<li>
													<a href="<?php echo $tai_lieu['url'] ?>" title="<?php echo $tai_lieu['title']  ?>"><?php echo $tai_lieu['title'] ?></a>
												</li>
											<?php }?>
										</ul>
									<?php  } ?>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</article><!-- #post-## -->
			<?php 
		endwhile;
		?>
	</main><!-- #main -->
	
</div><!-- #primary -->

<?php
get_footer();
