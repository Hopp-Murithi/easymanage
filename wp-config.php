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
define( 'DB_NAME', 'easymanage' );

/** Database username */
define( 'DB_USER', 'admin10' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

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
define( 'AUTH_KEY',         '3F-**+9KR0DaBn88w-brGwDA=o7zIeI<_ TG#FV8^kJ#dR:{0;Y7rJnD}E9co6x?' );
define( 'SECURE_AUTH_KEY',  'BGb{2)nI<O!6XgPt$3BPdrt#|YBqAOE*uY)hnzp2x0HAh!y=vUfdBk-lcZ&%zKI^' );
define( 'LOGGED_IN_KEY',    'Ki^L*uRm0G,Q%zWH|OQ*%[^Ap+?r;V^]pXT>KSl6ig*dWGiMe>vIN&/T}^Fka?kS' );
define( 'NONCE_KEY',        'WMg~w<6VmkZ-/~4?w6Gcx.7m%&Iu2 scbcW_;CFzPBd>|#%!Ds}g$YeN@L+kEreS' );
define( 'AUTH_SALT',        'Gkjwe+(>-+zKCSiMDva16URMPSI-{Ay[qfWw,?pU0E83^Mw&s2mkS7T@(+zJ(OAW' );
define( 'SECURE_AUTH_SALT', 'YaA-U@f^Y=Hx?Jvo0!3#^RD*KM7orY|}&Hg[TBDLy;::{}2}2LJ L(-TKUWO%~nX' );
define( 'LOGGED_IN_SALT',   ':J^7=8hA0N9@~qHrtz}6cIun8.hlwu9KG&/Y!]LkI;DMrgc5hdHGixg9I&+UYT_}' );
define( 'NONCE_SALT',       'Ki[.N=ssb{d}SZeXr^Bf QAJP9[W@$rbl4/GKl3HgcbC@Rk#bY:8J4;FD2:AFupV' );

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
define('JWT_AUTH_SECRET_KEY', 'abcdefghij');

/* Add any custom values between this line and the "stop editing" line. */
 


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
