<?php

namespace eteconline\woocommerce;
use function eteconline\utilities\{get_alert};

/**
 * Remove the default "Add to Cart" message.
 */
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

/**
 * Add `lib/templates/woocommerce` as a location WooCommerce looks for templates.
 *
 * @param      string  $template       The template
 * @param      string  $template_name  The template name
 * @param      string  $template_path  The template path
 *
 * @return     string  The template
 */
function woocommerce_templates( $template, $template_name, $template_path ) {
  global $woocommerce;
  $_template = $template;
  if ( ! $template_path )
    $template_path = $woocommerce->template_url;

  $plugin_path  = ETEC_PLUGIN_PATH . 'lib/templates/woocommerce/';

  if( file_exists( $plugin_path . $template_name ) )
    $template = $plugin_path . $template_name;

  if ( ! $template )
    $template = $_template;

  return $template;
}
add_filter( 'woocommerce_locate_template', __NAMESPACE__ . '\\woocommerce_templates', 1, 3 );

/**
 * Renders an Elementor template on the WooCommerce checkout screen. Requires WooCommerce Memberships.
 *
 * @param      string  $message      The message
 * @param      int     $order_id     The order identifier
 * @param      array   $memberships   Array of the memberships
 *
 * @return     string  HTML to display on the WooCommerce checkout screen.
 */
function woocommerce_checkout_content( $message, $order_id, $memberships ){
  $template = get_field( 'woocommerce_memberships_thank_you_message', 'option' );
  if( $template ){
    return do_shortcode( '[elementor-template id="' . $template->ID . '"]' ) . $message;
  } else {
    $user = wp_get_current_user();
    if( current_user_can( 'activate_plugins' ) ){
      return get_alert(['type' => 'info', 'title' => 'No Template Set', 'description' => 'Fill this area with any content you desire by 1) creating an Elementor template with the content, and 2) Going to "ETEC Settings" and specifying the template for the "WooCommerce Account Dashboard Message".']) . $message;
    }
  }
  return $message;
}
add_filter( 'woocommerce_memberships_thank_you_message', __NAMESPACE__ . '\\woocommerce_checkout_content', 10, 3 );

/**
 * Renders an Elementor template on the WooCommerce Dashboard.
 */
function woocommerce_dashboard_message(){
  $template = get_field( 'woocommerce_account_dashboard_message', 'option' );
  if( $template ){
    echo do_shortcode( '[elementor-template id="' . $template->ID . '"]' );
  } else {
    $user = wp_get_current_user();
    if( current_user_can( 'activate_plugins' ) ){
      echo get_alert(['type' => 'info', 'title' => 'No Template Set', 'description' => 'Fill this area with any content you desire by 1) creating an Elementor template with the content, and 2) Going to "ETEC Settings" and specifying the template for the "WooCommerce Account Dashboard Message".']);
    }
  }
}
add_action( 'etec_dashboard_message', __NAMESPACE__ . '\\woocommerce_dashboard_message' ); //woocommerce_account_dashboard