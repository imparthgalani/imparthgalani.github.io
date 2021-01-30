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
define( 'DB_NAME', 'portfolio' );

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
define( 'AUTH_KEY',         'vpbrra;F9T]Fg,YTF;n;Leet0w][>vPYPl7SYf&%W?5#ZWs$kSF.:-7zuUf1COAF' );
define( 'SECURE_AUTH_KEY',  '8EBt-3H613JPeBVr!(RV.3H-<qoy$X7K8m[c|e?om9#GD!D+v6ZB<+^,9S(%jU^/' );
define( 'LOGGED_IN_KEY',    'djEex:%f]z<OMi;C-D2*$0#KA/VJ)Kr.y1!(^H}TnI1Mx![~Px:!k0A,rxc+8u=L' );
define( 'NONCE_KEY',        'T5/DE0N LmA*@/#/qF(s3Xp7_,(^(Ix0_)Wj}RA4aCXUl #3DTX^n1d|nw=6f>~1' );
define( 'AUTH_SALT',        'R,k>rXq~t+ Ii`apn@#14z=N?wZBlnD/7^p4zqnZ6LjujOAmN<I[T)P]=#]T8wAy' );
define( 'SECURE_AUTH_SALT', 'Nd:zAxDA^%#c0_K9>By:LBINtGdJpCX@!s[pq.SERT^T4MG~RG5ZepZ-D9=,znoV' );
define( 'LOGGED_IN_SALT',   '$y5 !ee~Q=KPrhQ}w+1 ^$5=ePu^sw`-}OuE=EL^Kq+WoD*sC^f1^U}?2c~$DVRd' );
define( 'NONCE_SALT',       '^TYs?yB$?d{|2/CN%38s026SmV0 }Ty%VXrvd&cy/Z^#l09%YIKlpF+Rkb{~AL]6' );

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
