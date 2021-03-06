<?php
/*
*/
class HRM_Widget_Recent_Posts extends WP_Widget
{
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor
	 *
	 * @return HRM_Widget_Recent_Posts
	 */
	function __construct()
	{
		$this->defaults = array(
			'title'         => '',
			'limit'         => 5,
			'excerpt'       => 0,
			'length'        => 10,
			'thumb'         => 1,
			'thumb_default' => 'http://placehold.it/80x80',
			'cat'           => '',
			'date'          => 1,
			'date_format'   => 'd/m/Y',
		);

		parent::__construct(
			'hrm-recent-posts-widget',
			__( '[HRM] Recent Posts', 'hrm' ),
			array(
				'classname'   => 'hrm-recent-posts-widget',
				'description' => __( 'Hiển thị bài viết theo chuyên mục.', 'hrm' )
			)
		);
	}

	/**
	 * Display widget
	 *
	 * @param array $args     Sidebar configuration
	 * @param array $instance Widget settings
	 *
	 * @return void
	 */
	function widget( $args, $instance )
	{
		$instance = wp_parse_args( $instance, $this->defaults );
		extract( $instance );

		$query_args = array(
			'posts_per_page'      => $limit,
			'post_status'         => 'publish',
			'post_type'           => 'post',
			'ignore_sticky_posts' => true,
		);
		if ( ! empty( $cat ) && is_array( $cat ) )
			$query_args['category__in'] = $cat;

		$query = new WP_Query( $query_args );

		if ( ! $query->have_posts() )
			return;

		extract( $args );

		echo $before_widget;

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
			echo $before_title . $title . $after_title; ?>
		<ul class="list-post-ct">
			<?php while ( $query->have_posts() ) : $query->the_post();
			$class = $thumb ? '' : 'hrm-list';
			?>
			<li class="hrm-recent-post <?php echo $class; ?>">
				<?php
				if ( $thumb )
				{
					if ( has_post_thumbnail()) {
						the_post_thumbnail('recent-thumbnail', array('class' => 'lazy'));
					} else {
						echo '<img src="'.$thumb_default.'" />';
					}
				}
				?>
				<div class="hrm-text">
					<a class="hrm-title" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'hrm' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					<div class="date-detail">
						<?php
							if ( $date )
								echo '<i class="fa fa-calendar"></i><time class="hrm-date" datetime="' . get_the_time( 'c' ) . '">' . esc_html( get_the_time( $date_format ) ) . '</time>';
							if ( $excerpt )
							{
								echo '<div class="hrm-excerpt">' . wp_trim_words( get_the_content(), $length, '...') . '</div>';
							}
						?>
					</div>
				</div>
			</li>
			<?php
			endwhile; ?>
		</ul>
		<?php wp_reset_postdata();

		echo $after_widget;

	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New widget settings
	 * @param array $old_instance Old widget settings
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance )
	{
		$instance                  = $old_instance;
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['limit']         = (int) ( $new_instance['limit'] );
		$instance['cat']           = array_filter( $new_instance['cat'] );
		$instance['thumb']         = ! empty( $new_instance['thumb'] );
		$instance['thumb_default'] = $new_instance['thumb_default'];

		$instance['date']          = ! empty( $new_instance['date'] );
		$instance['date_format']   = strip_tags( $new_instance['date_format'] );
		$instance['excerpt']       = ! empty( $new_instance['excerpt'] );
		$instance['length']        = (int) ( $new_instance['length'] );

		return $instance;
	}

	/**
	 * Display widget settings
	 *
	 * @param array $instance Widget settings
	 *
	 * @return void
	 */
	function form( $instance )
	{
		$instance = wp_parse_args( $instance, $this->defaults );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'hrm' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $instance['title']; ?>">
		</p>

		<div style="width: 280px; float: left; margin-right: 10px;">
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" size="2" value="<?php echo $instance['limit']; ?>">
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Number Of Posts', 'hrm' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php _e( 'Select Category: ', 'hrm' ); ?></label>
				<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>[]">
					<option value=""<?php selected( empty( $instance['cat'] ) ); ?>><?php _e( 'All', 'hrm' ); ?></option>
					<?php
					$categories = get_terms( 'category' );
					foreach ( $categories as $category )
					{
						printf(
							'<option value="%s"%s>%s</option>',
							$category->term_id,
							selected( in_array( $category->term_id, (array) $instance['cat'] ) ),
							$category->name
						);
					}
					?>
				</select>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['thumb'] ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>"><?php _e( 'Show Thumbnail', 'hrm' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>"><?php _e( 'Default Thumbnail', 'hrm' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_default' ) ); ?>" value="<?php echo $instance['thumb_default']; ?>">

			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['date'] ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php _e( 'Show Date', 'hrm' ); ?></label>
			</p>
			<p>
				<input size="6" id="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_format' ) ); ?>" type="text" value="<?php echo $instance['date_format']; ?>">
				<label for="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>"><?php _e( 'Date Format', 'hrm' ); ?></label>
				<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">[?]</a>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['excerpt'] ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"><?php _e( 'Show Excerpt', 'hrm' ); ?></label>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="text" size="2" value="<?php echo $instance['length']; ?>">
				<label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>"><?php _e( 'Excerpt Length (words)', 'hrm' ); ?></label>
			</p>
		</div>

		<div style="clear: both;"></div>
		<?php
	}

}
