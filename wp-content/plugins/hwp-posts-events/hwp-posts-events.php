<?php
/**
 * Plugin Name: HWP Posts Events
 * Description: Manage notifications for post expiration.
 * Version: 1.0.0
 * Author: Hajasimanina RAMANANJARASOA
 * Author URI: https://hajasimanina.great-site.net/
 */


use HWPPostsEventsInc\HWP_Posts_Events;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// Initialize the plugin
function hwp_pe_posts_events_init() {
	$plugin = new HWP_Posts_Events();
	$plugin->initialize();
}

add_action( 'plugins_loaded', 'hwp_pe_posts_events_init' );