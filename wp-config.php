<?php
if ( ! defined( 'WP_CACHE' ) ) {
	define( 'WP_CACHE', false );
}

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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Local Environment Detection ** //
$is_local_dev = (
	( ! empty( $_SERVER['HTTP_HOST'] ) && (
		strpos( $_SERVER['HTTP_HOST'], 'localhost' ) !== false ||
		strpos( $_SERVER['HTTP_HOST'], '127.0.0.1' ) !== false ||
		substr( $_SERVER['HTTP_HOST'], -5 ) === '.test' ||
		substr( $_SERVER['HTTP_HOST'], -6 ) === '.local'
	) ) || ( php_sapi_name() === 'cli' || php_sapi_name() === 'cli-server' )
);

if ( $is_local_dev ) {
	/** Local database settings (XAMPP / Laragon / WAMP) */
	define( 'DB_NAME', 'u200490375_dahab' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', '' );
	define( 'DB_HOST', 'localhost' );

	/** Local URLs (prevents redirection to live production site) */
	$proto = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) ? 'https://' : 'http://';
	$host  = $_SERVER['HTTP_HOST'] ?? 'localhost';
	$path  = ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/ee4woman' ) === 0 ) ? '/ee4woman' : '';
	define( 'WP_HOME', $proto . $host . $path );
	define( 'WP_SITEURL', WP_HOME );
} else {
	// ** Database settings - You can get this info from your web host ** //
	define( 'DB_NAME', 'u200490375_DAhAb' );
	define( 'DB_USER', 'u200490375_XAanB' );
	define( 'DB_PASSWORD', 'SaPbKOJzBc' );
	define( 'DB_HOST', '127.0.0.1' );
}

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',          '_7&fsg^[ydSg`)5Y_cw`Pi--pk81916VLk$]ItH) 7:b&Ruwl)l]|aZz+c,$xH^R');
define('SECURE_AUTH_KEY',   'geKaNR!W@wW%eT|Zy~29h@TZv1+,Op;09E4tRGP1xrqL!%#oe{70*}l5;t3-{1vI');
define('LOGGED_IN_KEY',     ']rXT@?BSeYRIuiQ%+Y|_|?z!DbzVax>bNp}z .jJVO4;c0A_T)GJ ^#bgT6Ter2y');
define('NONCE_KEY',         'xB?)#-[-T2;l86K7e[W&KC`X7C9>mnznKZzch!C`D;/zOHJ@-nz_(7hTVp|v|IVU');
define('AUTH_SALT',         '<mJ]><.$L@x-yL-<}i%3tw:L!db/7lIbI@RqY-z~rKTz`z>5i)Je:T:w]Uaa?v+Y');
define('SECURE_AUTH_SALT',  '>XX:F1uFfa~1d|uT:?qr5]K|F+(3]cU~*0~+{%XGb?^B%=1;x%$D-Ue];V=iW||+');
define('LOGGED_IN_SALT',    '|z:e-!H4Mm,t_{WY4oI-&-Sm?$RQ `uL,7-4x?aMvpLQ8h?mNgC@A^)]ysw3J%|]');
define('NONCE_SALT',        'lrF+}x0g7n2Qy||V+/%D;pI:Thq_]=%m_>kt-x4Nx:&X;5XgpfKOq!Z#3:-+mAVv');
define( 'WP_CACHE_KEY_SALT', ']MwGw`w M_CS`~T=J9(-L{0`WZ|6M/zb:XHKk~%*l2#X6xWb^2OXDxxSwp^.~4(W' );


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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'FS_METHOD', 'direct' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


