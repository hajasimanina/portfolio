<?php

namespace HWPPostsEventsInc;

use WP_Post;

class HWP_PE_Post_Meta_Data
{
	/**
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * Constructeur : Ajoute les hooks nécessaires.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_expiration_date_metabox' ] );
		add_action( 'save_post', [ $this, 'save_expiration_date' ] );
	}

	/**
	 * Single instance on this class
	 * @return HWP_PE_Post_Meta_Data|null
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Ajoute la métabox de date d'expiration.
	 */
	public function add_expiration_date_metabox() {
		$_post_types = Tools::get_post_types();
		if ( ! empty( $_post_types ) ) {
			foreach ( $_post_types as $post_type ) {
				add_meta_box(
					HWP_PE_FIELD_EXPIRATION_DATE,                // ID unique
					__( 'Expiration Date', HWP_PE_TEXT_DOMAIN ), // Titre de la métabox
					[ $this, 'render_expiration_date_metabox' ], // Fonction de rendu
					$post_type,                               // Type de contenu (post, page, custom post type)
					'side',                               // Position : side, normal, advanced
					'default'                             // Priorité : high, low, default
				);
			}
		}
	}

	/**
	 * Rend la méta box pour le champ de date.
	 *
	 * @param WP_Post $post L'objet du post actuel.
	 */
	public function render_expiration_date_metabox( $post ) {
		// Récupérer la valeur actuelle du champ, s'il existe
		$expiration_date = get_post_meta( $post->ID, '_' . HWP_PE_FIELD_EXPIRATION_DATE, true );

		// Ajouter un nonce pour la sécurité
		wp_nonce_field( HWP_PE_FIELD_EXPIRATION_NONCE_ACTION, HWP_PE_FIELD_EXPIRATION_NONCE_NAME );

		// Rendu du champ de date
		hwp_pe_render_field( 'datetime-local', [
			'name'  => HWP_PE_FIELD_EXPIRATION_DATE,
			'value' => esc_attr( $expiration_date ),
		] );
	}

	/**
	 * Sauvegarde la valeur du champ de date d'expiration.
	 *
	 * @param int $post_id ID du post en cours de sauvegarde.
	 */
	public function save_expiration_date( $post_id ) {
		// Vérifier le nonce pour la sécurité
		if ( ! isset( $_POST[ HWP_PE_FIELD_EXPIRATION_NONCE_NAME ] ) ||
		     ! wp_verify_nonce( $_POST[ HWP_PE_FIELD_EXPIRATION_NONCE_NAME ], HWP_PE_FIELD_EXPIRATION_NONCE_ACTION ) ) {
			return;
		}

		// Vérifier si l'utilisateur a l'autorisation de modifier le post
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Vérifier si le champ est défini
		if ( isset( $_POST[ HWP_PE_FIELD_EXPIRATION_DATE ] ) ) {
			$expiration_date = sanitize_text_field( $_POST[ HWP_PE_FIELD_EXPIRATION_DATE ] );

			// Mettre à jour la valeur du champ dans la base de données
			update_post_meta( $post_id, '_' . HWP_PE_FIELD_EXPIRATION_DATE, $expiration_date );
		} else {
			// Supprimer la valeur si le champ est vide
			delete_post_meta( $post_id, '_' . HWP_PE_FIELD_EXPIRATION_DATE );
		}
	}
}