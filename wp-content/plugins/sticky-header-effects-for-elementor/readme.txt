=== Sticky Header Effects for Elementor ===

Contributors: rwattner, dgovea
Donate Link: https://www.paypal.me/StickyHeaderEffects
Tags: Elementor, Elementor Page Builder, Elements, Elementor Add-ons, Add-ons, Page Builder, Widgets, Briefcasewp
Requires at least: 4.9.0
Tested up to: 5.5
Requires PHP: 5.4
Stable tag: 1.4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Options and features that extend Elementor Pro's sticky header capabilities.

== Description ==

Sticky Header Effects for Elementor adds useful options that are missing from the "sticky" header feature introduced in Elementor Pro 2.0. Giving users the option to change the background color and height when the visitor starts scrolling down the page. This allows for a "transparent" menu effect that can become any color, semi-transparent or solid, once the visitor begins to scroll.

This plugin is cross-browser compatible and fully responsive. Meaning it will work on all browsers as well as tablets and mobile devices.

This plugin is meant to be an add-on to Elementor Pro page builder as it's not a standalone plugin.

### Features

* Options panel built-in to Elementor Pro's advanced section options. - Settings are right where they should be without cluttering up your workspace.
* Apply options on scrolling - The scrolling distance for the Sticky Header Effects to be applied is responsively adjustable for the best results in any situation.
* Transparent Header - Uses position to move header section down on top of the page. No need for problem causing negative margins.
* Header Background Color - Options for header after scrolling with full HEX, RGBA, and Color Name support.
* Bottom Border - Allows user to change the color and thickness of the bottom border upon scrolling.
* Shrink Header - An effect which changes section min-height to maximize space and achieve a slim style without losing functionality.
(Remember that the "shrink" effect is limited by the height and padding of the header content. See the F.A.Q.)
* Shrink Logo - Ability to adjust the logo height after scrolling
*Change Logo Color - Change the logo image color before or after the user scrolls. Useful for switching header design from monocromatic to full color
*Blur Background - Add a modern blur effect to a semi-transparent header background color after scrolling
*Hide Header on Scroll Down - Hides the header if scrolling down, and shows header if scrolling up. Has selectable distance to start the effect

### Pro Features Coming Soon

* Replace logo - Change logo image entirely
* Entrance animations - Slide-in and fade-in animations with animation duration
* Hide elements - Hide or show header elements after scrolling
* Box shadow - Add or remove box shadow effect upon scrolling with color, horizontal, vertical, blur, and spread controls
* Menu toggle animations - Entrance and exit animations for the mobile hamburger menu
* Split menu - Menus that will split to allow center logo

== Installation ==

= Minimum Requirements =
* WordPress 4.9 or greater
* PHP version 5.4 or greater
* MySQL version 5.0 or greater

= Installation Instructions =
- Make sure that you have installed Elementor Pro Page Builder. This is not a stand-alone plugin and ONLY works with Elementor Pro.
- Install the plugin through the WordPress plugins screen directly or download the plugin and upload it to the plugin folder: /wp-content/plugins/.
- Activate the plugin through the installation screen or the "Plugins" screen in WordPress
- You can find Sticky Header Options for Elementor under a sections "Advanced" tab, directly under "Sticky Effect".

== Frequently Asked Questions ==

= Why isn't the "shrink" effect working? =

The header cannot shrink smaller than the objects inside of it!

The "shrink" effect is restricted by the size of the content in the header section. Such as logos, images, menus, widgets, and also all of the padding and margins of those elements. This also inclused the padding and margins of the sections and columns themselves.

To get the best "shrink" effect use these settings:
* Set the top and bottom padding to 0px on your sticky header section, column, and elements inside of it.
* Set a custom logo and other image height(you can leave the width blank for "auto").
* Set the header section height to "min height" and adjust it to your desired height.

Basically what happens is that the content of the header is "too tall" to shrink down anymore.

= Is this a standalone Plugin? =

No. You cannot use Sticky Header Effects for Elementor by itself. It is a plugin for Elementor Pro.

= Does it work with any WordPress theme? =

