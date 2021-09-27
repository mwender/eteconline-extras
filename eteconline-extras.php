<?php
/**
 * Plugin Name:     ETEC Online Extras
 * Plugin URI:      https://github.com/mwender/eteconline-extras
 * Description:     Various extensions for the ETEC website
 * Author:          TheWebist
 * Author URI:      https://mwender.com
 * Text Domain:     eteconline-extras
 * Domain Path:     /languages
 * Version:         0.4.7
 *
 * @package         Eteconline_Extras
 */

// Your code starts here.
$css_dir = ( stristr( site_url(), '.local' ) || SCRIPT_DEBUG )? 'css' : 'dist' ;
define( 'ETEC_CSS_DIR', $css_dir );
define( 'ETEC_DEV_ENV', stristr( site_url(), '.local' ) );
define( 'ETEC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ETEC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load Composer dependencies
if( file_exists( ETEC_PLUGIN_PATH . 'vendor/autoload.php' ) ){
  require_once ETEC_PLUGIN_PATH . 'vendor/autoload.php';
} else {
  add_action( 'admin_notices', function(){
    $class = 'notice notice-error';
    $message = __( 'Missing required Composer libraries. Please run `composer install` from the root directory of this plugin.', 'eteconline' );
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
  } );
}


// Load required files
require_once( ETEC_PLUGIN_PATH . 'lib/fns/acf.php' );
require_once( ETEC_PLUGIN_PATH . 'lib/fns/acf-json-save-point.php' );
require_once( ETEC_PLUGIN_PATH . 'lib/fns/enqueues.php' );
require_once( ETEC_PLUGIN_PATH . 'lib/fns/gravityforms.php' );
require_once( ETEC_PLUGIN_PATH . 'lib/fns/shortcodes.php' );
require_once( ETEC_PLUGIN_PATH . 'lib/fns/templates.php' );
require_once( ETEC_PLUGIN_PATH . 'lib/fns/utilities.php' );
require_once( ETEC_PLUGIN_PATH . 'lib/fns/woocommerce.php' );

/**
 * Enhanced logging.
 *
 * @param      string  $message  The log message
 */
if( ! function_exists( 'uber_log' ) ){
  function uber_log( $message = null ){
    static $counter = 1;

    $bt = debug_backtrace();
    $caller = array_shift( $bt );

    if( 1 == $counter )
      error_log( "\n\n" . str_repeat('-', 25 ) . ' STARTING DEBUG [' . date('h:i:sa', current_time('timestamp') ) . '] ' . str_repeat('-', 25 ) . "\n\n" );
    error_log( "\n" . $counter . '. ' . basename( $caller['file'] ) . '::' . $caller['line'] . "\n" . $message . "\n---\n" );
    $counter++;
  }
}


function download_newsletters(){
  require_once( ETEC_PLUGIN_PATH . 'newsletters.php' );
  foreach( $newsletters as $newsletter ){
    $timestamp = strtotime( $newsletter['date'] );
    $date = date( 'Y-m-d', $timestamp );
    uber_log('🔔 $date = ' . $date . "\nTitle = " . $newsletter['title'] . "\nURL = " . $newsletter['url'] );
    shell_exec( 'wget --output-document ' . ETEC_PLUGIN_PATH . 'lib/html/newsletters/' . $date . '.html "' . html_entity_decode( $newsletter['url'] ) . '"' );
  }
}