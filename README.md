# ETEC Extras #
**Contributors:** [TheWebist](https://profiles.wordpress.org/TheWebist)  
**Donate link:** https://mwender.com/  
**Tags:** shortcodes  
**Requires at least:** 5.7  
**Tested up to:** 5.7.2  
**Requires PHP:** 7.4  
**Stable tag:** 0.2.0  
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
