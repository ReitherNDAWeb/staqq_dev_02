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
define('DB_NAME', 'db336529_253');

/** MySQL database username */
define('DB_USER', 'db336529_253');

/** MySQL database password */
define('DB_PASSWORD', 'xqc2wqv3ehz*GQG0zcx');

/** MySQL hostname */
define('DB_HOST', 'mysql');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('FTP_USER', '336529-161-staqq');
define('FTP_PASS', 'dfr@RVT7jze3uyb8nmf');
define('FTP_HOST', 'ftp.adhost.firma.cc');
define('FTP_SSL', false);



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '>@sh.Q/eCS/_Yve:)7Hfy,C+D-Ku.sY0RpbnsdC-C5&2nvq]}*SVLI:_~Z+a]$ -');
define('SECURE_AUTH_KEY',  'h:2_PAEP{p_]DB-ZplB,t391G)[B7Y;_tykaR!/U7F%4S_mk eb5Dv6f^04ZHp=G');
define('LOGGED_IN_KEY',    '|w)(TOK>Zf&z|D9$}R~I*T#j%DHqHi4LP7_1W}8NAKOw4K*#Bb*{I3~C_ZB,/jTl');
define('NONCE_KEY',        'P*]p0yV]T3zE+.<BYl98+k@/ JMi#JSb4E~+nT@9TSlr7D_f;MKs$Td/Q9?H[.l~');
define('AUTH_SALT',        '2{gGLRU;EBJdJUvR!}G{s(t&n5!6zm -ZW#a.PvF?h7a  NVNVH3~4M=os|Co0_S');
define('SECURE_AUTH_SALT', 'QNl.J$Cvqi!||[/$_UIT-a-I#&))7AC!D|K3R]ok{>m<:tEd}d3_S]>FBWdFNMPw');
define('LOGGED_IN_SALT',   'M5LT~7V`eTb]7e/|t!m$|I-,2JBL%{788#e_t]5g^5_&YRdiKj=prxhz6c+# r S');
define('NONCE_SALT',       '&yO2,E%m]_!?bTUc>M*b;R9+U.ly}?>dX`jiK9}6i8G a5|M#}@kd9O_BB9k?,Ay');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'stwp_';

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
define('WP_DEBUG', true);

define( 'WP_HOME', 'https://staqq.nda-web.com' );
define( 'WP_SITEURL', 'https://staqq.nda-web.com' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
