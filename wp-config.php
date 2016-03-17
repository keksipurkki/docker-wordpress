<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', getenv('WP_DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('MYSQL_ENV_MYSQL_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('MYSQL_ENV_MYSQL_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('MYSQL_PORT_3306_TCP_ADDR'));

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
define('AUTH_KEY',         ')uEX=sI>;|O*:+$a6+1Dp~b%+K4l;>-r|]#+0p>?+^X8QZ#%=Df}7%V[#RI-B5/Q');
define('SECURE_AUTH_KEY',  '68+67|yv#WF8^}s^An|ir5?_rP]ZryQ.xmmU%uL#L=fcAx6RHZOJ:ta=cSEf,5@a');
define('LOGGED_IN_KEY',    'oKuh$DbI #_m{L[SJn]QG^zwW&z>BKS^e{pbfj4O|DbY f.beF7$T9PM2m&6rhj>');
define('NONCE_KEY',        'u^VVK-+f]gZ!9*``wPp?K^6^HPs)H`L@WQlO<10!i3wU!jx_.GrDDagP=#sb%NWS');
define('AUTH_SALT',        ']VuQQ@EHF&L36%!]n2D-bR;jMsC|7Zt`OsG_+sQ5AELvLX6QVg^U#U-]^w%tn{:-');
define('SECURE_AUTH_SALT', '6-T1zl^kd$M?KF.NU`+V6x`Hw^w^d5.HGWvS|o-9k-u]~ $+PU_:f3$!Y,A=4Lfr');
define('LOGGED_IN_SALT',   'Y18t*x|o`rnuIJ(lhx9+!~YLe;!|QfbEs=KF]Trg|TvC>X!seU`sH(r_1Rc,P<(=');
define('NONCE_SALT',       '; =yi3Vcd%~tismQjpT*Db):.=-j,-|j_, -gtq54ar9s(^x}kyB}n*UG-mI 3]n');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
$base = '/';
define('DOMAIN_CURRENT_SITE', getenv('WP_LOCAL_DOMAIN'));
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
