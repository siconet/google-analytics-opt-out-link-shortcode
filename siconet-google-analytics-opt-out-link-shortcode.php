<?php
/*
Plugin Name:  Google Analytics Opt-Out Link Shortcode by SICONET
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Provide a simple shortcode to display a customizeable Google Analytics Cookie Opt-Out link in Wordpress required according to the GDPR.
Version:      20180819
Author:       SICONET Dominik Rockenschaub
Author URI:   https://www.siconet.at
License:      GNU General Public License v3.0
License URI:  https://choosealicense.com/licenses/gpl-3.0/
Text Domain:  siconet-google-analytics-opt-out-link
Domain Path:  /languages
GitHub Plugin URI: https://github.com/siconet/google-analytics-opt-out-link-shortcode
*/

defined( 'ABSPATH' ) or die( 'Nice try - no script kiddies please!' );

/*---------------------------------------------------------------------------------------------------------------------------*/
/**
 * i18n
 */
/*--------------------------------------------------------------------------------------------------------------------------*/
load_plugin_textdomain('siconet-google-analytics-opt-out-link', false, basename( dirname( __FILE__ ) ) . '/languages' );

/*---------------------------------------------------------------------------------------------------------------------------*/
/**
 * Shortcode
 * Render a custom Google Analytics Opt Out Cookie Link
 */
/*--------------------------------------------------------------------------------------------------------------------------*/
function siconet_shortcode_google_optout_cookie_link($atts)
{
    extract(shortcode_atts(array(
        'title' => __('Für Google Analytics Opt-Out: Bitte klicken!', 'siconet-google-analytics-opt-out-link'),
        'alertmsg' => __('Google Cookies werden nicht mehr gespeichert.', 'siconet-google-analytics-opt-out-link'),
        'showalertafterclick' => true,
        'gaid' => 'UA-XXX',
        'cssclass' => 'siconet-google-analytics-opt-out-link'
    ), $atts));
    ob_start();
    ?>  
    <!-- Google Opt-Out Function -->
    <script>
      var gaProperty = '<?php echo $gaid; ?>';
      
      var disableStr = 'ga-disable-' + gaProperty; if (document.cookie.indexOf(disableStr + '=true') > -1) { window[disableStr] = true; }
      
        function gaOptout() { 
            document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/'; 
            window[disableStr] = true; 
            <?php if ($showalertafterclick == "true" || $showalertafterclick === true) : ?>
                alert('<?php echo $alertmsg; ?>');
            <?php endif; ?>
        }
    </script>
    <a href="javascript:gaOptout()" class="<?php echo $cssclass; ?>"><?php echo $title; ?></a>
    <?php
    return ob_get_clean();
}
add_shortcode('siconet_google_optout_cookie_link', 'siconet_shortcode_google_optout_cookie_link');