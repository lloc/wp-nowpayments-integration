<?php

namespace lloc\Nowpayments;

class Widget extends \WP_Widget {

	public const ID_BASE = 'nowpayments_widget';

	/**
	 * @codeCoverageIgnore
	 */
	public function __construct() {
		parent::__construct(
			self::ID_BASE,
			__( 'lloc/nowpayments-widget-block', 'wp-nowpayments-integration' )
		);
	}

	/**
	 * Output of the widget in the frontend
	 *
	 * @param mixed $args
	 * @param mixed $instance
	 */
	public function widget( $args, $instance ): void {
		$args = wp_parse_args(
			$args,
			[
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			]
		);

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $instance['title'] ?? '', $instance, self::ID_BASE );

		if ( $title ) {
			$title = $args['before_title'] . esc_attr( $title ) . $args['after_title'];
		}

		$content = __( "Good news, everyone! There's a report on TV with some very bad news!", 'wp-nowpayments-integration' );

		echo $args['before_widget'], $title, $content, $args['after_widget'];
	}

	/**
	 * Update widget in the backend
	 *
	 * @param mixed $new_instance
	 * @param mixed $old_instance
	 *
	 * @return string[]
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( isset( $new_instance['title'] ) ) {
			$instance['title'] = strip_tags( $new_instance['title'] );
		}

		return $instance;
	}

	/**
	 * Display an input-form in the backend
	 *
	 * @param mixed $instance
	 *
	 * @return string
	 */
	public function form( $instance ) {
		printf(
			'<p><label for="%1$s">%2$s:</label> <input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" /></p>',
			$this->get_field_id( 'title' ),
			__( 'Title', 'wp-nowpayments-integration' ),
			$this->get_field_name( 'title' ),
			( isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '' )
		);

		return 'noform';
	}

}