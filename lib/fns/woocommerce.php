<?php

namespace etec\woocommerce;

// REMOVE ADD TO CART MESSAGE
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

function woocommerce_checkout_content( $message, $order_id, $memberships ){
  return do_shortcode('[elementor-template id="3134621"]') . $message;
}
add_filter( 'woocommerce_memberships_thank_you_message', __NAMESPACE__ . '\\woocommerce_checkout_content', 10, 3 );

function woocommerce_dashboard_message(){
  echo do_shortcode('[elementor-template id="3134621"]');
}
add_action( 'woocommerce_account_dashboard', __NAMESPACE__ . '\\woocommerce_dashboard_message' );