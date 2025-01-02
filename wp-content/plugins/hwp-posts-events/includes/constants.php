<?php
define( 'HWP_PE_DIR_PATH', plugin_dir_path( dirname( __FILE__ ) ) );
define( 'HWP_PE_DIR_URL', plugin_dir_url( dirname( __FILE__ ) ) );
define( 'HWP_PE_TEXT_DOMAIN', 'hwp-pe-posts-events' );
define( 'HWP_PE_SLUG', 'hwp_pe_posts_events' );

//Setting fields
define( 'HWP_PE_FIELD_DAYS_BEFORE_EXPIRATION', 'hwp_pe_posts_events_days_before' );
define( 'HWP_PE_FIELD_RUN_CRON_NOTIFY_DAY', 'hwp_pe_posts_events_cron_notify_per_day' );
define( 'HWP_PE_FIELD_ENABLE_MAIL', 'hwp_pe_posts_events_enable_email' );
define( 'HWP_PE_FIELD_POST_TYPES', 'hwp_pe_posts_events_post_types' );
define( 'HWP_PE_FIELD_MAIL_SUBJECT', 'hwp_pe_posts_events_email_subject' );
define( 'HWP_PE_FIELD_MAIL_MESSAGE', 'hwp_pe_posts_events_email_message' );

/*Post field*/
define( 'HWP_PE_FIELD_EXPIRATION_DATE', 'hwp_pe_expiration_date' );
define( 'HWP_PE_FIELD_EXPIRATION_NONCE_ACTION', 'hwp_pe_save_expiration_date' );
define( 'HWP_PE_FIELD_EXPIRATION_NONCE_NAME', 'hwp_pe_expiration_date_nonce' );