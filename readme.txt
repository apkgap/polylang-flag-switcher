=== Polylang Flag Switcher ===
Contributors: yourname
Tags: polylang, language, flag, switcher, translation, multilingual, elementor, widget, shortcode
Requires at least: 5.0
Tested up to: 6.0
Stable tag: 1.0.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A comprehensive plugin for displaying flag buttons to switch languages with Polylang. Includes shortcodes and Elementor widgets.

== Description ==

Polylang Flag Switcher is a powerful WordPress plugin that enhances your multilingual website by providing beautiful and customizable flag buttons for language switching. This plugin integrates seamlessly with Polylang and offers multiple display options including shortcodes and Elementor widgets.

### Key Features

* **Multiple Display Options**: Choose from horizontal layout, vertical layout, dropdown, or single flag display
* **Customizable Styles**: Select from various flag styles including rounded, square, circle, shadow, border, and minimal
* **Flexible Sizing**: Choose from small, medium, large, or extra-large flag sizes
* **Elementor Integration**: Native Elementor widget with comprehensive customization options
* **Shortcode Support**: Multiple shortcodes for different display needs
* **Responsive Design**: Fully responsive and mobile-friendly
* **Accessibility**: WCAG compliant with keyboard navigation and screen reader support
* **Performance Optimized**: Lightweight and fast loading
* **Dark Mode Support**: Automatic adaptation to dark mode preferences

### Shortcodes

The plugin provides several shortcodes for different use cases:

**Flag Switcher** - Display all available language flags:
```
[polylang_flags]
[pfs_flags]
```

**Single Flag** - Display a single language flag:
```
[polylang_flag language="en"]
[pfs_flag language="th"]
```

**Language Dropdown** - Display a dropdown with language options:
```
[polylang_language_dropdown]
[pfs_dropdown]
```

### Shortcode Parameters

All shortcodes support various parameters for customization:

* **style**: Flag style (rounded, square, circle, shadow, border, minimal)
* **layout**: Layout option (horizontal, vertical, dropdown, modal)
* **size**: Flag size (small, medium, large, extra-large)
* **show_name**: Show/hide language names (true/false)
* **show_current**: Show/hide current language (true/false)
* **native_name**: Use native language names (true/false)
* **hide_current**: Hide current language (true/false)
* **force_home**: Force links to home page (true/false)
* **show_flags**: Show/hide flags (true/false)
* **class**: Additional CSS classes
* **id**: Custom element ID

### Examples

**Basic horizontal flag switcher:**
```
[polylang_flags]
```

**Vertical layout with rounded flags:**
```
[polylang_flags style="rounded" layout="vertical"]
```

**Large dropdown without flags:**
```
[polylang_language_dropdown size="large" show_flags="false"]
```

**Single English flag with custom class:**
```
[polylang_flag language="en" style="circle" class="custom-flag"]
```

### Elementor Widget

The plugin includes a dedicated Elementor widget with the following features:

* **Display Type Selection**: Choose between flag switcher, dropdown, or single flag
* **Style Customization**: Complete control over flag appearance
* **Layout Options**: Multiple layout options for different use cases
* **Responsive Settings**: Device-specific customization
* **Advanced Options**: Custom CSS support and additional settings

### Compatibility

* **Polylang**: Full compatibility with all Polylang features
* **Elementor**: Works with Elementor Free and Elementor Pro
* **WordPress**: Compatible with WordPress 5.0 and above
* **PHP**: Requires PHP 7.2 or above
* **Browsers**: Supports all modern browsers

### Performance

The plugin is built with performance in mind:

* Minimal CSS and JavaScript footprint
* Optimized image loading with lazy loading support
* No impact on page load time
* Clean and efficient code structure

== Installation ==

1. Upload the `polylang-flag-switcher` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure Polylang plugin is installed and activated
4. Configure your language settings in Polylang
5. Use shortcodes or Elementor widget to display language switchers

== Frequently Asked Questions ==

= Does this plugin require Polylang? =

Yes, this plugin requires Polylang to be installed and activated. It will not function without Polylang.

= Can I use this plugin with other multilingual plugins? =

No, this plugin is specifically designed to work with Polylang only.

= Does this plugin work with Elementor? =

Yes, the plugin includes a dedicated Elementor widget that works with both Elementor Free and Elementor Pro.

= Can I customize the appearance of the flags? =

Yes, the plugin offers multiple customization options including styles, sizes, layouts, and custom CSS support.

= Is this plugin mobile-friendly? =

Yes, the plugin is fully responsive and works perfectly on all devices.

= Does this plugin support custom flags? =

Yes, you can use custom flags by replacing the default flag images in the plugin's assets folder.

= Can I track language switching events? =

Yes, the plugin includes JavaScript hooks for tracking language switching events with analytics tools.

== Screenshots ==

1. Horizontal flag switcher with rounded flags
2. Vertical layout with language names
3. Dropdown language selector
4. Elementor widget settings panel
5. Single flag display options

== Changelog ==

= 1.0.0 =
* Initial release
* Flag switcher with multiple styles
* Elementor widget integration
* Shortcode support
* Responsive design
* Accessibility features
* Dark mode support

== Upgrade Notice ==

= 1.0.0 =
Initial release of Polylang Flag Switcher plugin.

== Additional Information ==

### Custom CSS Classes

The plugin adds specific CSS classes that you can use for further customization:

* `.pfs-flag-switcher` - Main container
* `.pfs-style-{style}` - Flag style (rounded, square, circle, etc.)
* `.pfs-layout-{layout}` - Layout type (horizontal, vertical, etc.)
* `.pfs-size-{size}` - Flag size (small, medium, etc.)
* `.pfs-current-language` - Current language item
* `.pfs-language-item` - Individual language item

### JavaScript Events

The plugin triggers custom events that you can use for additional functionality:

```javascript
// Listen for language switch events
jQuery(document).on('pfs:language_switch', function(event, langCode, fromUrl, toUrl) {
    // Custom code here
});
```

### Support

For support, feature requests, or bug reports, please visit the plugin's support forum on WordPress.org.

### License

This plugin is licensed under the GPL v2 or later license.