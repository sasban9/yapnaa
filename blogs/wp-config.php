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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'yapnaa_blogs');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'M0v!Lo@987');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HJ}_Ve7m*/q^h-x#ci?6d;=y:o=!Pq2:_*8fHc.[ytRSE]tZ>H*`HoM=s_-LsFE}');
define('SECURE_AUTH_KEY',  'gl#UQzjWg%]06s3]Aw<F8YRy^]El,8jHwe^]6Z!W*ZrE[R%@0Q~@zyz8`CPdB`&z');
define('LOGGED_IN_KEY',    '8I*Zhzs2SU|&NMb|$GGwByn7mZ~Tt=Wmpm=}jaGGJ;s4z&9G]Q2Z%<K*O_tppE:=');
define('NONCE_KEY',        '#;5Zfro#IVxAh<~to$_,Mfoe-)k,5p}maTNE,2!%J0<DR2D53if>n4u#26cXX2};');
define('AUTH_SALT',        '`6NTt|:`qK&f297>?cX>L))?*ey!Lt;]S(xt(_M3ZNCLv{pY J:(l?f2ALMU;,T[');
define('SECURE_AUTH_SALT', ',ttzGA(x1Ih(Cwi0mDvj3}]w8`k[:a{A~!?~O E(4G4_xS_*I%Nh[Y9;b^s(MX(o');
define('LOGGED_IN_SALT',   'd<N`0CD0M)bs[(B>,>RDLLZWRCfc~jx- t*5$z$[||aP4x/fUe?]jL3~Ile,N_32');
define('NONCE_SALT',       '9_HIDnsDP|1dn5VhQ&lU<PLv79Zkb4};TU}%U/,=+^yu~j;%tiW-10uc5Et@N6i,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('FS_METHOD','direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
