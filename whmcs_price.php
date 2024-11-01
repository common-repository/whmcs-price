<?php
/*
 * Plugin Name: WHMCS Price
 * Plugin URI: https://wordpress.org/plugins/whmcs-price/
 * Description: Dynamic way for extracting product & domain price from WHMCS for use on the pages of your website!
 * Version: 1.3
 * Author: MohammadReza Kamali
 * Author URI: https://www.iranwebsv.net
*/
/**
 * Developer : MohammadReza Kamali
 * Web Site  : IRANWebServer.Net
 * E-Mail    : kamali@iranwebsv.net
 * السلام علیک یا علی ابن موسی الرضا
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}
if ( ! defined( 'WP_IRANWebServer_ROOT' ) ) {
define( 'WP_IRANWebServer_ROOT', __FILE__ );
}
if ( ! defined( 'WP_IRANWebServer_DIR' ) ) {
define( 'WP_IRANWebServer_DIR', plugin_dir_path( WP_IRANWebServer_ROOT ) );
}
if ( ! defined( 'WP_IRANWebServer_URL' ) ) {
define( 'WP_IRANWebServer_URL', plugin_dir_url( WP_IRANWebServer_ROOT ) );
}
// Short Codes
require_once( WP_IRANWebServer_DIR . 'includes/short_code/short_code.php' );

// Check WordPress Version.
global $wp_version;

if ( ! is_admin() || is_multisite() || version_compare( $wp_version, '3.5' ) < 0 ) {
	return;
}

/*------------------------------------------------------------------------------------------------*/
/* !CONSTANTS =================================================================================== */
/*------------------------------------------------------------------------------------------------*/

define( 'SF_UUPE_VERSION', '1.0' );

/*------------------------------------------------------------------------------------------------*/
/* !INIT ======================================================================================== */
/*------------------------------------------------------------------------------------------------*/


// Setting
require_once( WP_IRANWebServer_DIR . 'includes/settings.php' );