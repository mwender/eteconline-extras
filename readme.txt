=== ETEC Extras ===
Contributors: TheWebist
Donate link: https://mwender.com/
Tags: shortcodes
Requires at least: 5.7
Tested up to: 5.8.3
Requires PHP: 7.4
Stable tag: 1.6.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Extras for the East Tennessee Economic Council website.

== Description ==

This plugin provides extra functionality for the East Tennessee Economic Council website.

=== ETEC Friday Events Shortcode ===

Use `[friday_events/]` to display a listing of events from the "ETEC Friday Events" category in The Events Calendar.

```
/**
 * Displays events from the ETEC Friday Events category.
 *
 * @param      array  $atts {
 *   @type  integer  $numberposts The number of posts shown.
 *   @type  string   $order       The order of the posts. Defauts to ASC.
 *   @type  terms    $terms       The terms to filter by. Defaults to "friday-etec-meetings".
 * }
 */
```

== Changelog ==

= 1.6.3 =
* Adding admin notice to `[friday_events]` indicating the content has been pulled from the transient cache.

= 1.6.2 =
* Updating `[friday_events]` transient timeout to `6 * HOUR_IN_SECONDS`.

= 1.6.1 =
* Storing `[friday_events]` HTML as transient to reduce on page queries.

= 1.6.0 =
* If user has role "Content Only Subscriber", that user can't see orders for their Team.

= 1.5.0 =
* Adding "Team/Company" column to admin `shop_subscription` CPT listing.
* Preventing fatal error by checking for The Events Calendar plugin in `[friday_events /]` shortcode callback.

= 1.4.0 =
* Adding `add_additional_orders_to_current_user()` which is hooked to `woocommerce_account_dashboard` and `woocommerce_account_content` so that `additional_orders` will get populated when users view "My Account" and "My Account > Orders".

= 1.3.2 =
* Correcting "Disable Emails" notice to reference "Post SMTP" instead of "Offload SES".

= 1.3.1 =
* Updating "Disable Emails" to deactivate/activate the Post SMTP plugin.

= 1.3.0 =
* Updating "Disable Emails" switch to work by activating the Disable Emails plugin and deactivating WP Offload SES.

= 1.2.0 =
* Adding WC Memberships Team CPT options via ACF.

= 1.1.0 =
* Adding "WC Email Settings" option pages.
* Adding options page for subscription renewal emails.
* Adding Email Subject, HTML Header, and Body Copy settings for customer renewal emails.

= 1.0.0 =
* Adding "Additional Emails" option for WooCommerce Subscriptions.

= 0.9.0 =
* Adding timestamp and user meta for "WooCommerce order emails are currently disabled" message.
* Adding ACF field for Customer Renewal Invoice Email.

= 0.8.0 =
* Allowing all members of a Team to view and pay for invoices associated with that Team's subscription.

= 0.7.1 =
* Adding default value to "Team Name" to allow for checkout of Manual Payment orders with Team Subscriptions in the order.

= 0.7.0 =
* Checking user's shopping cart for any products in the "Memberships" Product Category before displaying `woocommerce_thankyou_content` under "Your Order".

= 0.6.3 =
* Last sync of newsletters before launch.

= 0.6.2 =
* Updating `lib/fns/newsletters.php` with latest newsletter references.

= 0.6.1 =
* Updating Newsletter archive

= 0.6.0 =
* Adding "Password Reset Email Message" option to "ETEC Settings".

= 0.5.0 =
* Adding option to disable WooCommerce Order Emails while working in the admin.

= 0.4.9 =
* Checking if `$_GET['action']` is set before displaying `login_message`.

= 0.4.8 =
* Adding `login_message` filter for adding an Elementor template above the wp-login.php login form.

= 0.4.7 =
* Updating `lib/fns/newsletters.php` to include the most recently added newsletters.

= 0.4.6 =
* Updating newsletter archive.

= 0.4.5 =
* BUGFIX: Removing extra brace.

= 0.4.4 =
* Updating hook we're using to display the account setup instructions we show immediately after checkout.
* Correcting the spelling of ACF field `woocommerce_checkout_before_order_review_message`.

= 0.4.3 =
* Adding "WooCommerce Checkout Before Order Reivew Message" setting to ETEC Options.

= 0.4.2 =
* Redirecting to user profile edit screen after new user registers from a team invitation.

= 0.4.1 =
* Hooking WooCommerce Account Dashboard message to `woocommerce_account_dashboard` so that it will display immediately after placing an order and inside the customer order email.
* Reworking `lib/templates/woocommerce/myaccount/dashboard.php` to run the `woocommerce_account_dashboard` action further up the page.

= 0.4.0 =
* Updating `get_alert()` to use a Handlebars template.
* Adding ETEC Settings page.
* Using ETEC Settings to specify which Elementor template to render inside WooCommerce views.

= 0.3.0 =
* Adding feed processing for GravityForms child forms.
* Outputting content on the WooCommerce checkout screen.

= 0.2.0 =
* Adding `[friday_events/]` shortcode for listing ETEC Friday Events.
* Updating NPM packages.

= 0.1.2 =
* Opening Newsletter Archive links in a new tab/window.

= 0.1.1 =
* Updating zordius/lightncandy (Handlebars library) composer dependency.

= 0.1.0 =
* First commit.
* Adding Newsletter Archive shortcodes.
