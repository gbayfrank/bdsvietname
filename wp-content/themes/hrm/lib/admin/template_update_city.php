<?php
/**
 * Template name: Update data city
 */
global $hrm_options;
// if(!is_super_admin()) {
// 	wp_redirect( home_url() );
// }
get_header(); 
	$array_city = 'cc';
	foreach ($terms as $term) {
	    if ($term->parent == 0) {
	        $array_city = array(
	            'id' => $term->id,
	            'name' => $term->name,
	            'slug' => $term->slug,
	        );
	    }  
	}
	$file = home_url().'tinhthanh.js';
	// Open the file to get existing content
	$current = file_get_contents($file);
	// Append a new person to the file
	$current .= $array_city;
	// Write the contents back to the file
	file_put_contents($file, $current);
?>
<script>
	alert('Cập nhật thành công');
</script>
<?php
get_footer();
