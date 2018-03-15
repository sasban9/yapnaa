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
define('FS_METHOD', 'direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'XTH1:3;)y:gg$D`X{qis,f!pWyo3{jgm<g3pp@JJpP;1!_[5x6S&c/?!M5Xk&%55');
define('SECURE_AUTH_KEY',  'rZ5JW3+hgrP/giXH??!:Ha}e)gzND&rhO+qpR=}yy_uj:P`]{97qG0(fI&X]Trn=');
define('LOGGED_IN_KEY',    'sg062m4~!^Q .<]ZyHE<<~yydMuUQV_?gk(8`nLYdhVd n*h(5SP#m/zyU;g}CPD');
define('NONCE_KEY',        'Kcr<HP)x^UUS&B@6X}TZ;!|X|V1[!IG)-xcQ`Eh^,/X>RY+B>~ 5-h9$_)!6LK)b');
define('AUTH_SALT',        '<UaA}1v(/P|3F;o&i6ELDPqoFbOO64b[TM6:9zu]GS4.0<UYtP*ZeV1-A4QU9Ds)');
define('SECURE_AUTH_SALT', 'pkjU)c[zqj-;qUWbSgj)iQwFPKB+OAyVh~,hzTV#?Gz;@5QZD;/|3$I{D8<9`g$:');
define('LOGGED_IN_SALT',   'Ap,LtI02=G1oqxB101!CtXpz#^xa#FOPF#3TW Q?jPc6;f>~:G*?s$F^`hitb5Y5');
define('NONCE_SALT',       'ZB[:um#Te+0b*}+5CqEkx)>aRt}e1(h;8WF+8l3[&O KoXI)<1P>xmHjl]V+HXu9');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
