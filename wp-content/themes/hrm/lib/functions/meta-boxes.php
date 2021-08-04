<?php

add_filter( 'rwmb_meta_boxes', 'hrm_register_meta_boxes' );

function hrm_register_meta_boxes( $meta_boxes )
{
	global $hrm_options;

	if ( $hrm_options['hrm_put_bill']) {
		$meta_boxes[] = array(
			'title'      => 'Cấu hình thanh toán',
			'pages'  => array( 'realty' ),
			'fields' => array(
				array(
					'id'            => 'thanh-toan',
					'name'          => __( 'Tình trạng thanh toán', 'hrm' ),
					'type'          => 'checkbox',
				),
			),
		);
	}
	$meta_boxes[]  = array(
		'title'  => __( 'Cấu hình bất động sản', 'hrm' ),
		'pages'  => array( 'realty' ),
		'fields' => array(
			array(
				'id'   => 'nb_type',
				'name' => __( 'Tin nổi bật', 'hrm' ),
				'desc' => __( 'Check nếu là bds nổi bật?', 'hrm' ),
				'type' => 'checkbox',
				'tab'  => 'realty-info',
			),
			array(
				'id'   => 'vip_type',
				'name' => __( 'Tin VIP', 'hrm' ),
				'desc' => __( 'Check nếu là bds vip?', 'hrm' ),
				'type' => 'checkbox',
				'tab'  => 'realty-info',
			),
		)
	);
	$meta_boxes[]  = array(
		'title'  => __( 'Cấu hình bất động sản', 'hrm' ),
		'pages'  => array( 'realty' ),
		'id'            => 'meta_box_realty',
		// 'tabs'      => array(
		// 	'realty-info' => array(
		// 		'label' => __( 'Thông tin nhà đất', 'hrm' ),
		// 		'icon'  => 'dashicons-admin-generic', // Dashicon
		// 	),
		// 	'realty-contact'  => array(
		// 		'label' => __( 'Thông tin liên hệ', 'rwmb' ),
		// 		'icon'  => 'dashicons-email', // Dashicon
		// 	),
		// 	'realty-images'  => array(
		// 		'label' => __( 'Hình ảnh', 'rwmb' ),
		// 		'icon'  => 'dashicons-format-gallery', // Dashicon
		// 	),
		// ),
		// 'tab_style' => 'box',
		'fields' => array(
			array (
				'id' => 'custom_html_47',
				'type' => 'custom_html',
				'name' => 'Custom HTML',
				'std' => '<b>Có dấu * là mục hiện trong Form Search</b>',
			),
			array(
				'id'   => '_sku',
				'name' => __( 'Mã tin', 'hrm' ),
				'type' => 'text',
				'tab'  => 'realty-info',
			),
			//tab realty images
			array(
				'id'            => 'gallery',
				'name'          => __( 'Hình ảnh', 'hrm' ),
				'type'          => 'image_advanced',
				'size' 			=> '30',
				'tab'           => 'realty-images',
			),
			array (
				'id' => 'label',
				'type' => 'text',
				'name' => 'Nhãn trước giá',
				'desc' => 'Ví dụ : Liên hệ + Giá + Nhãn sau giá',
				'size' => 30,
			),
			array(
				'id'            => 'price-realty',
				'name'          => __( '* Giá', 'hrm' ),
				'type'          => 'number',
				'step'        => 'any',
				'min'		 	=> 0,
				'tab'  => 'realty-info',
			),
			array (
				'id' => 'label_after',
				'type' => 'text',
				'name' => 'Nhãn sau giá',
				'desc' => 'VD: Giá / tháng,	Giá + còn TL,...',
				'size' => 30,
			),
			array(
				'name'       => __( 'Chọn khoảng giá', 'hrm' ),
				'id'         => 'between-price',
				'type'       => 'taxonomy',
				'taxonomy'   => 'khoang-gia',
				'field_type' => 'select_advanced',
			),

			array (
				'id' => 'p_rent',
				'type' => 'text',
				'name' => 'Giá đang cho thuê (nếu có)',
			),
			
			array(
				'name' => __( 'Ngày đăng tin', 'hrm' ),
				'id'   => "begin_date",
				'type' => 'date',
				'js_options' => array(
					'appendText'      => __( '(dd-mm-yyyy)', 'hrm' ),
					'dateFormat'      => __( 'dd-mm-yy', 'hrm' ),
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => true,
				),
			),
			
			array (
				'id' => 'address',
				'type' => 'text',
				'name' => 'Số nhà',
			),
			
			array (
				'id' => 'street',
				'type' => 'text',
				'name' => '* Tên đường',
			),
			array (
				'id' => 'street_ko_dau',
				'type' => 'text',
				'name' => 'Tên đường không dấu' ,
				'desc' => 'Đây là mục hỗ trợ tìm kiếm tên đường',
			),

			array(
				'name'    => __( 'Tỉnh thành / Quận Huyện', 'hrm' ),
				'id'      => 'city_district',
				'type'    => 'taxonomy',
				'taxonomy' => 'city-realty',
				'field_type'     => 'select_tree',
				'query_args'	 => array(
				),
				'tab'  => 'realty-info',
			),
			

			array(
			'id'            => 'par_value',
			'name'          => __( 'Mệnh giá', 'hrm' ),
			'type'          => 'select',
			'options' 		=> array(
			 		'Triệu'    => __( 'Triệu', 'hrm' ),
			 		'Triệu/m2' => __( 'Triệu/m2', 'hrm' ),
			 		'Tỷ'    => __( 'Tỷ', 'hrm' ),
			 		'Thỏa thuận'      => __( 'Thỏa thuận', 'hrm' ),
			 	),
			 	'tab'  => 'realty-info',
			 ),
			
			array (
				'id' => 'divider_6',
				'type' => 'divider',
				'name' => 'Divider',
			),
			array (
				'id' => 'width',
				'type' => 'number',
				'name' => '* Rộng',
				'step'        => 'any',
				'desc' => 'Rộng, Dài trong search form thì nhập số theo ý muốn.',
			),
			array (
				'id'   => 'long',
				'type' => 'number',
				'name' => '* Dài',
				'step' => 'any',
			),
			array (
				'id'   => 'width2',
				'type' => 'number',
				'name' => 'Nở hậu',
				'step' => 'any',
			),
			array(
				'id'   => 'area-realty',
				'name' => __( 'Diện tích công nhận (DTCN)', 'hrm' ),
				'type' => 'number',
				'step' => 'any',
				'min'  => 0,
				'tab'  => 'realty-info',
			),
			array (
				'id'   => 'sizeuse',
				'type' => 'number',
				'name' => '* DTSD (tổng diện tích sàn sử dụng các lầu hầm)',
				'desc' => 'Khi search thì chỉ chọn 1 trong 2 là DTCN hoặc DTSD, nếu chọn DTCN thì Search sẽ bỏ qa DTSD ',
			),
			array (
				'id'   => 'floor',
				'type' => 'number',
				'name' => '* Số lầu',
				'desc' => 'Search Form hiện theo kiểu dropdown :	1 trệt | 1+ lầu | 2+ lầu | 3+ lầu | 4+ lầu | 5+ lầu | 6+ lầu | 10+ lầu',
			),
			array(
				'name' => __( '* Số phòng', 'hrm' ),
				'id'   => 'realty-bedroom',
				'type' => 'number',
			),
			array (
				'id'   => 'room_wc',
				'type' => 'number',
				'name' => 'Số WC',
			),
			array (
				'id'   => 'note',
				'type' => 'textarea',
				'name' => 'Ghi chú riêng',
			),
			array (
				'id' => 'incomehas',
				'type' => 'text',
				'name' => 'BĐS đang kinh doanh gì ??',
				'desc' => 'Bđs đang đc kinh doanh hay dùng làm việc gì ??',
			),
			array (
				'id' => 'income',
				'type' => 'text',
				'name' => '* Thu nhập từ bđs (cho thuê, tự kinh doanh)',
				'desc' => 'Khi nhập thì nhập giá tiền, Nhưng trong Search Form thì	là check box',
			),
			array (
				'id' => 'hemoto',
				'name' => '* Hẻm xe hơi?',
				'type' => 'checkbox',
				'desc' => 'Search form là check box',
			),
			array (
				'id' => 'strtwidth',
				'type' => 'number',
				'name' => '* Đường/Hẻm rộng',
				'desc' => 'Search form là dropdown :	 1+ mét |	2+ mét |	3+ mét | 4+ met | 5+ mét | 6+ mét',
			),
			array (
				'id' => 'car_in',
				'name' => 'Xe hơi để trong nhà?',
				'type' => 'checkbox',
			), 
			array (
				'id' => 'basement',
				'name' => 'Có tầng hầm',
				'type' => 'checkbox',
			),
			array (
				'id' => 'interior',
				'name' => '* Nhà có sẵn nội thất ???',
				'type' => 'checkbox',
				'desc' => 'Search form là checkbox. Còn frontend khi User check vào đây thì sẽ hiện thêm field : Nội thất gồm có gì?',
			),
			array (
				'id' => 'interiorwhat',
				'type' => 'textarea',
				'name' => 'Nội thất có gì',
				'desc' => 'nếu đánh dấu có thì hãy nhập hiện có nội thất gì trong nhà?',
				'hidden' => array( 'interior', '!=', 1 )
			),
			array (
				'id' => 'elevator',
				'name' => '* Có thang máy',
				'type' => 'checkbox',
				'desc' => 'Search form là checkbox',
			),
			array (
				'id' => 'stair',
				'name' => '* Pháp lý',
				'type' => 'select',
				'desc' => 'search form là Dropdown select',
				'placeholder' => 'Select an Item',
				'options' => 
				array (
					'Trích đo' => 'Trích đo',
					'Sổ đỏ' => 'Sổ đỏ',
				),
			),
			array(
				'name'       => __( ' Hướng nhà đất', 'hrm' ),
				'id'         => 'realty-quarter',
				'type'       => 'taxonomy',
				'taxonomy'   => 'quarter',
				'field_type' => 'select_tree',
				'query_args' => array(),
				'tab'        => 'realty-info',
				'std'        => '17',
			),
			array (
				'id' => 'tenchunha',
				'type' => 'text',
				'name' => 'Tên chủ nhà',
			),
			array (
				'id' => 'mobile',
				'type' => 'text',
				'name' => 'Số chủ nhà',
			),
			
			array (
				'id' => 'affiliate',
				'type' => 'text',
				'name' => 'Hoa hồng MG',
			),
			array (
				'id' => 'support',
				'type' => 'text',
				'name' => 'SĐT Môi giới Hỗ trợ',
			),
			array (
				'id' => 'sold',
				'name' => 'Đã bán/Ngừng giao dịch?',
				'type' => 'checkbox',
			),
			array(
				'name' => __( 'Ngày ngừng bán', 'hrm' ),
				'id'   => "end_date",
				'type' => 'date',
				'js_options' => array(
					'appendText'      => __( '(dd-mm-yyyy)', 'hrm' ),
					'dateFormat'      => __( 'dd-mm-yy', 'hrm' ),
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => true,
				),
				'hidden' => array( 'sold', '!=', 1 ),
				'tab'  => 'realty-info',
			),
			array (
				'id'   => 'p_status',
				'type' => 'text',
				'name' => 'Trạng thái',
				'desc' => 'Bán gấp, Đang mở cửa, Nợ ngân hàng,...',
			),
			array (
				'id'               => 'legaldoc',
				'type'             => 'image_advanced',
				'name'             => 'Sổ hồng',
				'desc'             => 'hình sổ hồng, pdf giấy tờ liên quan (chỉ hiện cho thành viên đã login)',
				'max_file_uploads' => 10,
				'max_status'       => false,
			),

			
			array(
				'id'   => 'tim_map',
				'name' => __( 'Tìm địa chỉ trên bản đồ', 'hrm' ),
				'type' => 'text',
				'std'  => __( 'Hanoi, Vietnam', 'hrm' ),
				'tab'  => 'realty-info',
			),
			array(
				'id'            => 'location',
				'name'          => __( 'Bản đồ', 'fitrealty' ),
				'type'          => 'map',
				'std'           => '10.8150853, 106.6306123, 15',
				'style'         => 'width: 100%; height: 350px',
				'address_field' => 'tim_map', 
				'tab'           => 'realty-info',
				'language'      => 'vi',
				'region'        => 49000,
				'api_key'       => $hrm_options['hrm_api_map'],
			),

		),
);
$meta_boxes[] = array(
	'title'      => 'Cấu hình dự án',
	'pages'  => array( 'project' ),
	'fields' => array(
		array(
			'id'            => 'project_star',
			'name'          => __( 'Dự án nổi bật', 'hrm' ),
			'desc' => __( 'Check nếu là dự án nổi bật?', 'hrm' ),
			'type'          => 'checkbox',
		),
		array(
			'name'             => 'Ảnh dự án',
			'id'               => "pro_imgs",
			'type'             => 'image_advanced',
			'max_file_uploads' => 30,
			'max_status'       => false,
		),
		array(
			'id'            => 'khuyen_mai',
			'name'          => __( 'Chính sách khuyến mãi', 'hrm' ),
			'type'          => 'textarea',
		),
		array(
			'id'            => 'bando',
			'name'          => __( 'iFame Bản đồ', 'hrm' ),
			'type'          => 'textarea',
		),
		array(
			'name'   => 'Vị trí',
			'id'     => 'vi_tri_group',
			'type'   => 'group',
			'clone'  => true,
			'fields' => array(
				array(
					'name' => 'Tiêu đề',
					'id'   => 'title',
					'type' => 'text',
				),
				array(
					'name' => 'Nội dung',
					'id'   => 'noi_dung',
					'type' => 'textarea',
				),
			),
		),
		array(
			'type' => 'divider',
		),
		array(
			'name'   => 'Tài liệu',
			'id'     => 'tai_lieu_group',
			'type'   => 'group',
			'clone'  => true,
			'fields' => array(
				array(
					'name' => 'Tiêu đề tài liệu',
					'id'   => 'title',
					'type' => 'text',
				),
				array(
					'name' => 'Đường dẫn tài liệu',
					'id'   => "url",
					'type' => 'url',
				),
			),
		),
	),
);
$meta_boxes[] = array(
	'title'      => 'Cấu hình văn phòng',
	'pages'  => array( 'office' ),
	'fields' => array(
		array(
			'name' => __( 'Chủ đầu tư', 'hrm' ),
			'id'   => 'investor_office',
			'type' => 'text',
		),
		array(
			'name' => __( 'Quy mô', 'hrm' ),
			'id'   => 'scale_office',
			'type' => 'text',
		),
		array(
			'name' => __( 'Mức giá', 'hrm' ),
			'id'   => 'price_office',
			'type' => 'text',
		),
		array(
			'name' => __( 'Trạng thái', 'hrm' ),
			'id'   => 'status_office',
			'type'        => 'select_advanced',
			'options'     => array(
				'Sắp khởi công'         => __( 'Sắp khởi công', 'hrm' ),
				'Đã xây thô'         => __( 'Đã xây thô', 'hrm' ),
				'Đang hoàn thiện'        => __( 'Đang hoàn thiện', 'hrm' ),
				'Đã bàn giao'        => __( 'Đã bàn giao', 'hrm' ),
			),
			'multiple'    => false,
			'std'         => '0-500',
			'placeholder' => __( 'Chọn trạng thái', 'hrm' ),
		),
		array(
			'name'    => __( 'Địa chỉ', 'hrm' ),
			'id'      => 'address_office',
			'type'    => 'taxonomy',
			'taxonomy' => 'city-office',
			'field_type'     => 'select_tree',
			'query_args'     => array(
			),
		),
	),
);
return $meta_boxes;
}