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
define( 'DB_NAME', 'iamparthgalani' );

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
define( 'AUTH_KEY',         'PF+T5YdqU)Ci+noXE)fM%-!q9qr?-Ziz -!-&+5 L-Al&!j}|B0n[IoX>nV+*+0z' );
define( 'SECURE_AUTH_KEY',  'QAtQ5P{zolydylO2%_.OWnfVTss[**[4.l/TP-`M!f5Qe2XpMmDz,[$^e)jt;7$L' );
define( 'LOGGED_IN_KEY',    'HjKKr1Z#A6p<g[+MCjiJK|z-bk-8Gf*,?u7!$1EY#~;gTPiP%ne{B1N`wZaaBhFF' );
define( 'NONCE_KEY',        'Iz4=is}KuO2@7!PFTOuw-k*+j`=Yqyc& 6OKg<Dl`bi}$zzVZdoS3@TV;fN8!(nf' );
define( 'AUTH_SALT',        'c.>5G.)V`c6l*GgTcAjCYN P_[az]mJp*KAIpnr7%ljQ*~L+l6IW9x/*B>tUg]qz' );
define( 'SECURE_AUTH_SALT', 'Fx6)?,CMQI^[n=2yD&39V:I|^$r$)<Yp;:$-.|Ak.|_A*r[uFONzjta5~{Kwm;nW' );
define( 'LOGGED_IN_SALT',   '#*<EgT]1)A.TmE{Usv</D0IP=Kwoj[P7$;2~zFGX~~[@O%4ultazjWu)Pz`oayhm' );
define( 'NONCE_SALT',       'dypE&we}_%R.G.qH`#A%$v}:3*lSn~.[y7WaL/8L2S{JnQuc,<q#Rt[SFgLKNS]=' );

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
