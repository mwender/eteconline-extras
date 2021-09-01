<?php

namespace etec\woocommerce;

// REMOVE ADD TO CART MESSAGE
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

function woocommerce_checkout_content( $message, $order_id, $memberships ){
  return do_shortcode('[elementor-template id="3134621"]') . $message;
}
add_filter( 'woocommerce_memberships_thank_you_message', __NAMESPACE__ . '\\woocommerce_checkout_content', 10, 3 );

function woocommerce_dashboard_message(){
  echo do_shortcode('[elementor-template id="3134621"]');
}
add_action( 'woocommerce_account_dashboard', __NAMESPACE__ . '\\woocommerce_dashboard_message' );