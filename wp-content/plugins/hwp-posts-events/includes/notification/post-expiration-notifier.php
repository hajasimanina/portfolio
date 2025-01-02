<?php

namespace HWPPostsEventsInc;


class HWP_Post_Expiration_Notifier
{
	/**
	 * @var null
	 */
	private static $_instance = null;

	public function __construct() {
		add_action( 'hwp_pe_send_post_expiration_notification', [ $this, 'send_notification_email' ] );
	}

	/**
	 * Single instance of class HWP_Setting_Page (singleton)
	 * @return HWP_Post_Expiration_Notifier|null
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	// Send notification email
	public function send_notification_email( $post ) {
		$days_before_expiration    = get_option( 'hwp_pe_posts_events_days_before', 1 );
		$expiration_date           = strtotime( $post->post_date . ' + ' . $days_before_expiration . ' days' );
		$expiration_date_formatted = date( 'F j, Y', $expiration_date );

		$subject = sprintf( __( 'Post Expiration Reminder: %s', HWP_PE_TEXT_DOMAIN), $post->post_title );
		$message = sprintf( __( 'The post "%s" will expire on %s.', HWP_PE_TEXT_DOMAIN), $post->post_title, $expiration_date_formatted );

		wp_mail( get_option( 'admin_email' ), $subject, $message );
	}
}
