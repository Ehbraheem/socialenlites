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
define('DB_NAME', 'db_9df54e_w473_2');

/** MySQL database username */
define('DB_USER', '9df54e_w473_2');

/** MySQL database password */
define('DB_PASSWORD', 'DB_98765');

/** MySQL hostname */
define('DB_HOST', 'MYSQL5018.SmarterASP.NET');

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
define('AUTH_KEY',         '=FdC(~!4Wq<Z<)f<Em4;!>x[c^hHxh>pr^M6(2PMsdDllIlz,wu_jg!0[-.<vZn8');
define('SECURE_AUTH_KEY',  'W4}u7.JeZ8_KQuG?3|?}&=wFkCxe}AFGevS8WA-G]_x $y^|Oix&{obW5qBzScuw');
define('LOGGED_IN_KEY',    '1)#AI/>_$CP9jX)MhM)7*s$Ke[`f0X9/${1J72rLGAQ~,<A[!mrk.sVA)+Smqtip');
define('NONCE_KEY',        'GU`^(%)FH/01%4iES52YHAGu:AW_FHV7kB(3]x2sWp:_a3>Th4[,y{+.W!Z#H@}x');
define('AUTH_SALT',        'V[uf%:q*Ks_V~_^OI ^WgjO;`5u:i5k#.>+vJ[/&>T*/6*FL(o&Dgh;=.M2hz%CC');
define('SECURE_AUTH_SALT', 'IvXDy#EXG y{H/s-}d}-2$Q[_v)Bb7>8y6NVcjM8Z*Pf+.VW<{Pfv!EsJX0Kxjhy');
define('LOGGED_IN_SALT',   ' N?X+_ =3Q$Fg@N&RR{gNcc17/YIAWQ!IHQph7lN9xhfi(^,10;jy6<|l^C$]bm`');
define('NONCE_SALT',       '>laB?4qPu2b:wpY3Cx;B{0-hQ`%x+=F;{gIZUGl-W*v9 rm<OmO/rOAU6;1~V<_D');

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
