<?php

namespace eteconline\memberships;

/**
 * Allowing our ACF options for show for WC Memberships Teams CPTs.
 *
 * @param      array   $allowed_meta_box_ids  The allowed meta box identifiers
 * @param      string  $post_type             The post type
 *
 * @return     array  Filtered array of allowed meta box IDs.
 */
function filter_allowed_metaboxes_for_teams( $allowed_meta_box_ids, $post_type ){
  $allowed_meta_box_ids[] = 'acf-group_622f812467eee';

  return $allowed_meta_box_ids;
}
add_filter( 'wc_memberships_for_teams_allowed_meta_box_ids', __NAMESPACE__ . '\\filter_allowed_metaboxes_for_teams', 10, 2 );

/**
 * Modifies the list of orders shown in the Customer's Recent Orders.
 *
 * @param      array  $q      The query
 *
 * @return     array  The filtered query
 */
function modify_my_order_query( $q ) {
  global $wpdb;
  $current_user_id = get_current_user_id();

  $user_meta = get_userdata( $current_user_id );
  $user_roles = $user_meta->roles;

  // Users with role `ContentOnly` can't view order details:
  if( is_array( $user_roles ) && in_array( 'content-only-subscriber', $user_roles ) ){
    return $q;
  }

  // Check if the user has additional orders
  $secondary_post_ids = get_user_meta( $current_user_id, 'additional_orders', false );
  if ( ! empty( $secondary_post_ids ) && ! empty( $secondary_post_ids[0] ) ) {

    // Get All Orders ID for the main customers
    $prepare_query = $wpdb->prepare(
      " SELECT post_id  FROM {$wpdb->postmeta} WHERE meta_key LIKE %s and meta_value LIKE %d ",
      '_customer_user',
      $current_user_id
    );
    $results       = $wpdb->get_results( $prepare_query, ARRAY_A );
    $main_post_ids = wp_list_pluck( $results, 'post_id' );

    // Merge All Orders IDs
    $all_posts_ids = ( isset( $secondary_post_ids[0] ) ) ? array_merge( $main_post_ids, $secondary_post_ids[0] ) : $main_post_ids;
    foreach ( $secondary_post_ids[0] as $key => $order_id ) {
      $order = wc_get_order( $order_id );
      if( $order ){
        // The following WC Order method does not work:
        //$order->set_customer_id( $current_user_id );

        // Set the order meta associated with the customer
        update_post_meta( $order_id, '_customer_user',$current_user_id );
        $current_user = wp_get_current_user();
        update_post_meta( $order_id, '_billing_email', $current_user->user_email );
      } else {
        uber_log('👉 ERROR $order = ' . $order );
      }
    }

    //Modify the my Order Query to include all orders ID including the additional ones
    unset( $q['customer'] );
    $q['post__in'] = $all_posts_ids;
  }

  return $q;
}
add_filter( 'woocommerce_my_account_my_orders_query',  __NAMESPACE__ . '\\modify_my_order_query'  , 20, 1 );

/**
 * Updates the user's capabilities.
 *
 * Gives users the capability to view their "additional invoices"
 * and pay for them.
 *
 * @param      array   $allcaps  The user's capabilities
 * @param      string  $cap      The capability
 * @param      array   $args     The arguments
 *
 * @return     array   Filtered array of the user's capabilities.
 */
function give_permissions( $allcaps, $cap, $args ) {
    $capabilities = [ 'view_order', 'pay_for_order' ];
    if ( isset( $cap[0] ) && in_array( $cap[0], $capabilities ) ) { // $cap[0] == 'view_order'
        $get_additional_ids = get_user_meta( get_current_user_id(), 'additional_orders', false );
        if ( isset( $get_additional_ids[0] ) && in_array( $args[2], $get_additional_ids[0] ) ) {
            $allcaps[ $cap[0] ] = true;
        }
    }
    return ( $allcaps );
}
add_filter( 'user_has_cap', __NAMESPACE__ .  '\\give_permissions'  , 10, 3 );

/**
 * Adds all orders associated with a subscription to each team member.
 *
 * @param      object  $team   The team
 */
function add_additional_orders_to_each_team_member( $team, $echo_note = true ){
  // Get all orders associated with this team.
  $team_id = is_object( $team ) ? $team->get_id() : $team;
  $subscription_id =  get_post_meta( $team_id, '_subscription_id', true );
  $subscription = wcs_get_subscription( $subscription_id );;
  if( $subscription ){
    $orders = $subscription->get_related_orders();
    if( $orders ){
      foreach( $orders as $order_id ){
        $orders_array[] = $order_id;
      }
    }
  }
  //uber_log( '📄 Orders associated with this team: ' . print_r( $orders_array, true ) );

  // Add the orders for this subscription to each user's `additional_orders` meta field.
  $team_members = wc_memberships_for_teams_get_team_members( $team );
  if( $team_members ){
    foreach( $team_members as $member ){
      $user = $member->get_user();
      $status = update_user_meta( $user->ID, 'additional_orders', $orders_array );
      //uber_log( '🔔 Updating additional_orders for User ' . $user->ID . ' (status: ' . $status . ')' );
    }
    if( $echo_note )
      echo '<p>All orders associated with this team have been added as <code>additional_orders</code> to each member of this team.</p>';
  }
}
add_action( 'wc_memberships_for_teams_after_team_billing_details', __NAMESPACE__ . '\\add_additional_orders_to_each_team_member' );

/**
 * Adds all orders associated with any teams the user is a member of to the user's `additional_orders`.
 */
function add_additional_orders_to_current_user(){
  $current_user_id = get_current_user_id();

  if( false === ( $additional_orders = get_transient( 'additional_orders_timestamp_' . $current_user_id ) ) ){
    $teams = wc_memberships_for_teams_get_teams( $current_user_id );
    foreach( $teams as $team ){
      add_additional_orders_to_each_team_member( $team, false );
    }
    $additional_ids = get_user_meta( get_current_user_id(), 'additional_orders', false );
    uber_log( '🔔 add_additional_orders_to_current_user() $additional_ids = ' . print_r($additional_ids,true) );
    $timestamp = current_time( 'timestamp' );
    set_transient( 'additional_orders_timestamp_' . $current_user_id, $timestamp, 6 * HOUR_IN_SECONDS );
  } else {
    $additional_ids = get_user_meta( get_current_user_id(), 'additional_orders', false );
    uber_log( '🔔 add_additional_orders_to_current_user() $additional_ids = ' . print_r($additional_ids,true) );
  }
}
add_action( 'woocommerce_account_dashboard', __NAMESPACE__ . '\\add_additional_orders_to_current_user' );
add_action( 'woocommerce_account_content', __NAMESPACE__ . '\\add_additional_orders_to_current_user' );