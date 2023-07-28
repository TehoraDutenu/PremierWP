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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_cours' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', 'database' );

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
define( 'AUTH_KEY',          '?p<o#)-~v&h54{QS3Uvgeid:JkYZTn5%8]qhoQOB`L0JrGiY~2gN2Z_^_v-~&`s2' );
define( 'SECURE_AUTH_KEY',   'b(xT=ntm,@`UQ=0Ic?>}ik_z$cuP@)7^$fw#(;T]-7!XL@?#4/t,Y NGd Jv1PUW' );
define( 'LOGGED_IN_KEY',     'a<)TXct0`J4jGLE:*.>PCnj&U;npLwqVXz?cK#/#ZYvHqt`UYDYS$s2cMn67M5bD' );
define( 'NONCE_KEY',         'omEmO~gYo2aY-&516Kl/G$Jxeb+,i5-7_gRRyk H/=>MsiP5>.+04oFiKvpvo5.R' );
define( 'AUTH_SALT',         '- vMU*4MM`<bdgLH#ZanHf6Qh,cbcl[O|,V{t|d-RUG=;&*>os#3RF^FT ,lfr[W' );
define( 'SECURE_AUTH_SALT',  '&$+[~IF1dAJRqcI@$URz<%O;X7v|lmWhwnO-l9LJ/]fQE}[>h1Pg7]LEIt>as`n$' );
define( 'LOGGED_IN_SALT',    'PKsAf7CN~M]Lfp6kEVkM[qaCU{WqOI%&fuN~~,whp<b=rJcp|^1aH1UlBS,vPz=)' );
define( 'NONCE_SALT',        'p,or;}G$en:3~(o5,JS4n83FFp|b^X -,NIq/JN<-H8~vL#@bp,#6!U4PdQW&([?' );
define( 'WP_CACHE_KEY_SALT', '7_#9T?<LW[,C3J7!4m+;t2.G9+;-p X2*GeMYAGk_=SW`$&h4b$V$#42hBiJmg_7' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
