<?php

namespace eteconline\woocommercesubscriptions;

/**
 * Adds additional receipients to the email sent for subscription renewals.
 *
 * Special thanks: https://anchor.host/multiple-email-recipients-for-woocommerce-subscriptions/
 *
 * @param      string  $recipient  The recipient
 * @param      object  $order      The order
 *
 * @return     string  Comma separated list of recipients for the subscription.
 */
function woocommerce_email_customer_invoice_add_recipients( $recipient, $order ) {

    // Finds subscription for the order
    $subscription = wcs_get_subscriptions_for_order( $order, array( 'order_type' => array( 'parent', 'renewal' ) ) );

    if ( $subscription and array_values($subscription)[0] ) {
        // Find first subscription ID
        $subscription_id = array_values($subscription)[0]->id;
        // Check ACF field for additional emails
        $additional_emails = get_field('additional_emails', $subscription_id);

        if ($additional_emails) {
            // Found additional emails so add them to the $recipients list
            $recipient .= ', ' . $additional_emails;
        }
    }
    return $recipient;
}
add_filter( 'woocommerce_email_recipient_customer_completed_renewal_order', __NAMESPACE__ . '\\woocommerce_email_customer_invoice_add_recipients', 10, 2 );
add_filter( 'woocommerce_email_recipient_customer_renewal_invoice', __NAMESPACE__ . '\\woocommerce_email_customer_invoice_add_recipients', 10, 2 );
