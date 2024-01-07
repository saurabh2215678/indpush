<?php
define( 'WP_CACHE', true );
 // Added by WP Rocket
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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'indpush' );
/** Database username */
define( 'DB_USER', 'root' );
/** Database password */
define( 'DB_PASSWORD', '' );
/** Database hostname */
define( 'DB_HOST', 'localhost' );
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
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
define( 'AUTH_KEY',          'bP )uE^Zx%Ck?l|;3Y`bY-VQnpaV*}G>=;$60-20ZQ2m`I@CWw,j&=g/kTn*JRIV' );
define( 'SECURE_AUTH_KEY',   '*RBl1y_!`V4Q7y- FICSd6:h}4 vNtY)<I6z` |{umnH_e;tY=lEtXe,jmA>N)G9' );
define( 'LOGGED_IN_KEY',     '4A%4<2J@~R2j$$3S/^>[t%}#O7y9s!?oZ N:?eSproSj!y!TQlEvcs2WCNFDi5jv' );
define( 'NONCE_KEY',         '^;?b8iV=24SrJP*@Qvfwd{i/6t<:IyBRU#NRCu7ck*R)Yf,6r?YokK^Q+s7m1%<1' );
define( 'AUTH_SALT',         '6s61#]^DOA6>ohY/=)XW7s[S6wF_XRzAfMKqY,9&E&Jo G7ApOt7suqrf=_dEXi1' );
define( 'SECURE_AUTH_SALT',  '4$SLyWV`]^BN8Q?RenEu<aS^%?<A:L)AK6&bnlOOp}M8RZf8nw%)^KNAcQC~~Y{`' );
define( 'LOGGED_IN_SALT',    '>VIVvHqF^#]^{K,pJ`B:Io_5,[y|=A=8)G+)7c=`7^A^gU&Mz.$-~h(v$0S o>s@' );
define( 'NONCE_SALT',        'hPb:j<;3V48^ugK_ncVaROs, `HIrdav:6fS11 >gx3F%8]x3qz  XtA|lSY]u7/' );
define( 'WP_CACHE_KEY_SALT', '4Hw[|l$bl^OwG<6!5T!3;ozXz1YHuH~Q-I,3b@A,RHtKje1|][+P;95.6B7erIUB' );
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
define( 'WP_DEBUG', false );
/* Add any custom values between this line and the "stop editing" line. */
define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';