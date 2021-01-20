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
define( 'AUTH_KEY',         'jVf:!7|XF6i>)}40n-?TK8AEq2AtFHm0AS*B{Ak/B,tt_SOM+.UMH!7dd7icG{%-' );
define( 'SECURE_AUTH_KEY',  'Nxk|EGLX[y^P6JwY1~:q(3TFn-%]ku]kJ3w~>/%1flAHZH<$sVz}9N:Hn&-u7G=S' );
define( 'LOGGED_IN_KEY',    '[P:c%_eO]#%m2 c-%X1dBSQ$b3*b^18WC1)q/:b[iJ9+*.]syP[)lC16.PIn28&%' );
define( 'NONCE_KEY',        'Nd$KSLxeP1X1SZQ5V[bQi@aG>P3@06*EI{@yJ4|%,.ybDf NGA(=x!u&!Lvj%(.>' );
define( 'AUTH_SALT',        'Ql74#yb 6ScTX{=vmjBdZ+Z4s0Kg~Lp@O&&i[Yg20{B=z0Z>s}0P1lmCbYh{(6KR' );
define( 'SECURE_AUTH_SALT', 'mw&Sv!h=5HYu/Hnpk3H-q)$B[f&*WakdJ(_eRy=m,I>+jMlZwUE<>P0,8Agb4jeI' );
define( 'LOGGED_IN_SALT',   'p]E0ln>$D`hU-6n@K@vYAd>_fJ:qynSH<W2!gtsop8)uv}BacZHnfGCJzAjis7g-' );
define( 'NONCE_SALT',       '}91HE](G)t GCkAUA23>3fb[1l9i`x&rCn=3NDNEMcbT!A<%AxR{Hh%lL!=/7qzo' );

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
