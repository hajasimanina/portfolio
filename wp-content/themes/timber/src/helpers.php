<?php

if ( ! function_exists( 'mp' ) ) {
	function mp( $message, $stop = true ) {
		echo '<pre>';
		print_r( $message );
		if ( $stop ) {
			die();
		}
		echo '</pre>';
	}
}

if ( ! function_exists( 'timber_array_divider_two' ) ) {
	function timber_array_divider( $array, $number = 2 ) {
		$data = array();
		if ( empty( $array ) ) {
			$data = array();
		}

		if ( count( $array ) == 1 ) {
			$data = $array;
		} else {
			$size_1 = count( $array );
			$size_2 = ceil( $size_1 / $number );
			switch ( $number ) {
				case 2:
					$data = array(
						array_slice( $array, 0, $size_2 ),
						array_slice( $array, $size_2 )
					);
					break;
				case 3:
					$size_3 = ceil( ( $size_1 - $size_2 ) / 2 );

					$data = array(
						array_slice( $array, 0, $size_2 ),
						array_slice( $array, $size_2, $size_3 ),
						array_slice( $array, $size_2 + $size_3 )
					);
					break;
			}
		}

		return $data;
	}
}