<?php

namespace HWPPostsEventsInc;

class HWP_Setting_Pape
{
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	// Add settings page
	public function add_settings_page() {
		add_menu_page(
			'HWP Posts Events',
			'HWP Posts Events',
			'manage_options',
			'hwp_posts_events',
			[ $this, 'render_settings_page' ],
			'dashicons-calendar',
			100
		);
	}

	// Render settings page
	public function render_settings_page() {
		?>
        <div class="wrap">
            <h1><?php esc_html_e( 'HWP Posts Events Settings', 'hwp-posts-events' ); ?></h1>
            <form method="post" action="options.php">
				<?php
				settings_fields( 'hwp_posts_events_settings_group' );
				do_settings_sections( 'hwp_posts_events' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	// Register settings
	public function register_settings() {
		register_setting( 'hwp_posts_events_settings_group', 'hwp_posts_events_days_before' );
		add_settings_section( 'hwp_posts_events_section', '', null, 'hwp_posts_events' );

		add_settings_field(
			'hwp_posts_events_days_before',
			__( 'Days Before Expiration', 'hwp-posts-events' ),
			[ $this, 'render_days_before_field' ],
			'hwp_posts_events',
			'hwp_posts_events_section'
		);
	}

	// Render the field for days before expiration
	public function render_days_before_field() {
		$value = get_option( 'hwp_posts_events_days_before', 1 );
		echo '<input type="number" name="hwp_posts_events_days_before" value="' . esc_attr( $value ) . '" min="1" />';
	}
}