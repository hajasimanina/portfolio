<?php

namespace App\classes;

class PortfolioContactForm {
	public static $_instance = null;

	public function __construct() {

	}

	public function init() {
		add_action( 'wp_ajax_portfolio_submit_contact', array( $this, 'submit_contact' ) );
		add_action( 'wp_ajax_nopriv_portfolio_submit_contact', array( $this, 'submit_contact' ) );
	}

	public static function get_instance() {
		self::$_instance = new self();

		return self::$_instance;
	}

	public function submit_contact() {
		mp( $_POST );
		if ( wp_verify_nonce( 'contact_nance', 'portfolio_form_contact' ) ) {

		}
	}
}