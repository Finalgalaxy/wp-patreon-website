___ BENTO

Contributors: satoristudio
Tags: one-column, two-columns, right-sidebar, left-sidebar, grid-layout, custom-background, custom-colors, custom-menu, custom-logo, featured-image-header, featured-images, footer-widgets, full-width-template, post-formats, sticky-post, theme-options, threaded-comments, translation-ready, blog, e-commerce, portfolio

Requires at least: 4.0
Tested up to: 4.8
Stable tag: 1.7.1
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html


___ DESCRIPTION

Bento is a powerful yet user-friendly free WordPress theme intended for use in the broadest range of web projects. It boasts premium-grade design and is packed with awesome features, some of which are unique for free themes. Bento is mobile-friendly (responsive), retina-ready, optimized for speed, and implements SEO (search engine optimization) best practices. The theme offers unprecedented customization flexibility through the native WP Customizer interface as well as built-in layouts, including one-page template. Unlimited color combinations for every element of the website, 500+ high-quality vector icons, advanced typography based on Google Fonts, and tons of other cool options and settings make it an ultimate tool for creating websites that are eye-pleasing, unique, and tailored to your needs. The theme offers advanced WooCommerce integration, including page templates, widgets, as well as full checkout funnel styling. Some other small but pleasant features include native infinite scroll, fixed menu options, and detailed settings for customizing the look of each indvidual page. Bento has been developed by an Envato Elite author who has sold 2000+ premium templates on ThemeForest, the largest marketplace in the industry; the theme implements clean, well-commented, developer-friendly code, and includes detailed documentation and a child theme template. Special attention has been paid to ensuring outstanding UX (user experience) and bringing the best in current web design trends and practices to the widest possible audience. Bento is being constantly maintained by its author and offers regular free updates with bugfixes and additional features. 


___ INSTALLATION

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.


___ MANUAL

Theme manual can be found at: http://satoristudio.net/bento-manual
For support and feature requests, please visit https://wordpress.org/support/theme/bento/


___ CHANGELOG

* 1.7.1 / 19 June 2017
Fixed call to action button alignment settings with extended header being switched on.
Fixed the default logo line height for long site titles.
Fixed mobile menu scroll behaviour for one-page setups.
Adjusted the fixed header position with active admin bar.

* 1.7 / 11 May 2017
Moved the mobile styles breakpoint to a smaller width (1024px).
Added a control to change the logo padding.
Fixed mobile menu z-index order for cases with transparent header.

* 1.6.7 / 25 April 2017
Updated the included CMB2 library.
Fixed header overlay and tile overlay opacity setting saving.
Removed hyphenation from the stylesheet.

* 1.6.6 / 12 April 2017
Fixed submenu behaviour with active sticky header given that a page is loaded in the middle.
Added a more universal fix for the same-page menu item highlight on scroll.
Added product gallery features support for WooCommerce 3.0+.

* 1.6.5 / 7 April 2017
Added full pingback support in the theme using native WP functions.
Improved the function that determines the number of WooCommerce shop columns.
Fixed the appearance of the WooCommerce Star Rating filter widget.
Fixed same-page menu item highlight on scroll.
Fixed the sticky header positioning when loading the page in the middle.

* 1.6.4 / 3 March 2017
Fixed the featured images control visibility issue for the project content type.
In case of empty logo the theme now displays site title in its place.
Replaced the theme screenshot with a more accurate one.
Replaced the front-end welcome header with an admin page.
Removed Expansion-Pack-specific metaboxes from the front-end.
Moved the option to edit the credit link in the footer into the Expansion Pack.
Corrected the name and description of the colors section of the Customizer.
Fixed the output of the "link" and "quote" format posts and linked to single post view.

* 1.6.3 / 13 February 2017
Added the header image upload field for the Expansion Pack.
The bottom footer does not display at all now if the footer menu and the copyright statement are blank.
Fixed the featured image behaviour in the presence of extended header on Grid pages.

* 1.6.2 / 5 February 2017
Removed Facebook and Twitter links and fixed the rating link in the Customizer
Added notes on site title and tagline into the readme file.
Moved the "Tile image" field into the Expansion Pack.
Corrected handles for third-party scripts and styles.
Updated the included CMB2 library.
Fixed the "Hite title" option on WooCommerce product pages.
Removed the unnecessary "Hide thumbnail" setting from pages.

* 1.6.1 / 1 February 2017
Corrected the text domain in the translation function which sets sidebar names.
Added unminified versions for all minified js files included in the theme.
Replaced custom comment function arguments with hooks.
Added the pagination link mechanism to page template.
Removed the "create-function" call from the WooCommerce "loop_shop_per_page" hook.
Removed theme prefixes from third-party script-enqueue handles.
Escaped all input for the wp_localize_script(), image URLs in the logo function, and category lists in post meta.
Replaced the json_encode() with the native wp_json_encode() function.
Moved the register_nav_menus() function inside the after_setup_theme() call.
Removed the excessive function_exists() check for the register_nav_menus() call.
Wrapped admin strings for plugin activation module into proper localization functions.
Added a reset to the custom grid query.
Switched to home_url() in the custom WooCommerce search function.
Removed the unnecessary "page-" prefix from the grid template.
Removed excessive escaping for the get_search_query() function.
The search form now fills with existing search query using the get_search_query() function.
Removed the excessive post date from the bento_entry_meta() template function.
Wrapped the year in the theme footer into a localization tag.
Fixed the unordered multiple placeholders issues in the sprintf() on line 93 of the CMB2 helper functions and on line 2410 of the plugin activation include.
Removed the error control operators from the included CMB2 library.

