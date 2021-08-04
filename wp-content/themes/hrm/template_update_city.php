<?php
/**
 * Template name: Update data city
 */
global $hrm_options;
if(!is_super_admin()) {
	wp_redirect( home_url() );
}
get_header(); 
	// $array_citys = '';
	$args_ban = array(
        'child_of'               => 0,
        'parent'                 => 0,
        'hide_empty'        => 0,
    );
	$terms=  get_terms( 'city-realty' , $args_ban );
	foreach ($terms as $term) {
	    if ($term->parent == 0) {
	    	$term_city = $term->term_id;
	    	$array_city = array(
	            'id' => $term_city,
	            'name' => $term->name,
	            'slug' => $term->slug,
	            'districts' => array()
	        );
	        $arg_districts = array(
	            'child_of' => $term_city,
	            'hide_empty' => 0
	        );
	        $term_cons=  get_terms( 'city-realty' , $arg_districts );
	        foreach ($term_cons as $term_con) {
	        	$term_cha_cha = get_term( $term_con->parent, 'city-realty');
	        	if ($term_city != 0 && $term_cha_cha->parent == 0) {
	        		$array_district = array(
	        			'id' => $term_con->term_id,
			            'name' => $term_con->name,
			            'slug' => $term_con->slug,
			            'ward' => array()
	        		);
	        		$arg_wards = array(
			            'child_of' => $term_con->term_id,
			            'hide_empty' => 0
			        );
			        $term_chaus = get_terms( 'city-realty' , $arg_wards );
			        foreach ($term_chaus as $term_chau) {
			        	$array_district['ward'][] = array(
		        			'id' => $term_chau->term_id,
				            'name' => $term_chau->name,
				            'slug' => $term_chau->slug,
		        		);
			        }
	        		$array_city['districts'][] = $array_district;
	        	}
	        }
	        $array_citys[] = $array_city;
	    }  
	}
	$array_citys = json_encode($array_citys);
	$cc = 'var citiescc ='.$array_citys;
	$file = './cnd/tinhthanh.js';
	// Write the contents back to the file
	file_put_contents($file, $cc);
	// $array_citys = '';
	$args_banc = array(
        'child_of'               => 0,
        'parent'                 => 0,
        'hide_empty'        => 0,
    );
	$termsc=  get_terms( 'city-project' , $args_banc );
	foreach ($termsc as $termc) {
	    if ($termc->parent == 0) {
	    	$term_cityc = $termc->term_id;
	    	$array_cityc = array(
	            'id' => $term_cityc,
	            'name' => $termc->name,
	            'slug' => $termc->slug,
	            'districts' => array()
	        );
	        $arg_districtsc = array(
	            'child_of' => $term_cityc,
	            'hide_empty' => 0
	        );
	        $term_consc=  get_terms( 'city-project' , $arg_districtsc );
	        foreach ($term_consc as $term_conc) {
	        	$term_cha_chac = get_term( $term_conc->parent, 'city-project');
	        	if ($term_cityc != 0 && $term_cha_chac->parent == 0) {
	        		$array_districtc = array(
	        			'id' => $term_conc->term_id,
			            'name' => $term_conc->name,
			            'slug' => $term_conc->slug,
			            'ward' => array()
	        		);
	        		$arg_wardsc = array(
			            'child_of' => $term_conc->term_id,
			            'hide_empty' => 0
			        );
			        $term_chausc = get_terms( 'city-project' , $arg_wardsc );
			        foreach ($term_chausc as $term_chauc) {
			        	$array_districtc['ward'][] = array(
		        			'id' => $term_chauc->term_id,
				            'name' => $term_chauc->name,
				            'slug' => $term_chauc->slug,
		        		);
			        }
	        		$array_cityc['districts'][] = $array_districtc;
	        	}
	        }
	        $array_citysc[] = $array_cityc;
	    }  
	}
	$array_citysc = json_encode($array_citysc);

	$ccc = 'var citiesccc ='.$array_citysc;
	$filec = './cnd/tinhthanhp.js';
	// Write the contents back to the file
	file_put_contents($filec, $ccc);
?>
<script>
	alert('Cập nhật thành công');
</script>
<?php
get_footer();
