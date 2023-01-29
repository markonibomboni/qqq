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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'qqq' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'mysql250' );

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
define( 'AUTH_KEY',         'gUo6,XAgmLdf_c>xN%e~]OgEEMZv7!cpv 6ey4YH_LJCzekJmb|B{s+>N efM{-J' );
define( 'SECURE_AUTH_KEY',  ',!4xftzP`Ln,Z$yO|gPIJp,1XO|qUewWc077xT~,M >M3goyzA,!DLUg.WZNym&#' );
define( 'LOGGED_IN_KEY',    'f4%V#Ppqi|u!9m%x];l`@=fk9nOI*NM/o-C,2!v(dEm9jjQ[})m0,R#[uCCMqsj-' );
define( 'NONCE_KEY',        ')pvu2)MPp{ qfzcX/mpwA1|NC#@GkHphWIb;Q c)WQ/a/unAx0N&%rq#n<1 (ADX' );
define( 'AUTH_SALT',        'K]*>;sgTrwl(<Eo4XCD%P^HJyMrlnsE#W8xx[@$JJSg&xNjF*5BKHsyK$glVGs [' );
define( 'SECURE_AUTH_SALT', 'R8Lo8Zq06FUY9Kim3,[H`<N(DrzMLD,4b+!wA6BG_-9A~VD)E-wq2z@v5L-^>ECg' );
define( 'LOGGED_IN_SALT',   'aVGIGg!~BL@m:yC+_mBm=hM4.g0-c5)8[:y/Ap>D>[KT3}Hh4b)yt-$&e%~feKa4' );
define( 'NONCE_SALT',       'smtdr/nzxNyO0,!T5+o|%*Gnju i*!NM_^Au SM~aN;*4:(24ze *S7dXEX7>W(s' );

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
