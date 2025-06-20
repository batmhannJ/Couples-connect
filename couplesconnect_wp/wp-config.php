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
define( 'DB_NAME', 'couplesconnect_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         '|)d=h?2=58C^T3*sdhN#qr 2?yMR0IsA0y8)zdtv0U?3l6-ZlQdmMflGa$E$JXeq' );
define( 'SECURE_AUTH_KEY',  '(nAJ3bBPj<G(#YSv5hxSLL;|y3LZ,kYDsPk92d7*=UEf0=vZd3;:5,i$Hk;tSxRc' );
define( 'LOGGED_IN_KEY',    '<cFIiCv=.yd*BioZ#(+(eiNEp)]+q:pk0ItUD@^KixD4pK{4(dSUwBE+a*TIpdA!' );
define( 'NONCE_KEY',        'G0#h,~-&Qcq<pO}-n|Bno@l~6+O e`:{L3LW!%!_2/H8sO :^]^+(!1(-UD#O@-5' );
define( 'AUTH_SALT',        'rW#(WsC%KG*[A^$n_R3QAYiD/J}T0MyFtY7c<66uFAD9#58N_Gb1GDi?w5c!?Lz3' );
define( 'SECURE_AUTH_SALT', '6A|97A[[Y8V9jNQD_@=9<|ZB7}@x]|u!-@?Ee]DO<>ZE%%7v&uxSnFq6Jqb3uv&|' );
define( 'LOGGED_IN_SALT',   '4H.I-@Trv[A~jqr^>Ri*u`*25T-k{1X/0`U9055O^bKpQv0BfXx7FQ9{K=FFb07#' );
define( 'NONCE_SALT',       'Q@M5.e(j`z_]BEu@hy`B~TYo+rJMUTdtl;5!>mvUb*Az|S*o@2_]s@#i#&fZ)+(x' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
