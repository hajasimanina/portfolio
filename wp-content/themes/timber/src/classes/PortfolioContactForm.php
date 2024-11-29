<?php

namespace App\classes;

class PortfolioContactForm
{
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

	public static function submit_contact() {
		$submitForm = (object) $_POST;
		$data       = array();
		if ( isset( $submitForm->action ) && ! empty( $submitForm->action ) && $submitForm->action == 'portfolio_submit_contact'
		     && isset( $submitForm->formData ) && ! empty( $submitForm->formData ) ) {
			foreach ( $submitForm->formData as $item ) {
				if ( isset( $item['name'] ) ) {
					switch ( $item['name'] ) {
						case 'contact_username':
							$data['name'] = self::validate_text( $item['value'] );
							break;
						case 'contact_email':
							$data['email'] = filter_var( $item['value'], FILTER_VALIDATE_EMAIL );
							break;
						case 'contact_subject':
							$data['subject'] = self::validate_text( $item['value'] );
							break;
						case 'contact_message':
							$data['message'] = nl2br( self::validate_text( $item['value'] ) );
							break;
					}
				}
			}

			if ( ! empty( $data ) && isset( $data['name'] ) && isset( $data['email'] ) && isset( $data['subject'] ) && isset( $data['message'] ) ) {
				foreach ( array( 'admin', 'user' ) as $type ) {
					$message = self::format_mail_message( $data, $type );
					$headers = [
						"Content-Type: text/html; charset=UTF-8",
					];
					if ( $type == 'user' ) {
						$email_to = $data['email'];
					} else {
						$email_to = get_field( 'admin_mail_address', 'option' );
					}
					if ( ! is_null( $message ) && ! empty( $email_to ) ) {
						$sent = wp_mail( $email_to, $data['subject'], $message, $headers );
						if ( 'user' == $type ) {
							if ( $sent ) {
								wp_send_json( array( 'response' => __( 'Votre message est bien envoyé avec succès.', TIMBER_TEXT_DOMAIN ) ) );
							} else {
								wp_send_json( array( 'response' => __( 'Votre message n\'est pas envoyé. Veuillez essayer une fois.', TIMBER_TEXT_DOMAIN ) ) );
							}
						}
					} else {
						wp_send_json( array( 'response' => __( 'Message administrer en dans la page d\'option est vide.', TIMBER_TEXT_DOMAIN ) ) );
					}
				}
			} else {
				wp_send_json( array( 'response' => __( 'Il y a des champs vides ou incorrects dans votre formulaire.', TIMBER_TEXT_DOMAIN ) ) );
			}
		}
	}

	/**
	 * @param $text
	 *
	 * @return string
	 */
	private static function validate_text( $text ) {
		$text = htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' );

		$text = strip_tags( $text, '<br>' );

		$text = trim( $text );

		return $text;
	}

	/**
	 * @param $data
	 * @param $user_type //admin, user
	 *
	 * @return string
	 */
	private static function format_mail_message( $data, $user_type ) {
		$message = null;
		if ( class_exists( 'Acf' ) ) {
			if ( $user_type == 'admin' ) {
				$message = get_field( 'mail_admin_message', 'option' );
			} else {
				$message = get_field( 'mail_user_message', 'option' );
			}

			$message = preg_replace_callback( '/\[(.*?)\]/', function ( $matches ) use ( $data ) {
				$key = $matches[1]; // Extraire le contenu entre les crochets

				return $data[ $key ] ? $data[ $key ] : $matches[0]; // Remplacer si la clé existe, sinon garder le jeton
			}, $message );

		}

		return $message;
	}
}