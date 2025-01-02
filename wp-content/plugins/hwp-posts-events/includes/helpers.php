<?php
if ( ! function_exists( 'mp' ) ) {
	function mp( $msg, $stop = true ) {
		echo '<pre>';
		print_r( $msg );
		echo '</pre>';
		if ( $stop ) {
			die();
		}
	}
}