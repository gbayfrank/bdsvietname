<?php

add_action( 'init', 'realty_register_post_types' );

/**
 *  Register custom post types
 *
 * @return void
 */
function realty_register_post_types()
{
	// Register Realty post type
	$labels = array(
		'name'                => _x( 'Bất động sản', 'Post Type General Name', 'hrm' ),
		'singular_name'       => _x( 'Bất động sản', 'Post Type Singular Name', 'hrm' ),
		'menu_name'           => __( 'Bất động sản', 'hrm' ),
		'parent_item_colon'   => __( 'Bất động sản cha:', 'hrm' ),
		'all_items'           => __( 'Tất cả bds', 'hrm' ),
		'view_item'           => __( 'Hiển thị bds', 'hrm' ),
		'add_new_item'        => __( 'Thêm bds', 'hrm' ),
		'add_new'             => __( 'Thêm bds', 'hrm' ),
		'edit_item'           => __( 'Chỉnh sửa bds', 'hrm' ),
		'update_item'         => __( 'Cập nhật bds', 'hrm' ),
		'search_items'        => __( 'Tìm kiếm bds', 'hrm' ),
		'not_found'           => __( 'Không tìm thấy bds', 'hrm' ),
		'not_found_in_trash'  => __( 'Không tìm thấy bds ở thùng rác', 'hrm' ),
	);

	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
		'taxonomies'    => array( 'realty-rent', 'realty-sell', 'city-realty', 'quarter', 'realty-transfer', 'khoang-gia'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'menu_icon'           => 'dashicons-admin-home',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite' => array( 'slug' => 'bds' ),
	);
	register_post_type( 'realty', $args );

	// Register realty project
	$labels = array(
		'name'                => _x( 'Dự án', 'Post Type General Name', 'hrm' ),
		'singular_name'       => _x( 'Dự án', 'Post Type Singular Name', 'hrm' ),
		'menu_name'           => __( 'Dự án', 'hrm' ),
		'parent_item_colon'   => __( 'Dự án cha:', 'hrm' ),
		'all_items'           => __( 'Tất cả dự án', 'hrm' ),
		'view_item'           => __( 'Hiển thị dự án', 'hrm' ),
		'add_new_item'        => __( 'Thêm dự án', 'hrm' ),
		'add_new'             => __( 'Thêm dự án', 'hrm' ),
		'edit_item'           => __( 'Chỉnh sửa dự án', 'hrm' ),
		'update_item'         => __( 'Cập nhật dự án', 'hrm' ),
		'search_items'        => __( 'Tìm kiếm dự án', 'hrm' ),
		'not_found'           => __( 'Không tìm thấy dự án', 'hrm' ),
		'not_found_in_trash'  => __( 'Không tìm thấy dự án ở thùng rác', 'hrm' ),
	);

	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'menu_icon'           => 'dashicons-building',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite' => array( 'slug' => 'du-an' ),
	);
	register_post_type( 'project', $args );


	// $labels = array(
	// 	'name'                       => _x( 'Dự án', 'Taxonomy General Name', 'hrm' ),
	// 	'singular_name'              => _x( 'Dự án', 'Taxonomy Singular Name', 'hrm' ),
	// 	'menu_name'                  => __( 'Dự án', 'hrm' ),
	// 	'all_items'                  => __( 'Tất cả các Dự án', 'hrm' ),
	// 	'parent_item'                => __( 'Dự án cha', 'hrm' ),
	// 	'parent_item_colon'          => __( 'Dự án cha:', 'hrm' ),
	// 	'new_item_name'              => __( 'Dự án mới', 'hrm' ),
	// 	'add_new_item'               => __( 'Thêm Dự án', 'hrm' ),
	// 	'edit_item'                  => __( 'Chỉnh sửa Dự án', 'hrm' ),
	// 	'update_item'                => __( 'Cập nhật Dự án', 'hrm' ),
	// 	'separate_items_with_commas' => __( 'Phân cách các Dự án bằng dấu phẩy', 'hrm' ),
	// 	'search_items'               => __( 'Tìm kiếm Dự án', 'hrm' ),
	// 	'add_or_remove_items'        => __( 'Thêm hoặc xóa Dự án', 'hrm' ),
	// 	'choose_from_most_used'      => __( 'Chọn từ danh sách Dự án thường được sử dụng', 'hrm'),
	// );
	// $args = array(
	// 	'labels'            => $labels,
	// 	'hierarchical'      => true,
	// 	'public'            => true,
	// 	'show_ui'           => true,
	// 	'show_admin_column' => true,
	// 	'show_in_nav_menus' => true,
	// 	'show_tagcloud'     => true,
	// 	'rewrite' => array( 'slug' => 'loai-du-an' ),
	// );
	// register_taxonomy( 'project_cat', 'project', $args );

	// Register realty category
	$labels = array(
		'name'                       => _x( 'BĐS bán', 'Taxonomy General Name', 'hrm' ),
		'singular_name'              => _x( 'BĐS bán', 'Taxonomy Singular Name', 'hrm' ),
		'menu_name'                  => __( 'BĐS bán', 'hrm' ),
		'all_items'                  => __( 'Tất cả các bds bán', 'hrm' ),
		'parent_item'                => __( 'BĐS bán cha', 'hrm' ),
		'parent_item_colon'          => __( 'BĐS bán cha:', 'hrm' ),
		'new_item_name'              => __( 'BĐS bán mới', 'hrm' ),
		'add_new_item'               => __( 'Thêm bds bán', 'hrm' ),
		'edit_item'                  => __( 'Chỉnh sửa bds bán', 'hrm' ),
		'update_item'                => __( 'Cập nhật bds bán', 'hrm' ),
		'separate_items_with_commas' => __( 'Phân cách các bds bán bằng dấu phẩy', 'hrm' ),
		'search_items'               => __( 'Tìm kiếm bds bán', 'hrm' ),
		'add_or_remove_items'        => __( 'Thêm hoặc xóa bds bán', 'hrm' ),
		'choose_from_most_used'      => __( 'Chọn từ danh sách bds bán thường được sử dụng', 'hrm' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite' => array( 'slug' => 'dat-ban' ),
	);
	register_taxonomy( 'realty-sell', 'realty', $args );


	// Register business type
	$labels = array(
		'name'                       => _x( 'BĐS cho thuê', 'Taxonomy General Name', 'hrm' ),
		'singular_name'              => _x( 'BĐS cho thuê', 'Taxonomy Singular Name', 'hrm' ),
		'menu_name'                  => __( 'BĐS cho thuê', 'hrm' ),
		'all_items'                  => __( 'Tất cả bds cho thuê', 'hrm' ),
		'parent_item'                => __( 'BĐS cho thuê cha', 'hrm' ),
		'parent_item_colon'          => __( 'BĐS cho thuê cha:', 'hrm' ),
		'new_item_name'              => __( 'BĐS cho thuê mới', 'hrm' ),
		'add_new_item'               => __( 'Thêm bds cho thuê', 'hrm' ),
		'edit_item'                  => __( 'Chỉnh sửa bds cho thuê', 'hrm' ),
		'update_item'                => __( 'Cập nhật bds cho thuê', 'hrm' ),
		'separate_items_with_commas' => __( 'Phân cách các bds cho thuê bởi dấu phẩy', 'hrm' ),
		'search_items'               => __( 'Tìm kiếm bds cho thuê', 'hrm' ),
		'add_or_remove_items'        => __( 'Thêm hoặc xóa bds cho thuê', 'hrm' ),
		'choose_from_most_used'      => __( 'Chọn từ danh sách các bds cho thuê thường được sử dụng', 'hrm' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite' => array( 'slug' => 'dat-thue' ),
	);
	register_taxonomy( 'realty-rent', 'realty', $args );


	// Register realty transfer
	$labels = array(
		'name'                       => _x( 'Sang Nhượng ', 'Taxonomy General Name', 'hrm' ),
		'singular_name'              => _x( 'Sang Nhượng ', 'Taxonomy Singular Name', 'hrm' ),
		'menu_name'                  => __( 'Sang Nhượng ', 'hrm' ),
		'all_items'                  => __( 'Tất cả sang nhượng', 'hrm' ),
		'parent_item'                => __( 'Sang Nhượng  cha', 'hrm' ),
		'parent_item_colon'          => __( 'Sang Nhượng  cha:', 'hrm' ),
		'new_item_name'              => __( 'Sang Nhượng  mới', 'hrm' ),
		'add_new_item'               => __( 'Thêm sang nhượng', 'hrm' ),
		'edit_item'                  => __( 'Chỉnh sửa sang nhượng', 'hrm' ),
		'update_item'                => __( 'Cập nhật sang nhượng', 'hrm' ),
		'separate_items_with_commas' => __( 'Phân cách các sang nhượng bởi dấu phẩy', 'hrm' ),
		'search_items'               => __( 'Tìm kiếm sang nhượng', 'hrm' ),
		'add_or_remove_items'        => __( 'Thêm hoặc xóa sang nhượng', 'hrm' ),
		'choose_from_most_used'      => __( 'Chọn từ danh sách các sang nhượng thường được sử dụng', 'hrm' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite' => array( 'slug' => 'sang-nhuong' ),
	);
	register_taxonomy( 'realty-transfer', 'realty', $args );

	// Register realty city
	$labels = array(
		'name'                       => _x( 'Tỉnh / Quận ( Huyện )', 'Taxonomy General Name', 'hrm' ),
		'singular_name'              => _x( 'Tỉnh / Quận ( Huyện )', 'Taxonomy Singular Name', 'hrm' ),
		'menu_name'                  => __( 'Tỉnh / Quận ( Huyện )', 'hrm' ),
		'all_items'                  => __( 'Tất cả các Tỉnh thành', 'hrm' ),
		'parent_item'                => __( 'Tỉnh thành cha', 'hrm' ),
		'parent_item_colon'          => __( 'Tỉnh thành cha:', 'hrm' ),
		'new_item_name'              => __( 'Tỉnh thành mới', 'hrm' ),
		'add_new_item'               => __( 'Thêm Tỉnh thành', 'hrm' ),
		'edit_item'                  => __( 'Chỉnh sửa Tỉnh thành', 'hrm' ),
		'update_item'                => __( 'Cập nhật Tỉnh thành', 'hrm' ),
		'separate_items_with_commas' => __( 'Phân cách các Tỉnh thành bằng dấu phẩy', 'hrm' ),
		'search_items'               => __( 'Tìm kiếm Tỉnh thành', 'hrm' ),
		'add_or_remove_items'        => __( 'Thêm hoặc xóa Tỉnh thành', 'hrm' ),
		'choose_from_most_used'      => __( 'Chọn từ danh sách Tỉnh thành thường được sử dụng', 'hrm' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite' => array( 'slug' => 'tinh-thanh' ),
	);
	register_taxonomy( 'city-realty', 'realty', $args );


	// Register realty city
	// $labels = array(
	// 	'name'                       => _x( 'Tỉnh / Quận ( Dự án )', 'Taxonomy General Name', 'hrm' ),
	// 	'singular_name'              => _x( 'Tỉnh / Quận ( Dự án )', 'Taxonomy Singular Name', 'hrm' ),
	// 	'menu_name'                  => __( 'Tỉnh / Quận ( Dự án )', 'hrm' ),
	// 	'all_items'                  => __( 'Tất cả các Tỉnh thành', 'hrm' ),
	// 	'parent_item'                => __( 'Tỉnh thành cha', 'hrm' ),
	// 	'parent_item_colon'          => __( 'Tỉnh thành cha:', 'hrm' ),
	// 	'new_item_name'              => __( 'Tỉnh thành mới', 'hrm' ),
	// 	'add_new_item'               => __( 'Thêm Tỉnh thành', 'hrm' ),
	// 	'edit_item'                  => __( 'Chỉnh sửa Tỉnh thành', 'hrm' ),
	// 	'update_item'                => __( 'Cập nhật Tỉnh thành', 'hrm' ),
	// 	'separate_items_with_commas' => __( 'Phân cách các Tỉnh thành bằng dấu phẩy', 'hrm' ),
	// 	'search_items'               => __( 'Tìm kiếm Tỉnh thành', 'hrm' ),
	// 	'add_or_remove_items'        => __( 'Thêm hoặc xóa Tỉnh thành', 'hrm' ),
	// 	'choose_from_most_used'      => __( 'Chọn từ danh sách Tỉnh thành thường được sử dụng', 'hrm' ),
	// );

	// $args = array(
	// 	'labels'            => $labels,
	// 	'hierarchical'      => true,
	// 	'public'            => true,
	// 	'show_ui'           => true,
	// 	'show_admin_column' => true,
	// 	'show_in_nav_menus' => true,
	// 	'show_tagcloud'     => true,
	// 	'rewrite' => array( 'slug' => 'quan-huyen' ),
	// );
	// register_taxonomy( 'city-project', 'project', $args );

	// Register hướng nhà đất type
	$labels = array(
		'name'                       => _x( 'Hướng nhà đất', 'Taxonomy General Name', 'hrm' ),
		'singular_name'              => _x( 'Hướng nhà đất', 'Taxonomy Singular Name', 'hrm' ),
		'menu_name'                  => __( 'Hướng nhà đất', 'hrm' ),
		'all_items'                  => __( 'Tất cả hướng', 'hrm' ),
		'parent_item'                => __( 'Hướng nhà đất cha', 'hrm' ),
		'parent_item_colon'          => __( 'Hướng nhà đất cha:', 'hrm' ),
		'new_item_name'              => __( 'Hướng nhà đất mới', 'hrm' ),
		'add_new_item'               => __( 'Thêm Hướng nhà đất', 'hrm' ),
		'edit_item'                  => __( 'Chỉnh sửa Hướng nhà đất', 'hrm' ),
		'update_item'                => __( 'Cập nhật Hướng nhà đất', 'hrm' ),
		'separate_items_with_commas' => __( 'Phân cách các Hướng nhà đất bởi dấu phẩy', 'hrm' ),
		'search_items'               => __( 'Tìm kiếm Hướng nhà đất', 'hrm' ),
		'add_or_remove_items'        => __( 'Thêm hoặc xóa Hướng nhà đất', 'hrm' ),
		'choose_from_most_used'      => __( 'Chọn từ danh sách các Hướng nhà đất thường được sử dụng', 'hrm' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite' => array( 'slug' => 'huong-nha-dat' ),
	);
	register_taxonomy( 'quarter', 'realty', $args );

	$labels = array(
		'name'                       => _x( 'Khoảng giá', 'Taxonomy General Name', 'hrm' ),
		'singular_name'              => _x( 'Khoảng giá', 'Taxonomy Singular Name', 'hrm' ),
		'menu_name'                  => __( 'Khoảng giá', 'hrm' ),
		'all_items'                  => __( 'All Items', 'hrm' ),
		'new_item_name'              => __( 'New Item', 'hrm' ),
		'add_new_item'               => __( 'Add New', 'hrm' ),
		'edit_item'                  => __( 'Edit Item', 'hrm' ),
		'update_item'                => __( 'Update Item', 'hrm' ),
		'view_item'                  => __( 'View Item', 'hrm' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'hrm' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'hrm' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'hrm' ),
		'popular_items'              => __( 'Popular Items', 'hrm' ),
		'search_items'               => __( 'Search Items', 'hrm' ),
		'not_found'                  => __( 'Not Found', 'hrm' ),
		'no_terms'                   => __( 'No items', 'hrm' ),
		'items_list'                 => __( 'Items list', 'hrm' ),
		'items_list_navigation'      => __( 'Items list navigation', 'hrm' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'khoang-gia', array( 'realty' ), $args );


	$labels = array(
		'name'                => _x( 'Lịch sử nạp', 'Post Type General Name', 'hrm' ),
		'singular_name'       => _x( 'Lịch sử nạp', 'Post Type Singular Name', 'hrm' ),
		'menu_name'           => __( 'Lịch sử nạp', 'hrm' ),
		'parent_item_colon'   => __( 'Lịch sử nạp cha:', 'hrm' ),
		'all_items'           => __( 'Tất cả lịch sử', 'hrm' ),
		'view_item'           => __( 'Hiển thị lịch sử', 'hrm' ),
		'add_new_item'        => __( 'Thêm Lịch Sử', 'hrm' ),
		'add_new'             => __( 'Thêm Lịch sử', 'hrm' ),
		'edit_item'           => __( 'Chỉnh sửa lịch sử', 'hrm' ),
		'update_item'         => __( 'Cập nhật lịch sử', 'hrm' ),
		'search_items'        => __( 'Tìm kiếm lịch sử', 'hrm' ),
		'not_found'           => __( 'Không tìm thấy lịch sử nạp thẻ', 'hrm' ),
		'not_found_in_trash'  => __( 'Không tìm thấy lịch sử nạp thẻ ở thùng rác', 'hrm' ),
	);

	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'menu_icon'           => 'dashicons-analytics',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite' => array( 'slug' => 'lich-su-nap' ),
	);
	global $hrm_options;
	if ($hrm_options['hrm_put_bill']) {
		register_post_type( 'lich-su-nap', $args );
	}
	
}