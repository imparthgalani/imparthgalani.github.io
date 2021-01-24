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
define( 'DB_NAME', 'imparthgalani' );

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
define( 'AUTH_KEY',         '*}lk:%q(>Z{FcxIU5DwU]O!B^|8k+iH)yd(ubWvZ26]|IXlh*~7@0j7>bptoU`9N' );
define( 'SECURE_AUTH_KEY',  'sRI>,V3]M{s{FqQp9IFU[mX/PYaxNTKm}6$d1AI4Q[b2~Y9wc5-zS_l@&0qn{XNB' );
define( 'LOGGED_IN_KEY',    ';>q16-yhSEsFAxSbsH]hyUt?=K@M1)#P%GQJl&)UzFw Z:9{0UW7vk?D@(CJS9hN' );
define( 'NONCE_KEY',        'Lj,19]9(z2brSV3q0v}6/;0 L;+PD0%m]b|pvZp,k?:Z|=:8>:%l^Iu=Z~v]Ki*f' );
define( 'AUTH_SALT',        'P/c4s/jZjfk>GQF6%|(^A-WF9I4)C1A[0|*d,v2sf)tgCLUSjO0gjmb4uGD4Oxs@' );
define( 'SECURE_AUTH_SALT', '0Zl;7SA3ZDTfDjN|1eY1Mj^<Jn1G?l h8K|4~UQ_nmN=B}tWNa3+]O+DB#2ul1SY' );
define( 'LOGGED_IN_SALT',   '~DA0m>!K*Yz3DXL.$WCpA4tzH)&ysIu _GE_W5S%0*QzwOX2k;+1mN4m2~Gn%}`?' );
define( 'NONCE_SALT',       'p%Ah:6mJO=:v#CrNvSLxCJV~W.$&fEjKoP4R7:i|${+ >eTSz8Eum~*@2sTi n#R' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
