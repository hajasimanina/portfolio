<?php

namespace HWPPostsEventsInc;


class HWP_Post_Expiration_Notifier
{
	public function __construct() {
		add_action( 'hwp_send_post_expiration_notification', [ $this, 'send_notification_email' ] );
	}

	// Send notification email
	public function send_notification_email( $post ) {
		$days_before_expiration    = get_option( 'hwp_posts_events_days_before', 1 );
		$expiration_date           = strtotime( $post->post_date . ' + ' . $days_before_expiration . ' days' );
		$expiration_date_formatted = date( 'F j, Y', $expiration_date );

		$subject = sprintf( __( 'Post Expiration Reminder: %s', 'hwp-posts-events' ), $post->post_title );
		$message = sprintf( __( 'The post "%s" will expire on %s.', 'hwp-posts-events' ), $post->post_title, $expiration_date_formatted );

		wp_mail( get_option( 'admin_email' ), $subject, $message );
	}
}
