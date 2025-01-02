<?php

namespace HWPPostsEventsInc;

class Tools
{
	/**
	 * Function to get post type
	 * @return bool|mixed|void
	 */
	public static function get_post_types() {
		return get_option( HWP_PE_FIELD_POST_TYPES, [] );
	}
}