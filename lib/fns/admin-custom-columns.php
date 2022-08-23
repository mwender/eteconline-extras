<?php

namespace eteconline\admincustomcolumns;

/**
 * Adds columns to the shop_subscription CPT
 *
 * @param      array  $columns  The columns
 *
 * @return     array  Filtered $columns array
 */
function set_shop_subscription_edit_columns( $columns ) {
  // Re-order columns
  $columns = array(
    'cb'                => '<input type="checkbox" />',
    'status'            => __( 'Status', 'woocommerce-subscriptions' ),
    'order_title'       => __( 'Subscription', 'woocommerce-subscriptions' ),
    'team'              => __( 'Team/Company', 'eteconline' ),
    'order_items'       => __( 'Items', 'woocommerce-subscriptions' ),
    'recurring_total'   => __( 'Total', 'woocommerce-subscriptions' ),
    'start_date'        => __( 'Start Date', 'woocommerce-subscriptions' ),
    'trial_end_date'    => __( 'Trial End', 'woocommerce-subscriptions' ),
    'next_payment_date' => __( 'Next Payment', 'woocommerce-subscriptions' ),
    'last_payment_date' => __( 'Last Order Date', 'woocommerce-subscriptions' ), // Keep deprecated 'last_payment_date' key for backward compatibility
    'end_date'          => __( 'End Date', 'woocommerce-subscriptions' ),
    'orders'            => _x( 'Orders', 'number of orders linked to a subscription', 'woocommerce-subscriptions' ),
  );

  return $columns;
}
add_filter( 'manage_edit-shop_subscription_columns', __NAMESPACE__ . '\\set_shop_subscription_edit_columns', 9999 );

/**
 * Displays content for shop_subscription CPT custom columns.
 *
 * @param      string  $column  The column
 */
function render_shop_subscription_columns( $column ){
  global $post, $the_subscription, $wp_list_table;
  if ( empty( $the_subscription ) || $the_subscription->get_id() != $post->ID ) {
    $the_subscription = wcs_get_subscription( $post->ID );
  }

  $output = null;
  switch( $column ){
    case 'team':
      $memberships = wc_memberships_get_memberships_from_subscription( $the_subscription->get_id() );
      $team_list = [];
      foreach( $memberships as $membership ){
        $user_id = $membership->user_id;
        $teams = wc_memberships_for_teams_get_teams( $user_id );
        foreach( $teams as $team ){
          $team_name = $team->get_name();
          $team_edit_url = get_edit_post_link( $team->get_id() );
          $team_link = '<a href="' . $team_edit_url . '">' . $team_name . '</a>';
          if( ! in_array( $team_link, $team_list ) )
            $team_list[] = $team_link;
        }
      }
      $output = ( ! empty( $team_list) )? '<ul style="list-style-type: disc; margin: 0;"><li>' . implode( '</li><li>', $team_list ) . '</li></ul>' : '' ;
      break;
  }

  echo $output;
}
add_action( 'manage_shop_subscription_posts_custom_column', __NAMESPACE__ . '\\render_shop_subscription_columns', 2 );