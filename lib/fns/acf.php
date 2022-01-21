<?php

if( function_exists( 'acf_add_options_page') ){
  acf_add_options_page([
    'page_title'  => 'ETEC General Settings',
    'menu_title'  => 'ETEC Settings',
    'menu_slug'   => 'etec-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ]);
}

function etec_save_post( $post_id ) {
  uber_log('👉🚀 Running etec_save_post()');
  $screen = get_current_screen();
  if( strpos( $screen->id, 'etec-general-settings' ) == true ){

    if( $_POST['acf']['field_61523b3702744'] && true == $_POST['acf']['field_61523b3702744'] ){
      uber_log('👉🚀 WC Disable Order Emails value = ' . $_POST['acf']['field_61523b3702744'] );

      // Update the field for the current time
      update_field( 'field_61eb18daa3d66', current_time( 'm/d/Y g:i a' ), 'option' );

      // Update the field for the current username
      $current_user = wp_get_current_user();
      update_field( 'field_61eb1c9c97bb1', $current_user->user_login, 'option' );

    } else {
      // Remove timestamp and username
      update_field('field_61eb18daa3d66', null, 'option' );
      update_field( 'field_61eb1c9c97bb1', null, 'option' );
    }
  }
}
add_filter('acf/save_post' , 'etec_save_post', 10, 1 );