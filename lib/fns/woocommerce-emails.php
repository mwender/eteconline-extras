<?php

namespace eteconline\woocommerceemails;

if( function_exists( 'acf_add_options_page' ) ){
  acf_add_options_page([
    'page_title'  => 'WooCommerce Email Settings',
    'menu_title'  => 'WC Email Settings',
    'menu_slug'   => 'wc-email-settings',
    'capability'  => 'edit_posts',
    'redirect'    => true,
    'icon_url'    => 'dashicons-email',
  ]);

  acf_add_options_sub_page([
    'page_title'  => 'Subscription Renewal Emails',
    'menu_title'  => 'Subscription Renewals',
    'parent_slug' => 'wc-email-settings',
  ]);
}

/**
 * Filters the email subject for a Customer Renewal Order email.
 *
 * @param      string  $subject       The subject
 * @param      object  $order         The order object
 *
 * @return     string  The filtered email subject.
 */
function filter_wc_subject_customer_renewal_order( $subject, $order ){
  $new_subject = get_field( 'subject_customer_renewal_order', 'option' );
  if( $new_subject ){
    $subject = $new_subject;
    $search = ['{order_date}','{blogname}'];
    $order_date = new \DateTime( $order->order_date );
    $replace = [ $order_date->format( 'M j, Y' ), get_bloginfo( 'blogname' ) ];
    $subject = str_replace( $search, $replace, $subject );
  }

  return $subject;
}
add_filter( 'woocommerce_subscriptions_email_subject_customer_completed_renewal_order', __NAMESPACE__ . '\\filter_wc_subject_customer_renewal_order', 10, 2 );

/**
 * Filters the HTML heading text at the top of Customer Renewal Order emails.
 *
 * @param      string  $heading       The heading
 * @param      object  $email_object  The email object
 *
 * @return     string  Filtered heading text
 */
function filter_wc_heading_customer_renewal_order( $heading, $email_object ){
  $new_heading = get_field( 'customer_renewal_order_heading', 'option' );
  if( $new_heading )
    $heading = $new_heading;

  return $heading;
}
add_filter( 'woocommerce_email_heading_customer_renewal_order', __NAMESPACE__ . '\\filter_wc_heading_customer_renewal_order', 10, 2 );