<?php

namespace eteconline\customcolumns;

/**
 * Adds columns to the Team Member CPT
 *
 * @param      array  $columns  The columns
 *
 * @return     array  Filtered $columns array
 */
function set_team_member_edit_columns($columns) {
  $columns['photo']       = __( 'Photo', 'eteconline' );
  $columns['email']       = __( 'Email', 'eteconline' );
  $columns['staff_type']  = __( 'Staff Type(s)', 'eteconline' );
  $columns['title']       = __( 'Name', 'eteconline' );

  // Re-order columns
  $columns = [
    'cb' => $columns['cb'],
    'photo' => $columns['photo'],
    'title' => $columns['title'],
    'staff_type' => $columns['staff_type'],
  ];
  return $columns;
}
add_filter( 'manage_team_member_posts_columns', __NAMESPACE__ . '\\set_team_member_edit_columns' );

/**
 * Populates the custom columns for the Team Member CPT admin listing.
 *
 * @param      string  $column   The column
 * @param      int     $post_id  The post identifier
 */
function custom_team_member_column( $column, $post_id ){
  switch( $column ){
    case 'title':
      $title = get_post_meta( $post_id, 'title', true );
      echo $title;
      break;

    case 'photo':
      if( has_post_thumbnail( $post_id ) )
        the_post_thumbnail('thumbnail', ['style' => 'width: 48px; height: 48px;'] );
      break;

    case 'staff_type':
      $staff_types = get_the_term_list( $post_id, 'staff_type' );
      if( is_string( $staff_types ) )
        echo $staff_types;
      break;
  }
}
add_action( 'manage_team_member_posts_custom_column', __NAMESPACE__ . '\\custom_team_member_column', 10, 2 );