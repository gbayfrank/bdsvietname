<?php  
function realty_dropdown_terms( $args = array() )
{
	$defaults = array(
		'show_option_none' => '',
		'show_option_all'  => '',
		'taxonomy'         => 'category',
		'hide_empty'       => 0,
		'name'             => 'category',
		'id'               => 'category',
		'selected'         => '',
		'value'            => 'slug',
		'parent' 		   => 0,
		'order'            => 'asc',
		'orderby'          => 'name',
		'echo'             => true,
	);

	$args = wp_parse_args( $args, $defaults );
	$terms = get_terms( 
		$args['taxonomy'], 
		array( 
			'hide_empty' => $args['hide_empty'],
			'order'      => $args['order'],
			'orderby'    => $args['orderby'],
		) 
	);

	$output = sprintf( '<select name="%s" id="%s">', $args['name'], $args['id'] );

	if ( ! empty( $args['show_option_none'] ) )
		$output .= sprintf( '<option value="">%s</option>', $args['show_option_none'] );

	if ( ! empty( $args['show_option_all'] ) )
		$output .= sprintf( '<option value="">%s</option>', $args['show_option_all'] );

	if ( ! is_wp_error( $terms ) )
	{
		foreach( $terms as $term )
		{
			if ( 'slug' == $args['value'] )
			{
				$selected = selected( $term->slug, $args['selected'], false );
				$output .= sprintf( '<option value="%s" %s>%s</option>', $term->slug, $selected, $term->name );
			}
			else
			{
				$selected = selected( $term->term_id, $args['selected'], false );
				$output .= sprintf( '<option value="%s" %s>%s</option>', $term->term_id, $selected, $term->name );
			}
		}
	}

	$output .= '</select>';

	if ( ! $args['echo'] )
		return $output;

	echo $output;
}
function realty_dropdown( $args = array() )
{
	$defaults = array(
		'name'     => '',
		'id'       => '',
		'selected' => '',
		'echo'     => true,
		'options'  => array(),
	);
	$args = wp_parse_args( $args, $defaults );

	$output = sprintf( '<select name="%s" id="%s">', $args['name'], $args['id'] );

	foreach( (array) $args['options'] as $value => $label )
	{
		$selected = selected( $value, $args['selected'], false );
		$output .= sprintf( '<option value="%s" %s>%s</option>', $value, $selected, $label );
	}

	$output .= '</select>';

	if ( ! $args['echo'] )
		return $output;

	echo $output;
}
?>