Yes. It will work with any WordPress theme that is using Elementor Pro as a page builder.

= Will this plugin slow down my website speed? =

Sticky Header Options for Elementor is light-weight and you can also use only the options you want to use on your website for faster performance.

== Screenshots ==

1. Settings built-in to Elementor Pro.
2. Main settings panel.
3. Current effects settings.

== Changelog ==

= 1.4.3 =
Fixed: Full color logo after scroll bug

= 1.4.2 =
Fixed: Bugs

= 1.4.1 =
Fixed: Gap above header bug

= 1.4.0 =
- Added: Wordpress 5.5 compatibility
- Added: Elementor 3 compatibility
- Added: Hide on scroll down feature
- Added: Blur background feature
- Added: Before and after scrolling logo color options
- Fixed: Opera browser hash links not activating scrolling effects
- Fixed: Editor handle bug
- Fixed: All labels and descriptions to help with user operation
- Fixed: Various code optimizations
- Fixed: Transparent on mobile bug
- Fixed: Stretched section broke transparent header

= 1.3.2 =
- Fixed: Transition CSS

= 1.3.1 =
- Fixed: Bugs

= 1.3.0 =
- Added: Shrink Logo feature

= 1.2.3 =
- Fixed: Hook on the new Elementor Pro 2.4.7 version

= 1.2.2 =
- Removed: Stretched section condition

= 1.2.1 =
- Added: Compatibility with the new Elementor 2.1.1 version
- Fixed: JavaScript error

= 1.2.0 =
- Removed: Sticky Header feature(Elementor fixed theirs)
- Added: Transparent header feature
- Added: Compatibility with the new Elementor 2.1 version
- Added: Change javascript to external file
- Fixed: Bugs

= 1.1.2 =
- Fixed: Bugs

= 1.1.1 =
- Fixed: Bug where section didn't move to top of page

= 1.1.0 =
- Added: Sticky header feature
- Added: Bottom border feature
- Fixed: Bugs with tablet and mobile responsive modes
- Fixed: Padding issues when using the "shrink" effect

= 1.0.0 =

- Initial stable release

== Upgrade Notice ==

= 1.4.3 =
Fixed: Full color logo after scroll bug

= 1.4.2 =
Fixed: Bugs

= 1.4.1 =
Fixed: Gap above header bug

= 1.4.0 =
- Added: Wordpress 5.5 compatibility
- Added: Elementor 3 compatibility
- Added: Hide on scroll down feature
- Added: Blur background feature
- Added: Before and after scrolling logo color options
- Fixed: Opera browser hash links not activating scrolling effects
- Fixed: Editor handle bug
- Fixed: All labels and descriptions to help with user operation
- Fixed: Various code optimizations
- Fixed: Transparent on mobile bug
- Fixed: Stretched section broke transparent header

= 1.3.2 =
- Fixed: Transition CSS

= 1.3.1 =
- Fixed: Bugs

= 1.3.0 =
- Added: Shrink Logo featured

= 1.2.3 =
- Fixed: Hook on the new Elementor Pro 2.4.7 version

= 1.2.2 =
- Removed: Stretched section condition

= 1.2.1 =
- Added: Compatibility with the new Elementor 2.1.1 version
- Fixed: JavaScript error

= 1.2.0 =
Removed: Sticky Header feature(Elementor fixed theirs)
Added: Transparent header feature
Added: Compatibility with the new Elementor 2.1 version
Added: Change javascript to external file
Fixed: Bugs

= 1.1.2 =
Bug fixes

= 1.1.1 =
Bug fixes

= 1.1.0 =
This version adds "Sticky Header" and "Bottom Border" options.
The sticky feature will bring the section down and overlay it on top of the page. This eliminates the need for negative margins which causes page scrolling problems.
The bottom border feature adds bottom border width and color options when user scrolls.

== Donate ==
Enjoy using *Sticky Header Effects*? Please consider making a **[donation](https://www.paypal.me/StickyHeaderEffects)**
Every donation helps the continued development, maintenance, and support for this plugin.
**Thank you very much your support!**
