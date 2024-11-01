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

class WHMCSPrice
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'whmcspr_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'whmcspr_init' ) );
    }
    /**
     * Add options page
     */
    public function whmcspr_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'WHMCS Price Options', 
            'WHMCS Price Options', 
            'manage_options', 
            'whmcs_price', 
            array( $this, 'whmcspr_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function whmcspr_admin_page()
    {
        // Set class property
        $this->options = get_option( 'whmcs_price_option' );
        ?>
<style type="text/css"> pre { padding: 25px; line-height: 1; word-break: break-all; word-wrap: break-word; color: #333; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px; width: 80%; } code { padding-left: 0 !important; line-height: 2; } </style>
        <div class="wrap">
            <h1>WHMCS Price Options</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'price_option_group' );
                do_settings_sections( 'whmcs_price' );
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function whmcspr_init()
    {        
        register_setting(
            'price_option_group', // Option group
            'whmcs_price_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'whmcs_price' // Page
        );  

        add_settings_field(
            'whmcs_url', // ID
            'WHMCS URL', // Title 
            array( $this, 'whmcs_url_callback' ), // Callback
            'whmcs_price', // Page
            'setting_section_id' // Section           
        );
        add_settings_field(
            'products', // ID
            'Product Pricing', // Title 
            array( $this, 'p_price_callback' ), // Callback
            'whmcs_price', // Page
            'setting_section_id' // Section           
        );
        add_settings_field(
            'domains', // ID
            'Domain Pricing', // Title 
            array( $this, 'd_price_callback' ), // Callback
            'whmcs_price', // Page
            'setting_section_id' // Section           
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['whmcs_url'] ) )
            $new_input['whmcs_url'] = $input['whmcs_url'];
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Dynamic way for extracting price from WHMCS for use on the pages of your website!<br /><br />Please input your WHMCS URL :';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function whmcs_url_callback()
    {
    $options = get_option( 'whmcs_price_option' );
    $whmcs_url = $options['whmcs_url'];
    if ( isset($whmcs_url) && ! $whmcs_url=="" && ! filter_var($whmcs_url, FILTER_VALIDATE_URL)) {
        printf('<p style="color:red">Hey ! Your domain is not Valid !<p>');
	}
        printf(
            '<input type="text" id="whmcs_url" style="width:310px; direction:ltr;" name="whmcs_price_option[whmcs_url]" value="%s" placeholder="https://cp.iranwebsv.net" /><br /><p style="color:green">Valid URL Format: https://cp.iranwebsv.net (Dont use "/" End of WHMCS URL)</p><br />',
            isset( $this->options['whmcs_url'] ) ? esc_attr( $this->options['whmcs_url']) : ''
        );
		 submit_button();
        echo "<p>Note: After change price in whmcs, if you are using cache plugin in your wordpress, for update price you must remove cache for post and pages.</p>";
	    printf('<hr>');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function p_price_callback()
    {
        printf(
            '<strong>How to use short code in :</strong><br /><br />Post / Pages : <input type="text" style="width:343px; direction:ltr; cursor: pointer;" value="[whmcs pid=&#34;1&#34; bc=&#34;1m&#34;]" onclick="this.select()" readonly /><br /><br />Theme :  <input type="text" style="width:500px; direction:ltr; cursor: pointer;" value="&#60;&#63;php echo do_shortcode(\'[whmcs pid=&#34;1&#34; bc=&#34;1m&#34;]\')&#59; &#63;&#62;" onclick="this.select()" readonly /><br /><br />
<pre><strong>English Document:</strong><br />
1. Change pid value in shortcode with your Product ID.<br />
2. Change bc value in shortcode with your BillingCycle Product. BillingCycles are :<br /><br /><code>Monthly (1 Month) : bc="1m"<br />Quarterly (3 Month) : bc="3m"<br />Semiannually (6 Month) : bc="6m"<br />Annually (1 Year) : bc="1y"<br />Biennially (2 Year) : bc="2y"<br />Triennially (3 Year) : bc="3y"</code><br /><br /><strong>Persian Document : <a href="https://blog.iranwebsv.net/whmcs_price/">Click Here</a></strong></pre>
<hr>'
        );
    }
	
    /** 
     * Get the settings option array and print one of its values
     */
    public function d_price_callback()
    {
        printf(
            '<strong>How to use short code in :</strong><br /><br />Post / Pages : <input type="text" style="width:343px; direction:ltr; cursor: pointer;" value="[whmcs tld=&#34;com&#34; type=&#34;register&#34; reg=&#34;1y&#34;]" onclick="this.select()" readonly /><br /><br />Theme :  <input type="text" style="width:500px; direction:ltr; cursor: pointer;" value="&#60;&#63;php echo do_shortcode(\'[whmcs tld=&#34;com&#34; type=&#34;register&#34; reg=&#34;1y&#34;]\')&#59; &#63;&#62;" onclick="this.select()" readonly /><br /><br />
<pre><strong>English Document:</strong><br />
1. Change tld value in shortcode with your Domain TLD (<code>com, org, net, ...</code>).<br />
2. Change type value in shortcode with <code>register, renew, transfer</code> .<br />
3. Change reg value in shortcode with your Register Period of TLD. Registers Period are :<br /><br /><code>Annually (1 Year) : reg="1y"<br />Biennially (2 Year) : reg="2y"<br />Triennially (3 Year) : reg="3y"<br />...</code><br /><br /><strong>Persian Document : <a href="https://blog.iranwebsv.net/whmcs_price/">Click Here</a></strong></pre>
<hr>'
        );
    }
}
if( is_admin() ) {
$my_settings_page = new WHMCSPrice(); }