* 1.6 / 25 January 2017
Moved all theme-related support and upsell links into a single native Customizer section.
Removed all premium sections and fields from the Customizer for non-upgraded users.
Got rid of the 'add_option' call on theme activation.
Displaying the novice header only to users with admin capabilities.
Got rid of any separately stored additional options.
Added the user-defined website title with home link to the copyright notice in the footer.
Moved some of the page/post meta settings to Customizer or the Expansion Pack.
Replaced the global $post calls with get_queried_object_id().
Replaced the deprecated woocommerce_get_page_id().
Moved the custom site background option to the native Customizer functions.
Replaced the logo-related calls with native WP functions.
Replaced site_url() with home_url().
Added has_nav_menu checks for all theme-defined menu locations.
Replaced the custom excerpt-generating function with the native WP function and filters.
Defined the content width variable using a global.
Moved the custom CSS theme option to the WordPress native setting.
Escaped all user-inputted data on output for improved security.
Switched to the native WP imagesLoaded script.
Enqueuing admin scripts only on necessary screens.
Removed the redundant register_script() function calls.
Made menu and sidebar names translation-ready.
Removed the upload_mimes filter from the theme.
Corrected license version inconsistensies across theme files.
Added a readme file with theme information and credits.
Improved WooCommerce cart styling on smaller screens.
Fixed search form icon when used as a SiteOrigin widget.
Fixed Content Builder elements overlaying the mobile menu.
The fixed header now fits inside the boxed website layout.

* 1.5.4 / 25 October 2016
Fixed bug in masonry grid image urls.
Fixed "post types" multicheck for "grid" pages.

* 1.5.4 / 22 October 2016
Updated the CMB2 included library.
Sanitized all output instances.

* 1.5.3 / 21 October 2016
Adjusted the way the CMB2 library is included into the theme.

* 1.5.2 / 18 October 2016
Prefixed all hooks in the included php libraries.
Reverted to non-prefixed names for JS library enqueues.
Included favicon using native WordPress functionality.

* 1.5.1 / 9 October 2016
Improved the way Google Fonts are added to the theme.
Added theme prefixes to all external libraries and custom classes.

* 1.5 / 7 October 2016
The "hide title" setting now also works if the extended header has been activated.
Added an option to hide the featured image on posts and projects.
Mobile menu now closes also on touching outside the menu.
Fixed scroll position on page load with hashed URLs and fixed header.
Fixed oversize logo fit on side-header configuration in IE11.
Fixed the duplicate subheading issue for extended header.
Added sanitization to all output fields.
Corrected HTML validation errors.

* 1.4.1 / 16 September 2016
Fixed content width bug in the Customizer.
Fixed individual page/post setting effect scope.
Added defaults to all get_theme_mod calls.

* 1.4 / 12 September 2016
Migrated theme options into the native Customizer.
Moved non-theme functionality into the Expansion Pack.
Optimized and streamlined the functions.php theme file.
Fixed pagination links for Grid page template on static front page.
Updated JS breakpoints from pixels to em units to sync with CSS breakpoints.

* 1.3 / 23 August 2016
Added highlight for the current position in the footer menu.
Fixed mobile menu animation on iOS.
Fixed sidebar logic in the absence of sidebar widgets.
Fixed Google maps header behaviour for maps without custom styles.
Fixed post meta for posts in Uncategorized category.
Fixed header menu submenu styling on transparent headers with large logos.
Fixed theme welcome screen on side-header configuration.
Added full translation into Ukrainian (special thanks to Vadim Chernobublik).
Improved footer widget area compatibility with Polylang plugin.
Fixed Theme Options tab navigation beaviour in Firefox in cyrillic languages.
Fixed Google Fonts appearance in Safari for latin-ext and cyrillic characters.
Fixed sidebar on WooCommerce shop category pages.

* 1.2 / 23 June 2016
Added a possibility to upload a separate logo for mobile devices.
Site header custom color now also applies to fixed header.
Fixed Theme Options framework bug in php 7.
Fixed the bug with the "Hide title" setting for Grid pages.
Header background color setting now also affects side header layout.
Added full translation into French (special thanks to ThemeCloud.io)

* 1.1 / 16 May 2016
Added a possibility to upload a separate tile image apart from thumbnails.
The heading font setting in Theme Options now affects extended header headings.
Added full translation into Russian.
Fixed compatibility of link colors with user-defined styles in Content Builder.
Fixed sidebar layouts for pages that were created using other themes.

* 1.0.2 / 20 February 2016
Fixed the submenu animations and styling for "side" menu layout.
Added extra padding to the mobile menu in the absence of logo.
Hiding mobile menu elements if no menu has been created.

* 1.0.1 / 4 February 2016
Updated theme screenshot.

* 1.0 / 3 February 2016
Initial release.


___ CREDITS

* Third Party Assets
Isotope http://isotope.metafizzy.co/ (c) Metafizzy LLC, under [GPLv3] (https://www.gnu.org/licenses/gpl-3.0.en.html)
CMB2 https://github.com/WebDevStudios/CMB2 (c) WebDevStudios LLC, under [GPLv2] (http://www.gnu.org/licenses/gpl-2.0.html)
TGM Plugin Activation http://tgmpluginactivation.com/ (c) Thomas Griffin, under [GPLv2] (http://www.gnu.org/licenses/gpl-2.0.html)
FitVids http://fitvidsjs.com/ (c) Chris Coyier, Paravel, under [WTFPL] (http://www.wtfpl.net/txt/copying/)
FontAwesome http://fontawesome.io/ (c) Dave Gandy, under [SIL] (https://scripts.sil.org/OFL?)

* Images: 
Night Sky http://freenaturestock.com/post/124613380074 (c) Free Nature Stock, under CC0 (https://creativecommons.org/publicdomain/zero/1.0/)