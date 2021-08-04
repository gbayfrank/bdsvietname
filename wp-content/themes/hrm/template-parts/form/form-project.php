<div class="realty-filter clearfix">
    <?php $args = array(
        'post_type'  => 'page',
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'tpl-result-project.php'
    );
   $pages = get_pages( $args );
   $link_p = get_permalink( $pages[0] ); ?>
    <form action="<?php //echo home_url('/tim-du-an'); ?>" method="GET">
		<div class="visible-fields fields">
            <div class="col-md-8">
			<input id="s" class="key-search" name="s" type="text" placeholder="<?php _e('Nhập từ khóa, vd: Tổ hợp đa năng số 7 Trần Phú','hrm'); ?>">
            <input type="hidden" name="post_type" value="project">
            </div>
<?php /* ?>
            <ul class="option-select">
                <li>
                    <?php
                        realty_dropdown_terms(
                            array(
                                'show_option_none' => __( '- Chọn loại dự án -', 'hrm' ),
                                'taxonomy'         => 'project_cat',
                                'hide_empty'       => 0,
                                'name'             => 'project_cat',
                                'id'               => 'project_cat',
                                'selected'         => get_query_var( 'project_cat' ),
                            )
                        );
                    ?>
                </li>
                <li>
                    <select name="quick-city" class="quick-cityp" id="quick-city-project">
                        <option value=""><?php _e('--Chọn tỉnh/ Thành--','hrm'); ?></option>   
                    </select>
                </li>

                <li>
                    <select name="quick-district" class="quick-districtp" id="quick-district-project">
                        <option value=""><?php _e('-Chọn quận huyện -','hrm'); ?></option>
                    </select>
                </li>
                <li>
                    <select name="quick-ward" class="quick-wardp" id="quick-ward-project">
                        <option value=""><?php _e('-Chọn Phường/Xã -','hrm'); ?></option>
                    </select>
                </li>
            </ul>
<?php */ ?>
			<button id="btnSearch" class="col-md-4" type="submit"><i class="fa fa-search" aria-hidden="true"></i><?php _e( 'Tìm kiếm', 'hrm' ); ?></button>

		</div>
	</form>
</div>