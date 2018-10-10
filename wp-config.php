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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '@|NjI|pAXD,h&WxRJ6+NvO^8>2!7e?*YtL?5YIPjFa98ztyMDNSug5v<NYaR2sSt');
define('SECURE_AUTH_KEY',  'N. _L4h8Tb%k%%:Jk>f?dj-oJw#-}`%e%`z>Q-749$emcsqaAi+iHJyIqB!!Nki|');
define('LOGGED_IN_KEY',    'aB.!dbfS]!~N^y5V[Xh(=9R9PL+j]SYn3^&,FuT:yGv~?!R{m[6L/~h%G}acox4 ');
define('NONCE_KEY',        'hB3e83tvq6zmUEa8<=p>]xX *N|7K^p$&,:ci$zK,[3[@NE^ lg.2;sc8vZ:bszq');
define('AUTH_SALT',        '0Q}0Iq_JdYYVz?-[Li0=.1tP`<ucKf$+;JJM}AHAaAp2}pd$QKM7F+9*IvrMV6=F');
define('SECURE_AUTH_SALT', '58DDTOc9yqxzi&EQ(T5E!zUUrZ;;)Kn%>%nHkW)f-?B1^rzML0?/u&r?%N+w~=V=');
define('LOGGED_IN_SALT',   '/J]LZ1V/<Uwamqa[r{/|hU0NGs!&5?&RemEfvEE:mc,~T6/zwm1*oS2F#luDs/K7');
define('NONCE_SALT',       'C(q>oR,QbZyiQp.0)R/E9@:T_iF-.qE(Pj4or=:Jh_3|.i^B^~{&(U,xVMRr1H~1');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
