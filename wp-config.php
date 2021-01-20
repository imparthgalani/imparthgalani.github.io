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
define( 'AUTH_KEY',         '`|,1%=G[GiqKwXKri5@?05ys0Ztjq@wR4{glL|nFUH+bL*=+zvVg|7~UQftDEp#G' );
define( 'SECURE_AUTH_KEY',  'DpkUi#8jr[b!{8fDM2YWd-GQY:s]#mg<E)/>[(@xf3@oX*Q<?%|jXoHF=W8mY(=6' );
define( 'LOGGED_IN_KEY',    'w:Y_WwrQvW1bJ[:rE4k^:L,Pe446q,e$;d#^f^LN5m q]IMZIbXh}l2(2~W>aA3k' );
define( 'NONCE_KEY',        'BYSp0pi/~3m5:UI}+wd08}Hnq?%#^CF!*tj<M0:_7VTwZ<ZzC;i/wS=8=Uv(05ns' );
define( 'AUTH_SALT',        'N-o~WDpbEC.#[Mst0CnY$$?p=Q]wGlpX$58&QjEj#<y`kU?2PZK/G!:{U?2rf~mr' );
define( 'SECURE_AUTH_SALT', ',FgOlF<{^)Q;nBH<WV93oqf!y38[(_`lucQh=[f3DQS:h yy75bL]tQooEF_mnk#' );
define( 'LOGGED_IN_SALT',   '#$yDRvZ7g0_5{ @Wti):7p7~BZb%r7Pk0`hBO~X( Sdlz8XkruZ(ONb!K9.+)GGy' );
define( 'NONCE_SALT',       '+|F+_~pPjz=pkSaRy~*7#j !f;^JFz<l)~9Y`.uY=X]x4&JZ2LQbB[8r=c)+@!>&' );

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
