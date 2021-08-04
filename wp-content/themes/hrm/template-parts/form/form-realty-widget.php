<div class="realty-filter clearfix">
	<form action="<?php echo home_url('/tim-bat-dong-san'); ?>" method="GET">
		<input type="hidden" name="post_type" value="bat-dong-san">
		<div class="visible-fields fields">
			
			<ul class="option-select">
				<li><input id="s" class="key-search" name="key" type="text" placeholder="Nhập từ khóa, vd: Căn hộ vinhomes" value="<?php echo $_GET['key'] ?>"></li>
				<li>
					<select name="cate-realty" id="cate-realty">
						<option value="">-- Chọn loại BĐS --</option>
						<?php
						$args_ban = array(
							'child_of'   => 0,
							'parent'     => 0,
							'hide_empty' => 1,
						);
						$term_bans = get_terms( 'realty-sell' , $args_ban );
						foreach ($term_bans as $term_ban) { ?>
							<option value="b<?php echo $term_ban->term_id; ?>" <?php if($_GET['cate-realty'] == 'b'.$term_ban->term_id) echo 'selected="selected"'; ?>><?php echo $term_ban->name; ?> (<?php echo $term_ban->count; ?>)</option><?php
						}
						$term_thues = get_terms( 'realty-rent' , $args_thue );
						foreach ($term_thues as $term_thue) { ?>
							<option value="t<?php echo $term_thue->term_id; ?>" <?php if($_GET['cate-realty'] == 't'.$term_ban->term_id) echo 'selected="selected"'; ?>><?php echo $term_thue->name; ?> (<?php echo $term_thue->count; ?>)</option><?php
						}
						$term_transfers = get_terms( 'realty-transfer' , $args_thue );
						foreach ($term_transfers as $term_transfer) { ?>
							<option value="s<?php echo $term_transfer->term_id; ?>" <?php if($_GET['cate-realty'] == 's'.$term_ban->term_id) echo 'selected="selected"'; ?>><?php echo $term_transfer->name; ?> (<?php echo $term_transfer->count; ?>)</option><?php
						}
						?>
					</select>
				</li>
				<li>
					<select name="quick-city" id="city" class="quick-city-edit">
						<option value="">--Chọn tỉnh/ Thành--</option>
						<?php
						$tc_id = $_GET['quick-city'];
						$td_id = $_GET['quick-district'];
						$ta_id = $_GET['quick-ward'];
						$arg_ds = array(
							'child_of' => $tc_id,
							'hide_empty' => 0
						);
						$termds=  get_terms( 'city-realty' , $arg_ds );
						$arg_as = array(
							'child_of' => $td_id,
							'hide_empty' => 0
						);
						$termas=  get_terms( 'city-realty' , $arg_as );
						$args_city = array(
							'child_of'               => 0,
							'parent'                 => 0,
							'hide_empty'        => 0,
						);
						$term_citys = get_terms( 'city-realty' , $args_city );
						foreach ($term_citys as $term_city) { 
							if($term_city->term_id == $tc_id) {?>
								<option value="<?php echo $term_city->term_id; ?>" selected="selected"><?php echo $term_city->name; ?></option><?php
							} else { ?>
								<option value="<?php echo $term_city->term_id; ?>" ><?php echo $term_city->name; ?></option><?php
							}
						}
						?>
					</select>
				</li>
				<li>
					<select id="district" class="quick-district" name="quick-district" >
						<option value="">- Chọn Quận / huyện -</option>
						<?php
						foreach ($termds as $termd) {
							$cha_tad = $termd->parent;
							$term_cha_tad = get_term( $cha_tad, 'city-realty');
							if ($termd->parent != 0 && $term_cha_tad->parent == 0) {
								if ($td_id == $termd->term_id) {
									$optiond .= '<option value="'.$termd->term_id.'" selected="selected">';
									$optiond .= $termd->name;
									$optiond .= '</option>';
								} else {
									$optiond .= '<option value="'.$termd->term_id.'">';
									$optiond .= $termd->name;
									$optiond .= '</option>';
								}   
							}
						}
						echo $optiond;
						?>
					</select>
					<script>
						jQuery(document).ready(function($){
							<?php if ($_GET['quick-district']) { ?>
								setTimeout(function(){
									$("#district").val("<?php echo $_GET['quick-district'] ?>").trigger('change');
								}, 3000);
							<?php } ?>
							<?php if ($_GET['quick-ward']) { ?>
								setTimeout(function(){
									$("#ward").val("<?php echo $_GET['quick-ward'] ?>").trigger('change');
								}, 5000);
							<?php } ?>
						}); 
					</script>
				</li>
				<li>
					<select name="quick-ward" id="ward" class="quick-ward">
						<option value="">- Chọn phường / xã -</option>
						<?php
						foreach ($termas as $terma) {
							$cha_taa = $terma->parent;
							$term_cha_taa = get_term( $cha_taa, 'city-realty');
							if ($terma->parent != 0 && $term_cha_taa->parent != 0) {
								if ($ta_id == $terma->term_id) {
									$optiona .= '<option value="'.$terma->term_id.'" selected="selected">';
									$optiona .= $terma->name;
									$optiona .= '</option>';
								} else {
									$optiona .= '<option value="'.$terma->term_id.'">';
									$optiona .= $terma->name;
									$optiona .= '</option>';
								}   
							}
						}
						echo $optiona;
						?>
					</select>
				</li>
				<li><input id="s" class="key-search" name="ten-duong" type="text" value="<?php echo $_GET['ten-duong'] ?>" placeholder="<?php _e('Tên đường','hrm') ?>"></li>
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
							'selected'         => $_GET['price'] ,
						)
					); ?>

				</li>
			</ul>
			<ul id="bs-advance" class="hidecc option-select">
				<li><input id="s" class="key-search" name="width" type="number" value="<?php echo $_GET['width'] ?>" placeholder="<?php _e('Rộng','hrm') ?>"></li>
				<li><input id="s" class="key-search" name="long" type="number" value="<?php echo $_GET['long'] ?>" placeholder="<?php _e('Dài','hrm') ?>"></li>
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
					realty_dropdown( array( 'name' => 'area', 'id' => 'area', 'options' => $areas, 'selected' => $_GET['area'] ) );
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
					realty_dropdown( array( 'name' => 'sizeuse', 'id' => 'sizeuse', 'options' => $sizeuses, 'selected' => $_GET['sizeuse'] ) );
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
					realty_dropdown( array( 'name' => 'floor', 'id' => 'floor', 'options' => $floors, 'selected' => $_GET['floor'] ) );
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
					realty_dropdown( array( 'name' => 'bedroom', 'id' => 'bedroom', 'options' => $rooms, 'selected' => $_GET['bedroom'] ) );
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
					realty_dropdown( array( 'name' => 'strtwidth', 'id' => 'strtwidth', 'options' => $strtwidths, 'selected' => $_GET['strtwidth'] ) );
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
						realty_dropdown( array( 'name' => 'stair', 'id' => 'stair', 'options' => $stair, 'selected' => $_GET['stair'] ) );
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
				<li><label>
					<input id="income" class="income" name="income" <?php echo ($_GET['income'])? 'checked="checked" ' : '' ?>  type="checkbox" />
					 <span>Có thu nhập từ BDS</span></label></li>

				<li><label><input id="interior" class="interior" name="interior" <?php echo ($_GET['interior'])? 'checked="checked" ' : '' ?>  type="checkbox" /> <span>Có sẵn nội thất</span></label></li>
				<li><label><input id="elevator" class="elevator" name="elevator" <?php echo ($_GET['elevator'])? 'checked="checked" ' : '' ?>  type="checkbox" /> <span>Có thang máy</span></label></li>
				<li><label><input id="hemoto" class="hemoto" name="hemoto" <?php echo ($_GET['hemoto'])? 'checked="checked" ' : '' ?>  type="checkbox" /> <span>Hẻm xe hơi?</span></label></li>
				
			</ul>
			<div class="bs-action">
				<div class="bs-advance"><a id="hplAdvance" href="javascript:ShowBSAdvance();" >Tìm kiếm nâng cao</a></div>
				<div class="bs-search">
					<button id="btnSearch" type="submit"><i class="fa fa-search" aria-hidden="true"></i><?php _e( 'Tìm kiếm', 'hrm' ); ?></button>
				</div>
			</div>
		</div>
	</form>
</div>
