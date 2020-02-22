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
define( 'DB_NAME', 'rtcamp' );

/** MySQL database username */
define( 'DB_USER', 'rtcamp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'rtcamp123!' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
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
define( 'AUTH_KEY',         '%8WJ@{<<mlv:vo<g$6@,:biZr~[g8f<x p*yS~4-lGix-R^q!+ZJ8jld]lSS>WU%' );
define( 'SECURE_AUTH_KEY',  'E9O?=v2*V?aaM1j!r/_;%b.|$Jvy#1PUSZg$j%IN}!y1o&U>pB7s1WXtso$]7?(w' );
define( 'LOGGED_IN_KEY',    '^o64NS/._puZ$wBj1UVZcO:O#silt}219Wx0rL+kJ5tgy`>0QDW6Hwr)%m=7m0wN' );
define( 'NONCE_KEY',        'MV-94/S6*4**FUF(v#M+`9bt$v|sIJho=#*k7- *GDbT5U/#83U(,2CHn_5Y`ayF' );
define( 'AUTH_SALT',        '+,w_R|/%;!3O=NEM_6W`aQVz>91^FI,k8QU!vty(bQR}#,S_{X87N~ayS;T$pNF7' );
define( 'SECURE_AUTH_SALT', '6e5O/szmi6q)|~Lp&!twvsvZV=?48Gv}I01&;<(ckra,-nZ?nxv5#1{[_GUX` {[' );
define( 'LOGGED_IN_SALT',   'R;rL!q!}VTrzIdfU4SZS/7mqVK%%wVZ_DTwc c[,9H]RN)(ycQl:c)y]OOJgjs<9' );
define( 'NONCE_SALT',       '|U~b{}Ih!}V-rg3/b(zv-&Yey?PWzf8. Kh,Vb+:-k(Eb #Y>C]g^c|[k20.vt1t' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define( 'WP_MEMORY_LIMIT', '256M' );
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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
