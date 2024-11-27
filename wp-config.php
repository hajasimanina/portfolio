<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'timber' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define( 'AUTOSAVE_INTERVAL', 5 );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ag_LvG:W,StsITtg#6|qSpA%SkA;mU9LP^upGOo&[Bs7|5c%H5|afhH;7PsLD[++');
define('SECURE_AUTH_KEY',  '-QcZuUA/0$#7 ~[dv)kHkCOX 9{A$vU-q!Su8t@E`a-GH+?3+n%Q3&I@{*/@?>-Q');
define('LOGGED_IN_KEY',    '-Qk#LR#,,,4s]-JS&qK=%Ov%M&S#YVZ|uU7+gG6d)nr<XOa2G&[6Y2R$$<wJ`kB9');
define('NONCE_KEY',        'V@Jjd+g9Z& sTZko5+:O uB9^>f|x+Ejb?X[k&_)naP7)~IUY^9~xae=f)&[rGM.');
define('AUTH_SALT',        '4P|`t(h7G`O7o6vdR}L^+BM;h-YQcGJNqorG*f2aC H/G*BY!E#!g0>+3ufeyh-[');
define('SECURE_AUTH_SALT', '!{#{(+uFW!)v:>u^yD-[Ux-O|I~t/^+jv{4SDbXMXFAgR6~7<;uq!x/36Lo)^LV!');
define('LOGGED_IN_SALT',   'BT}(edC>aJif e%0i/,,G WzI69eK$j%=zO2z08Sv}A2C{o+kfM_G!8I%JF~=^P+');
define('NONCE_SALT',       'xl@i*`58a6ekZgCzf6Yd9w746L;Q7Q1q]Vs.-f>_&J}h3D4i-9LI6<B@Pb=7EVvH');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'dwp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'FS_METHOD', 'direct' );
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
