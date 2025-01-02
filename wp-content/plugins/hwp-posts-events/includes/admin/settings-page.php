<?php

namespace HWPPostsEventsInc;

class HWP_PE_Setting_Page
{
	private $settings_group = 'hwp_pe_posts_events_settings_group';
	private $settings_section = 'hwp_pe_posts_events_section';
	private static $_instance = null;

	/**
	 * HWP_Setting_Page constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	/**
	 * Single instance of class HWP_Setting_Page (singleton)
	 * @return HWP_PE_Setting_Page
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Add settings page
	 */
	public function add_settings_page() {
		add_menu_page(
			'HWP Posts Events',
			'HWP Posts Events',
			'manage_options',
			HWP_PE_SLUG,
			[ $this, 'render_settings_page' ],
			'dashicons-calendar',
			100
		);
	}

	/**
	 * Render settings page
	 */
	public function render_settings_page() {
		?>
        <div class="wrap">
            <h1><?php esc_html_e( 'HWP Posts Events Settings', HWP_PE_TEXT_DOMAIN ); ?></h1>
            <form method="post" action="options.php">
				<?php
				settings_fields( $this->settings_group );
				do_settings_sections( HWP_PE_SLUG );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	/**
	 * Register settings
	 */
	public function register_settings() {
		// Register settings
		register_setting( $this->settings_group, HWP_PE_FIELD_DAYS_BEFORE_EXPIRATION );
		register_setting( $this->settings_group, HWP_PE_FIELD_RUN_CRON_NOTIFY_DAY );
		register_setting( $this->settings_group, HWP_PE_FIELD_ENABLE_MAIL );
		register_setting( $this->settings_group, HWP_PE_FIELD_MAIL_SUBJECT );
		register_setting( $this->settings_group, HWP_PE_FIELD_MAIL_MESSAGE );
		register_setting( $this->settings_group, HWP_PE_FIELD_POST_TYPES );

		// Add settings section
		add_settings_section(
			$this->settings_section,
			__( 'Notification Settings', HWP_PE_TEXT_DOMAIN ),
			null,
			HWP_PE_SLUG
		);

		// Add fields
		add_settings_field(
			HWP_PE_FIELD_DAYS_BEFORE_EXPIRATION,
			__( 'Days Before Expiration', HWP_PE_TEXT_DOMAIN ),
			[ $this, 'render_days_before_field' ],
			HWP_PE_SLUG,
			$this->settings_section
		);

		// Add fields
		add_settings_field(
			HWP_PE_FIELD_RUN_CRON_NOTIFY_DAY,
			__( 'Run notification per day', HWP_PE_TEXT_DOMAIN ),
			[ $this, 'render_run_notification_field' ],
			HWP_PE_SLUG,
			$this->settings_section
		);

		add_settings_field(
			HWP_PE_FIELD_ENABLE_MAIL,
			__( 'Enable Email Notifications', HWP_PE_TEXT_DOMAIN ),
			[ $this, 'render_enable_email_field' ],
			HWP_PE_SLUG,
			$this->settings_section
		);

		add_settings_field(
			HWP_PE_FIELD_POST_TYPES,
			__( 'Post Types to Notify', HWP_PE_TEXT_DOMAIN ),
			[ $this, 'render_post_types_field' ],
			HWP_PE_SLUG,
			$this->settings_section
		);

		add_settings_field(
			HWP_PE_FIELD_MAIL_SUBJECT,
			__( 'Email subject', HWP_PE_TEXT_DOMAIN ),
			[ $this, 'render_email_subject_field' ],
			HWP_PE_SLUG,
			$this->settings_section
		);

		add_settings_field(
			HWP_PE_FIELD_MAIL_MESSAGE,
			__( 'Email Message', HWP_PE_TEXT_DOMAIN ),
			[ $this, 'render_email_message_field' ],
			HWP_PE_SLUG,
			$this->settings_section
		);
	}

	/**
	 * Render the field for days before expiration
	 */
	public function render_days_before_field() {
		$value = get_option( HWP_PE_FIELD_DAYS_BEFORE_EXPIRATION, 1 );
		hwp_pe_render_field( 'number', [
			'name'  => HWP_PE_FIELD_DAYS_BEFORE_EXPIRATION,
			'value' => esc_attr( $value )
		] );
	}

	/**
	 * Render the field for run notification per day
	 */
	public function render_run_notification_field() {
		$value = get_option( HWP_PE_FIELD_RUN_CRON_NOTIFY_DAY, 1 );
		hwp_pe_render_field( 'number', [
			'name'  => HWP_PE_FIELD_RUN_CRON_NOTIFY_DAY,
			'value' => esc_attr( $value )
		] );
	}

	/**
	 * Render the field for the email subject
	 */
	public function render_email_subject_field() {
		$value = get_option( HWP_PE_FIELD_MAIL_SUBJECT, 'Post Expiration Reminder' );
		hwp_pe_render_field( 'text', [
			'name'  => HWP_PE_FIELD_MAIL_SUBJECT,
			'value' => esc_attr( $value ),
			'attrs' => array(
				'width' => '200px'
			)
		] );
	}

	/**
	 * Render the field for enabling email notifications
	 */
	public function render_enable_email_field() {
		$value   = get_option( HWP_PE_FIELD_ENABLE_MAIL, 0 );
		$checked = $value ? true : false;
		hwp_pe_render_field( 'checkbox', [
			'name'    => HWP_PE_FIELD_ENABLE_MAIL,
			'value'   => 1,
			'checked' => $checked
		] );
	}

	/**
	 * Render the WYSIWYG field for the email message
	 */
	public function render_email_message_field() {
		$value = get_option( HWP_PE_FIELD_MAIL_MESSAGE, '' );
		hwp_pe_render_field( 'wysiwyg', [
			'name'  => HWP_PE_FIELD_MAIL_MESSAGE,
			'value' => $value,
		] );
	}

	/**
	 * Render the field for selecting post types
	 */
	public function render_post_types_field() {
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$selected   = get_option( HWP_PE_FIELD_POST_TYPES, [] );
		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				$checked = in_array( $post_type->name, (array) $selected, true );
				hwp_pe_render_field( 'checkbox', [
					'name'    => HWP_PE_FIELD_POST_TYPES . '[]',
					'value'   => esc_attr( $post_type->name ),
					'checked' => $checked,
					'label'   => esc_html( $post_type->labels->singular_name )
				] );
			}
		}
	}
}