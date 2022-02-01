<?php
/**
 * Customer completed renewal order email
 *
 * @author  Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php
$completed_order_renewal_email_body = get_field( 'completed_order_renewal_email_body', 'option' );
if( $completed_order_renewal_email_body ){
  echo '<p>' . esc_html( $completed_order_renewal_email_body ) . '</p>';
} else {
  esc_html_e( 'We have finished processing your subscription renewal order.', 'woocommerce-subscriptions' );
}
?></p>


<?php
do_action( 'woocommerce_subscriptions_email_order_details', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
  echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
