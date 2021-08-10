<?php
namespace eteconline\shortcodes;
use function eteconline\utilities\{get_alert};
use function eteconline\templates\{render_template};

/**
 * Displays a newsletter from the legacy archive
 *
 * @return     string  HTML for the newsletter.
 */
function display_newsletter(){
  if( isset( $_GET['date'] ) ){
    if( ! preg_match( '/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $_GET['date'] ) )
      return get_alert( ['title' => 'Invalid `date`', 'description' => 'The date provided for the newsletter is invalid. Please check the link you used to access this page.'] );
    $date = $_GET['date'];
    $timestamp = strtotime( $date );
    $formatted_date = date( 'Y-m-d', $timestamp );

    $filename = ETEC_PLUGIN_PATH . 'lib/html/newsletters/' . $formatted_date . '.html';
    if( ! file_exists( $filename ) )
      return get_alert( ['title' => 'Newsletter not found!', 'description' => 'I could not find a newsletter for the date you provided. Filename = ' . $filename ] );
    $newsletter = file_get_contents( $filename );
    $newsletter = str_replace( '</html>', '<style>.mailpoet_header{display: none;}</style></html>', $newsletter );
    return $newsletter;
  } else {
    require( plugin_dir_path( __FILE__ ) . 'newsletters.php' );
    foreach( $newsletters as $key => $newsletter ){
      $timestamp = strtotime( $newsletter['date'] );
      $newsletter['formatted_date'] = date( 'Y-m-d', $timestamp );

      $newsletter['permalink'] = site_url('etec-newsletter/?date=' . $newsletter['formatted_date'] );
      $newsletters[$key] = $newsletter;
    }
    $data['newsletters'] = $newsletters;

    return render_template( 'newsletter-archive-page', $data );
  }
}
add_shortcode( 'legacy_display_newsletter', __NAMESPACE__ . '\\display_newsletter' );

/**
 * Displays a listing of past newsletters stored inside lib/html/newsletters/.
 *
 * @return     string  HTML for our newletter archive.
 */
function newsletter_archive(){
  require( plugin_dir_path( __FILE__ ) . 'newsletters.php' );
  foreach( $newsletters as $key => $newsletter ){
    $timestamp = strtotime( $newsletter['date'] );
    $newsletter['formatted_date'] = date( 'Y-m-d', $timestamp );

    $newsletter['permalink'] = site_url('etec-newsletter/?date=' . $newsletter['formatted_date'] );
    $newsletters[$key] = $newsletter;
  }
  $data['newsletters'] = $newsletters;

  return render_template( 'newsletter-archive-list', $data );
}
add_shortcode( 'legacy_newsletter_archive', __NAMESPACE__ . '\\newsletter_archive' );

/**
 * Show a listing of child pages.
 *
 * @param      array  $atts {
 *   @type  string  $orderby    The column we are ordering by. Defaults to "menu_order".
 *   @type  string  $sort       How we are ordering the results. Defaults to ASC.
 *   @type  string  $parent     The page of the child pages we want to list. Defaults to `null`.
 * }
 *
 * @return     string  HTML for the subpage list.
 */
function subpage_list( $atts ){
  $args = shortcode_atts( [
    'orderby' => 'menu_order',
    'sort'    => 'ASC',
    'parent'  => null,
  ], $atts );

  global $post;
  $query_args = [
    'parent'      => $post->ID,
    'sort_column' => $args['orderby'],
    'sort_order'  => $args['sort'],
  ];

  if( ! is_null( $args['parent'] ) ){
    $args['parent'] = html_entity_decode( $args['parent'] );
    $parent = get_page_by_title( $args['parent'] );
    if( $parent )
      $query_args['parent'] = $parent->ID;
  }

  $pages = get_pages( $query_args );
  foreach( $pages as $page ){
    $data['pages'][] = [
      'permalink' => get_page_link( $page->ID ),
      'title'     => get_the_title( $page->ID ),
    ];
  }

  return render_template( 'subpage-list', $data );
}
add_shortcode( 'subpage_list', __NAMESPACE__ . '\\subpage_list' );
