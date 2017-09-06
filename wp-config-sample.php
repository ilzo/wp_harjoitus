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
define('DB_NAME', 'your_db_name');

/** MySQL database username */
define('DB_USER', 'your_db_username');

/** MySQL database password */
define('DB_PASSWORD', 'your_db_password');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '>i}$z&$Z~1sXWl{~)|U}+Q+&UX7*fdYbF2I&nR(GOEcCg}jdk_#V|szG0DUidP~d');
define('SECURE_AUTH_KEY',  'mY#y09*%rh/jjyWfgv{9BLa%1B`+HLn*Lihms:jZd;tv`x&@u-OD0Z$6%LcxjH-v');
define('LOGGED_IN_KEY',    '5b!Cocu::@wm^E_<n=qk&!M+7FL*QUq(q++!T ]_nT[$I>~3)fO3On&KSrO-`J~#');
define('NONCE_KEY',        'O[<]Q6`p&u*>K@oZgd{)O60V+@>U$GQ|3fS>,9nd>:%-QhtBjSau=:OT#]*~+lm[');
define('AUTH_SALT',        'p||u^=C%VVcf`7s)1LA7|SG.X$%;{M&t;#V~c0#EY!-PB|ERA9:OIq!Fx`w/am6O');
define('SECURE_AUTH_SALT', '>TgZBp?%aO+D!(0Git}8M.AST;XzS8++z$?#wo(uR40n<B{YzK@+0Y^-On6Mzjxj');
define('LOGGED_IN_SALT',   'FS5NU,aKm O}~M=Pr0v{o/;L#2iJYl+Q=mm0qxKOpe;=Tgk4I5/T)c.$- K.r5=H');
define('NONCE_SALT',       'p<Fk}R&(qmSN8P-RX(EmPe4vCqZv0eVms;I9RuH:LD&E@m*o-44w(L1tI9]>+vBH');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpshj_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
