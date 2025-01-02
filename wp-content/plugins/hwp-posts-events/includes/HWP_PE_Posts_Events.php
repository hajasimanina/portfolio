<?php

namespace HWPPostsEventsInc;

class HWP_PE_Posts_Events
{
	private static $_instance = null;

	/**
	 * Single instance of class HWP_Setting_Page (singleton)
	 * @return HWP_PE_Posts_Events|null
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Init plugin
	 */
	public function initialize() {
		// Register activation hook
		register_activation_hook( __FILE__, [ $this, 'on_activation' ] );

		// Load admin settings page
		$this->load_admin();

		// Schedule cron event
		add_action( 'hwp_pe_post_expiration_check', [ $this, 'check_post_expirations' ] );

		// Initialize notifications
		$this->load_notifications();

		// Charger la classe HWP_PE_Post_Meta_Data
		require_once HWP_PE_DIR_PATH . 'includes/admin/post-meta-data.php'; // Assurez-vous que le chemin est correct

		//Init post meta box
		$this->add_meta_box();
	}

	/**
	 *  Activation hook
	 */
	public function on_activation() {
		if ( ! wp_next_scheduled( 'hwp_pe_post_expiration_check' ) ) {
			wp_schedule_event( time(), 'daily', 'hwp_pe_post_expiration_check' );
		}
	}

	/**
	 *  Load admin settings
	 */
	private function load_admin() {
		require_once HWP_PE_DIR_PATH . 'includes/admin/settings-page.php';
		HWP_PE_Setting_Page::get_instance();
	}

	/**
	 * Load notifications
	 */
	private function load_notifications() {
		require_once HWP_PE_DIR_PATH . 'includes/notification/post-expiration-notifier.php';
		HWP_PE_Post_Expiration_Notifier::get_instance();
	}

	/**
	 * Check post expirations
	 */
	public function check_post_expirations() {
		$days_before_expiration = get_option( 'hwp_pe_posts_events_days_before', 1 );
		$posts_to_notify        = get_posts( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'date_query'  => [
				'after' => "+{$days_before_expiration} days",
			],
		] );

		if ( ! empty( $posts_to_notify ) ) {
			foreach ( $posts_to_notify as $post ) {
				do_action( 'hwp_pe_send_post_expiration_notification', $post );
			}
		}
	}

	/**
	 * Add meta box
	 */
	public function add_meta_box() {
		HWP_PE_Post_Meta_Data::get_instance();
	}
}