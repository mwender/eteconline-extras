<?php

namespace eteconline\wplogin;

/**
 * Renders an Elementor template on wp-login.php just above the login form.
 *
 * @param      string  $message  The message
 *
 * @return     string  The filtered message.
 */
function filter_login_message( $message ){
  $template = get_field( 'wplogin_message', 'option' );
  if( $template && ! isset( $_GET['action'] ) ){
    $message = '<div class="login-heading"><h2>Sign In</h2></div>';
    $message.= do_shortcode( '[elementor-template id="' . $template->ID . '"]' );
  }
  return $message;
}
add_filter( 'login_message', __NAMESPACE__ . '\\filter_login_message', 10 );

/**
 * Filters the password reset message.
 *
 * @param      string  $message     The message
 * @param      string  $key         The key
 * @param      string  $user_login  The user login
 * @param      object  $user_data   The user data
 *
 * @return     string  The filtered password reset message.
 */
function filter_password_reset_message( $message, $key, $user_login, $user_data ){
  if ( is_multisite() ) {
    $site_name = get_network()->site_name;
  } else {
    /*
     * The blogname option is escaped with esc_html on the way into the database
     * in sanitize_option we want to reverse this for the plain text arena of emails.
     */
    $site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
  }

  $reset_url = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' );

  $message = get_field( 'password_reset_message', 'option' );
  if( $message ){
    $search = [ '{{sitename}}', '{{reset_url}}', '{{username}}' ];
    $replace = [ $site_name, $reset_url, $user_login ];
    $message = str_replace( $search, $replace, $message );
  } else {
    $message = '<p>' . __( 'Someone has requested a password reset for the following account:', 'buddyboss' ) . '</p>';
    /* translators: %s: site name */
    $message .= '<p>' . sprintf( __( 'Site Name: <b>%s</b>', 'buddyboss' ), $site_name ) . '</p>';
    /* translators: %s: user login */
    $message .= '<p>' . sprintf( __( 'Username: <b>%s</b>', 'buddyboss' ), $user_login ) . '</p>';
    $message .= '<p>' . __( 'If this was a mistake, just ignore this email and nothing will happen.', 'buddyboss'  ) . '</p>';
    $message .= '<p>' . sprintf( __( 'To reset your password <a href="%s">Click here</a>.', 'buddyboss' ), $reset_url ) . '</p>';
  }

  $message = bp_email_core_wp_get_template( $message, $user_data );
  add_filter( 'wp_mail_content_type', 'bp_email_set_content_type' ); //add this to support html in email
  return $message;
}
add_filter( 'retrieve_password_message', __NAMESPACE__ . '\\filter_password_reset_message', 10, 4 );
remove_filter( 'retrieve_password_message', 'bp_email_retrieve_password_message', 10, 4 );