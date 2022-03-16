<?php

namespace eteconline\woocommerce;
use function eteconline\utilities\{get_alert};

/**
 * Remove the default "Add to Cart" message.
 */
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

/**
 * Filter the new order email from WooCommerce.
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
/* 01/18/2022 (16:14) - CONTINUE HERE
function filter_new_order_email( $order, $sent_to_admin, $plain_text, $email ){

}
add_action( 'woocommerce_email_order_details', __NAMESPACE__ . '\\filter_new_order_email', 20, 4 );
/**/

/**
 * Renders an Elementor template just before the "Your Order" and payment fields during a WooCommerce checkout.
 */
function checkout_before_order_review(){

  // Check cart for any memberships
  $cart_has_membership = false;
  foreach( \WC()->cart->get_cart() as $cart_item_key => $cart_item ){
    $product_id = $cart_item['product_id'];
    if( has_term( 'memberships', 'product_cat', $product_id ) )
      $cart_has_membership = true;
  }

  if( ! $cart_has_membership )
    return;

  $template = get_field( 'woocommerce_checkout_before_order_review_message', 'option' );
  if( $template ){
    echo do_shortcode( '[elementor-template id="' . $template->ID . '"]' );
  } else {
    $user = wp_get_current_user();
    if( current_user_can( 'activate_plugins' ) ){
      echo get_alert(['type' => 'info', 'title' => 'No Template Set', 'description' => 'Fill this area with any content you desire by 1) creating an Elementor template with the content, and 2) Going to "ETEC Settings" and specifying the template for the "WooCommerce Checkout Before Order Reivew Message".']);
    }
  }
}
add_action( 'woocommerce_checkout_before_order_review', __NAMESPACE__ . '\\checkout_before_order_review', 99 );

/**
 * Prevents the "Field 'Team Name' is a required field." error duing checkout for subscription renewals with Manual Payment.
 *
 * @param      array   $fields   The fields
 * @param      object  $product  The product object
 */
function filter_memberships_for_teams_product_fields( $fields, $product ){
  foreach ( $fields as $key => $field ) {
    if( 'team_name' == $key && ! empty( $field['required'] ) ){
      if( ! isset( $_REQUEST['team_name'] ) || empty( $_REQUEST['team_name'] ) )
        $_REQUEST['team_name'] = 'Your Team Name goes here';
    }
  }
}
add_filter( 'wc_memberships_for_teams_product_team_user_input_fields', __NAMESPACE__ . '\\filter_memberships_for_teams_product_fields', 10, 2 );

/**
 * Filters the URL for redirecting a team member that just joined by inviation.
 *
 * Redirects to the User Profile edit screen.
 *
 * @param      string  $redirect_to  The URL to redirect to
 * @param      object  $team         The team object
 * @param      object  $invitation   The invitation object
 */
function get_team_member_joined_redirect_url( $redirect_to, $team, $invitation ){
  $current_user = wp_get_current_user();
  $edit_profile_url = site_url( 'members/' . $current_user->user_login . '/profile/edit/' );
  return $edit_profile_url;
}
add_filter( 'wc_memberships_for_teams_join_team_redirect_to', __NAMESPACE__ . '\\get_team_member_joined_redirect_url', 10, 3 );

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

  // Override specific third-party plugin email templates:
  $template_filename = basename( $template );
  switch ( $template_filename ) {
    case 'customer-completed-renewal-order.php':
      return ETEC_PLUGIN_PATH . 'lib/templates/woocommerce-subscriptions/emails/customer-completed-renewal-order.php';
      break;
  }

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
function woocommerce_thankyou_content( $order_id ){
  $template = get_field( 'woocommerce_memberships_thank_you_message', 'option' );

  if ( $order_id instanceof \WC_Order )
    $order_id = $order_id->get_id();

  if ( is_numeric( $order_id ) ) {
    $memberships = wc_memberships_get_order_access_granted_memberships( $order_id );
    if( empty( $memberships ) )
      return false;
  }

  $html = '';
  if( $template ){
    $html = do_shortcode( '[elementor-template id="' . $template->ID . '"]' );
  } else {
    $user = wp_get_current_user();
    if( current_user_can( 'activate_plugins' ) ){
      $html = get_alert(['type' => 'info', 'title' => 'No Template Set', 'description' => 'Fill this area with any content you desire by 1) creating an Elementor template with the content, and 2) Going to "ETEC Settings" and specifying the template for the "WooCommerce Account Dashboard Message".']);
    }
  }
  echo $html;
}
add_action( 'woocommerce_thankyou', __NAMESPACE__ . '\\woocommerce_thankyou_content', 10 );

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
add_action( 'woocommerce_account_dashboard', __NAMESPACE__ . '\\woocommerce_dashboard_message' );