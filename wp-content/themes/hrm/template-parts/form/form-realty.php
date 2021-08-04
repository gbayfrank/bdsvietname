<div class="realty-filter clearfix">
	<form action="<?php echo home_url('/tim-bat-dong-san'); ?>" method="GET">
		<div class="visible-fields fields">
			
			<ul class="option-select">
				<li><input id="s" class="key-search" name="key" type="text" placeholder="<?php _e('Nhập từ khóa, vd: Căn hộ vinhomes','hrm') ?>"></li>

				<li>
					<select name="cate-realty" id="cate-realty">
						<option value="">-- Chọn loại BĐS --</option>
						<?php
						$args_ban = array(
							'child_of'               => 0,
							'parent'                 => 0,
							'hide_empty'        => 1,
						);
						$term_bans = get_terms( 'realty-sell' , $args_ban );
						foreach ($term_bans as $term_ban) { ?>
							<option value="b<?php echo $term_ban->term_id; ?>"><?php echo $term_ban->name; ?> (<?php echo $term_ban->count; ?>)</option><?php
						}
						$term_thues = get_terms( 'realty-rent' , $args_thue );
						foreach ($term_thues as $term_thue) { ?>
							<option value="t<?php echo $term_thue->term_id; ?>"><?php echo $term_thue->name; ?> (<?php echo $term_thue->count; ?>)</option><?php
						}
						$term_transfers = get_terms( 'realty-transfer' , $args_thue );
						foreach ($term_transfers as $term_transfer) { ?>
							<option value="s<?php echo $term_transfer->term_id; ?>"><?php echo $term_transfer->name; ?> (<?php echo $term_transfer->count; ?>)</option><?php
						}
						?>
					</select>
				</li>
				<li>

					<select name="quick-city" class="quick-city" id="quick-city-sell">
						<option value=""><?php _e('- Chọn tỉnh / thành phố -','hrm'); ?></option>	
					</select>
					
				</li>
				<li>
					<select name="quick-district" class="quick-district" id="quick-district-sell">
						<option value=""><?php _e('-Chọn quận huyện -','hrm'); ?></option>
					</select>
				</li>
				<li>
					<select name="quick-ward" class="quick-ward" id="quick-ward-sell">
						<option value=""><?php _e('-Chọn Phường/Xã -','hrm'); ?></option>
					</select>
				</li>
				<li><input id="s" class="key-search" name="ten-duong" type="text" placeholder="<?php _e('Tên đường','hrm') ?>"></li>
				<li>
					<?php
					realty_dropdown_terms(
						array(
							'show_option_none' => __( '- Chọn khoảng giá -', 'hrm' ),
							'taxonomy'         => 'khoang-gia',
							'hide_empty'       => 0,
							'name'             => 'price',
							'id'               => 'price',
							'order'            => 'asc',
							'orderby'          => 'term_id',
							'selected'         => get_query_var( 'price' ),
						)
					);
					?>
				</li>
				<li><input id="s" class="key-search" name="width" type="number" placeholder="<?php _e('Rộng','hrm') ?>"></li>
				<li><input id="s" class="key-search" name="long" type="number" placeholder="<?php _e('Dài','hrm') ?>"></li>
				<li>
					<?php
						// Diện tích cn
					$areas = array(
						''           => __( '- Diện tích công nhận -', 'hrm' ),
						'10-50'      => '10-50 m2',
						'50-100'      => '50-100 m2',
						'100-200'    => '100-200 m2',
						'200-300'    => '200-300 m2',
						'300-999999' => 'Từ 300+ m2',
					);
					realty_dropdown( array( 'name' => 'area', 'id' => 'area', 'options' => $areas, 'selected' => get_query_var( 'area' ) ) );
					?>
				</li>
				<li>
					<?php
						// Diện tích sd
					$sizeuses = array(
						''           => __( '- Diện tích sử dụng -', 'hrm' ),
						'10-50'      => '10-50 m2',
						'50-100'     => '50-100 m2',
						'100-200'    => '100-200 m2',
						'200-300'    => '200-300 m2',
						'300-999999' => 'Từ 300+ m2',
					);
					realty_dropdown( array( 'name' => 'sizeuse', 'id' => 'sizeuse', 'options' => $sizeuses, 'selected' => get_query_var( 'sizeuse' ) ) );
					?>
				</li>
				<li>
					<?php
						// Tầng
					$floors = array(
						''  => __( '- Số tầng -', 'hrm' ),
						'1' => '1 trệt',
						'1' => '1+ tầng',
						'2' => '2+ tầng',
						'3' => '3+ tầng',
						'4' => '4+ tầng',
						'5' => '5+ tầng',
						'6' => '6+ tầng',
						'7' => '7+ tầng',
						'8' => '8+ tầng',
						'9' => '9+ tầng',
						'10' => '10+ tầng',
					);
					realty_dropdown( array( 'name' => 'floor', 'id' => 'floor', 'options' => $floors, 'selected' => get_query_var( 'floor' ) ) );
					?>
				</li>
				<li>
					<?php
						// Phòng
					$rooms = array(
						''  => __( '- Số Phòng -', 'hrm' ),
						'1' => '1 Phòng',
						'2' => '2+ Phòng',
						'3' => '3+ Phòng',
						'4' => '4+ Phòng',
						'5' => '5+ Phòng',
						'6' => '6+ Phòng',
						'7' => '7+ Phòng',
						'8' => '8+ Phòng',
						'9' => '9+ Phòng',
						'10' => '10+ Phòng',
					);
					realty_dropdown( array( 'name' => 'bedroom', 'id' => 'bedroom', 'options' => $rooms, 'selected' => get_query_var( 'bedroom' ) ) );
					?>
				</li>
				
				<li>
					<?php
						// Đường hẻm
						$strtwidths = array(
							''  => __( '- Đường/Hẻm rộng -', 'hrm' ),
							'1' => '1* mét',
							'2' => '2+ mét',
							'3' => '3+ mét',
							'4' => '4+ mét',
							'5' => '5+ mét',
							'6' => '6+ mét',
							'7' => '7+ mét',
							'8' => '8+ mét',
							'9' => '9+ mét',
							'10' => '10+ mét',
						);
						realty_dropdown( array( 'name' => 'strtwidth', 'id' => 'strtwidth', 'options' => $strtwidths, 'selected' => get_query_var( 'strtwidth' ) ) );
					?>
				</li>
				<li>
					<?php
						// Cầu thang
						$stair = array(
							''  => __( '- Pháp lý -', 'hrm' ),
							'Sổ đỏ' => 'Sổ đỏ',
							'Trích đo' => 'Trích đo',
						);
						realty_dropdown( array( 'name' => 'stair', 'id' => 'stair', 'options' => $stair, 'selected' => get_query_var( 'stair' ) ) );
					?>
				</li>
				<li>
					<?php
					realty_dropdown_terms(
						array(
							'show_option_none' => __( '- Hướng -', 'hrm' ),
							'taxonomy'         => 'quarter',
							'hide_empty'       => 0,
							'name'             => 'quarter',
							'id'               => 'quarter',
							'selected'         => get_query_var( 'quarter' ),
						)
					);
					?>
				</li>
				<li><label><input id="income" class="income" name="income" type="checkbox" /> <span>Có thu nhập từ BDS</span></label></li>
				<li><label><input id="interior" class="interior" name="interior" type="checkbox" /> <span>Có sẵn nội thất</span></label></li>
				<li><label><input id="elevator" class="elevator" name="elevator" type="checkbox" /> <span>Có thang máy</span></label></li>
				<li><label><input id="hemoto" class="hemoto" name="hemoto" type="checkbox" /> <span>Hẻm xe hơi?</span></label></li>
				
				<li><button id="btnSearch" type="submit"><i class="fa fa-search" aria-hidden="true"></i><?php _e( 'Tìm kiếm', 'hrm' ); ?></button></li>
			</ul>
			
		</div>
	</form>
</div>
