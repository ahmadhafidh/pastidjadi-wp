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
define( 'DB_NAME', 'kitatech_pastidjadi' );

/** MySQL database username */
define( 'DB_USER', 'kitatech_pstiwp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'yRloD!6ULZGbV&86nWS' ); 

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'JjQ%|2:Oxz&sVNoExdQg?MQtBtM^~hIoj{#5==Vp]9oyCbD;91.@+$+XzdiseYcP' );
define( 'SECURE_AUTH_KEY',  '>:Sl4CRe>SO`dd4Zjlz+/zGq-$r}EsnZ5fj3;+Rg%P~Oq_8VDK1}I(A(.I%Yng=O' );
define( 'LOGGED_IN_KEY',    '`/Lm8x2-wXbObe;qSNsAC2X3L5`[I|PA(:z/rX0ypXWx_<.m240_qSE727R`ADF<' );
define( 'NONCE_KEY',        'ic^7__JPrJD%$[pfo-3-pssW}Fo%IJ) ZFpRB0P.=hDYtwSQnysmu.7TgH3dHxV5' );
define( 'AUTH_SALT',        'bPMU=^=$y0RB[>f ln45xdt0TrAC9_e-fxXb%P?IJ2swz:J7z+=jsP9-`f=Q@W*E' );
define( 'SECURE_AUTH_SALT', '7z24E-8~m1`c-Q1fDtcA/3cNB(.L}Uw:>ZOBrPeVd^ocMvxfR`xH0YT;X1MKU-2q' );
define( 'LOGGED_IN_SALT',   'tfS?5S=tdgw|;*,*9p*=J<ymhF3 ZnzsbTASxfUx;@R+5LCH.C9KHsW`[MdJ0mdM' );
define( 'NONCE_SALT',       'OmX*/g2Pg?q/`X$Jw9:wr]mnV@4!sV<Fg1nd)!j-qb3,-4j!r]r{RmFjv+aSwV^6' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'psti_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
