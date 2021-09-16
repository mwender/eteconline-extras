# ETEC Extras #
**Contributors:** [TheWebist](https://profiles.wordpress.org/TheWebist)  
**Donate link:** https://mwender.com/  
**Tags:** shortcodes  
**Requires at least:** 5.7  
**Tested up to:** 5.7.2  
**Requires PHP:** 7.4  
**Stable tag:** 0.4.6  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Extras for the East Tennessee Economic Council website.

## Description ##

This plugin provides extra functionality for the East Tennessee Economic Council website.

# ETEC Friday Events Shortcode #

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

## Changelog ##

### 0.4.6 ###
* Updating newsletter archive.

### 0.4.5 ###
* BUGFIX: Removing extra brace.

### 0.4.4 ###
* Updating hook we're using to display the account setup instructions we show immediately after checkout.
* Correcting the spelling of ACF field `woocommerce_checkout_before_order_review_message`.

### 0.4.3 ###
* Adding "WooCommerce Checkout Before Order Reivew Message" setting to ETEC Options.

### 0.4.2 ###
* Redirecting to user profile edit screen after new user registers from a team invitation.

### 0.4.1 ###
* Hooking WooCommerce Account Dashboard message to `woocommerce_account_dashboard` so that it will display immediately after placing an order and inside the customer order email.
* Reworking `lib/templates/woocommerce/myaccount/dashboard.php` to run the `woocommerce_account_dashboard` action further up the page.

### 0.4.0 ###
* Updating `get_alert()` to use a Handlebars template.
* Adding ETEC Settings page.
* Using ETEC Settings to specify which Elementor template to render inside WooCommerce views.

### 0.3.0 ###
* Adding feed processing for GravityForms child forms.
* Outputting content on the WooCommerce checkout screen.

### 0.2.0 ###
* Adding `[friday_events/]` shortcode for listing ETEC Friday Events.
* Updating NPM packages.

### 0.1.2 ###
* Opening Newsletter Archive links in a new tab/window.

### 0.1.1 ###
* Updating zordius/lightncandy (Handlebars library) composer dependency.

### 0.1.0 ###
* First commit.
* Adding Newsletter Archive shortcodes.
