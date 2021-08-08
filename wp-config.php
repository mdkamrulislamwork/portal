<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wg' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '9!>G<4P@wI,Ug&J=k58xijDGc)g4%)Fa2Y*tVsdr@hW)e:>IQAd)h%9y##%9@T]1' );
define( 'SECURE_AUTH_KEY',  '@?^6lM[:AtN5P=r=q0lyQ%Hk/Hj05G{(pA`AehSz9i2A#/RI6,C_U4$GzX#hVtOg' );
define( 'LOGGED_IN_KEY',    'OCaUJFlWZ^fx1bRRLcxszCrg8ek,v~(4!zAZ/JQgjzV~R6GJ(y0[D at&U*]O`[s' );
define( 'NONCE_KEY',        '.B;Jjf4if?1-;:4UVm.dkhw4D{Hy+m3/RoW;7>O]Chc)0EYV`SQlbc7Uy->TV3u9' );
define( 'AUTH_SALT',        'xFh@|<(jheeQw_FGo60)p9t7O.wulTNx{fhmpp:6g,~iUWm<d.D.sP75dPaq=pVU' );
define( 'SECURE_AUTH_SALT', 'ham;`B4uP5,,i_Z|;11zoiIpN%/Qk ;(A{&jLQ/^r6}Ap0VH.#_IjrTm/u50[54S' );
define( 'LOGGED_IN_SALT',   'GT7F;si*)D F]7yy<P  g-8[Ebh_2%fqSX3W8Hd(6ygkLSjFlneHw673&Z>iJnYm' );
define( 'NONCE_SALT',       'fk>=N.vmyGZQSshb[X=pu0%xQBoC`&YTo>tH`h@mgaH5)H.`W((W*M8I6xFd/wUd' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
// define( 'WP_DEBUG', false );

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', 0);
define('WP_DEBUG_DISPLAY', 1);
@ini_set('display_errors', 1);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
define("FS_METHOD", "direct");

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
