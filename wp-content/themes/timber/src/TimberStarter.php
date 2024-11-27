<?php

namespace src;

class TimberStarter {
	/**
	 * @var null
	 */
	private static $instance = null;

	/**
	 * TimberStarter constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'wp_footer', array( $this, 'disable_inspection_tools' ) );
	}

	/**
	 * Function use to stop clone in this class
	 */
	public function __clone() {
	}

	/**
	 *
	 */
	public function __wakeup() {
	}

	/**
	 * @return TimberStarter|null
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Function callback to setup theme timber
	 */
	public function setup_theme() {
		add_theme_support( 'menus' );
		remove_theme_support( 'editor' );
		remove_post_type_support( 'page', 'editor' );
	}

	public function enqueue_assets() {
		// CSS files
		wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/assets/css/font-awesome.min.css', array(), null, 'all' );
		wp_enqueue_style( 'flaticon', get_stylesheet_directory_uri() . '/assets/css/flaticon.css', array(), null, 'all' );
		wp_enqueue_style( 'animate', get_stylesheet_directory_uri() . '/assets/css/animate.css', array(), null, 'all' );
		wp_enqueue_style( 'owl-carousel', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css', array(), null, 'all' );
		wp_enqueue_style( 'owl-theme-default', get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.min.css', array(), null, 'all' );
		wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', array(), null, 'all' );
		wp_enqueue_style( 'bootsnav', get_stylesheet_directory_uri() . '/assets/css/bootsnav.css', array(), null, 'all' );
		wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), null, 'all' );
		wp_enqueue_style( 'responsive', get_stylesheet_directory_uri() . '/assets/css/responsive.css', array(), null, 'all' );
		if ( ! is_admin() ) {
			wp_enqueue_style( 'dashicons' );
		}
		// JS files
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'modernizr.min', get_stylesheet_directory_uri() . '/assets/js/modernizr.min.js', array(), null, true );
		wp_enqueue_script( 'bootstrap.min', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', array(), null, true );
		wp_enqueue_script( 'bootsnav', get_stylesheet_directory_uri() . '/assets/js/bootsnav.js', array(), null, true );
		wp_enqueue_script( 'jquery.sticky', get_stylesheet_directory_uri() . '/assets/js/jquery.sticky.js', array(), null, true );
		wp_enqueue_script( 'progressbar', get_stylesheet_directory_uri() . '/assets/js/progressbar.js', array(), null, true );
		wp_enqueue_script( 'jquery.appear', get_stylesheet_directory_uri() . '/assets/js/jquery.appear.js', array(), null, true );
		wp_enqueue_script( 'owl.carousel.min', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, true );
		wp_enqueue_script( 'jquery.easing.min', get_stylesheet_directory_uri() . '/assets/js/jquery.easing.min.js', array(), null, true );
		wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), null, true );
		wp_enqueue_script( 'portfolio-contact-form', get_stylesheet_directory_uri() . '/assets/js/contact-form.js', array( 'jquery' ), null, true );
		wp_localize_script( 'portfolio-contact-form', 'object_form', array(
			'settings' => array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' )
			)
		) );
	}

	public static function disable_inspection_tools() {
		echo "
		    <script>
		        // Bloquer le clic droit
		        document.addEventListener('contextmenu', function(e) {
		            e.preventDefault();
		        });
		
		        // Bloquer les raccourcis clavier spécifiques
		        document.addEventListener('keydown', function(e) {
		            if (e.keyCode == 123 || // F12
		                (e.ctrlKey && e.shiftKey && e.keyCode == 73) || // Ctrl+Shift+I
		                (e.ctrlKey && e.shiftKey && e.keyCode == 74) || // Ctrl+Shift+J
		                (e.ctrlKey && e.keyCode == 85) // Ctrl+U (view source)
		            ) {
		                e.preventDefault();
		            }
		        });
		    </script>
    	";
	}
}