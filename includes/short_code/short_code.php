<?php
/**
 * Developer : MohammadReza Kamali
 * Web Site  : IRANWebServer.Net
 * E-Mail    : kamali@iranwebsv.net
 * السلام علیک یا علی ابن موسی الرضا
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

// WHMCS Short Code
$options = get_option( 'whmcs_price_option' );
$whmcs_url = $options['whmcs_url'];
if (isset($whmcs_url) && filter_var($whmcs_url, FILTER_VALIDATE_URL)) {
function whmcs_func($atts) {
$options = get_option( 'whmcs_price_option' );
$whmcs_url = $options['whmcs_url'];
	if (isset($atts['pid']) && isset($atts['bc'])) {
	$pid = $atts['pid'];
	$bc = $atts['bc'];
	switch($bc){
		case "1m" :
		$bc_r = "monthly";
		break;
		case "3m" :
		$bc_r = "quarterly";
		break;
		case "6m" :
		$bc_r = "semiannually";
		break;
		case "1y" :
		$bc_r = "annually";
		break;
		case "2y" :
		$bc_r = "biennially";
		break;
		case "3y" :
		$bc_r = "triennially";
		break;
	}
	$amount = @ (string) file_get_contents("$whmcs_url/feeds/productsinfo.php?pid=$pid&get=price&billingcycle=$bc_r");
    $value = (string) str_replace("document.write('","",$amount);
    $output = (string) str_replace("');","",$value);
    return $output;
	} elseif (isset($atts['tld']) && isset($atts['type']) && isset($atts['reg'])) {
	$tld = "." . $atts['tld'];
	$type = $atts['type'];
	$reg = $atts['reg'];
	$reg_r = (string) str_replace("y","",$reg);
	$amount = @ (string) file_get_contents("$whmcs_url/feeds/domainprice.php?tld=$tld&type=$type&regperiod=$reg_r&format=1");
    $value = (string) str_replace("document.write('","",$amount);
    $output = (string) str_replace("');","",$value);
    return $output;
	} else {
    $output = "NA";
    return $output;
	}
}

// Register ShortCodes
function whmcspr_shortcodes(){
   add_shortcode('whmcs', 'whmcs_func');
}
add_action( 'init', 'whmcspr_shortcodes');
}