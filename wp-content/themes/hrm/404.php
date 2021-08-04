<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Ham_Rong_Media
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Rất tiếp nội dung không được tìm thấy.', 'hrm' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'Trang này không tồn tại hoặc đã bị xóa, hãy thử tìm kiếm với những thứ khác', 'hrm' ); ?></p>
					<div class="img-404">
						<img src="<?php echo THEME_URL .'images/img-404.png'; ?>">
					</div>
					<?php
						get_search_form();
					?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
<?php
get_footer();
