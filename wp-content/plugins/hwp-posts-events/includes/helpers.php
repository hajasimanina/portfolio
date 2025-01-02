<?php
if ( ! function_exists( 'mp' ) ) {
	function mp( $msg, $stop = true ) {
		echo '<pre>';
		print_r( $msg );
		echo '</pre>';
		if ( $stop ) {
			die();
		}
	}
}

if ( ! function_exists( 'hwp_pe_render_field' ) ) {
	/**
	 * Generic function to render fields
	 *
	 * @param string $type Type of the field (e.g., text, checkbox, number, wysiwyg, select, etc.).
	 * @param array $args Attributes and configuration for the field.
	 */
	function hwp_pe_render_field( $type, $args ) {
		$defaults = [
			'name'    => '',
			'value'   => '',
			'options' => [], // For select or checkbox group
			'label'   => '', // Label for the field
			'attrs'   => [], // Additional HTML attributes as key-value pairs
		];
		$args     = wp_parse_args( $args, $defaults );

		// Extract attributes
		$name    = esc_attr( $args['name'] );
		$value   = esc_attr( $args['value'] );
		$checked = isset( $args['checked'] ) ? $args['checked'] : false;
		$attrs   = '';

		// Generate additional attributes
		foreach ( $args['attrs'] as $key => $attr_value ) {
			$attrs .= esc_attr( $key ) . '="' . esc_attr( $attr_value ) . '" ';
		}

		// Render field based on type
		switch ( $type ) {
			case 'text':
			case 'number':
			case 'datetime-local':
				echo '<input type="' . esc_attr( $type ) . '" name="' . $name . '" value="' . $value . '" ' . $attrs . '/>';
				break;

			case 'checkbox':
				echo '<input type="checkbox" name="' . $name . '" value="' . $value . '" ' . checked( $checked, 1, false ) . ' ' . $attrs . '/>';
				break;

			case 'select':
				echo '<select name="' . $name . '" ' . $attrs . '>';
				foreach ( $args['options'] as $option_value => $option_label ) {
					echo '<option value="' . esc_attr( $option_value ) . '" ' . selected( $value, $option_value, false ) . '>';
					echo esc_html( $option_label );
					echo '</option>';
				}
				echo '</select>';
				break;

			case 'wysiwyg':
				wp_editor( $value, sanitize_title( $name ), [
					'textarea_name' => $name,
					'media_buttons' => false,
					'teeny'         => true,
					'editor_height' => '200'
				] );
				break;

			default:
				echo '<p>' . esc_html__( 'Unsupported field type: ', HWP_PE_TEXT_DOMAIN ) . esc_html( $type ) . '</p>';
		}

		// Add label if provided
		if ( ! empty( $args['label'] ) ) {
			echo '<label for="' . $name . '">' . esc_html( $args['label'] ) . '</label><br>';
		}
	}
}