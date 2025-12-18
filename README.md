# Polylang Flag Switcher

A beautiful, modern language switcher for Polylang with Material Design aesthetics and extensive customization options.

## Features

### 🎨 **Display Formats**

- **Flag Only** - Show just the flag
- **Flag + Short Code** - Flag with language code (e.g., 🇹🇭 TH)
- **Flag + Full Name** - Flag with full language name (e.g., 🇹🇭 ไทย)
- **Short Code Only** - Language code only (e.g., TH)
- **Full Name Only** - Language name only (e.g., ไทย)

### 🎯 **Display Types**

- **Flag Switcher** - Horizontal or vertical list of flags
- **Language Dropdown** - Compact dropdown menu
- **Single Flag** - Display a specific language flag

### 🎨 **Styles**

- **Rounded** - Soft rounded corners (default)
- **Square** - Sharp corners
- **Circle** - Circular flags
- **Shadow** - With drop shadow
- **Border** - With border outline
- **Minimal** - Clean, minimal style

### 📏 **Sizes**

- Small (16x12px)
- Medium (24x16px) - default
- Large (32x24px)
- Extra Large (40x30px)

### ✨ **Special Features**

- **Transparent Mode** - Perfect for transparent headers
- **Material Design** - Clean, modern aesthetics
- **Dark Mode Support** - Auto-detect system preference
- **Responsive** - Mobile-friendly
- **Accessibility** - ARIA attributes, keyboard navigation
- **Pure ES6** - No jQuery dependency
- **Custom Width** - Control dropdown width (px, %, vw)
- **Show Current in Dropdown** - Option to include current language

---

## Installation

1. Upload the `polylang-flag-switcher` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure Polylang is installed and activated
4. Add at least 2 languages in Polylang settings

---

## Usage

### Elementor Widget

1. Open Elementor Editor
2. Search for "Polylang Flag Switcher" widget
3. Drag it to your desired location
4. Customize settings:
   - **Display Type**: Flags, Dropdown, or Single Flag
   - **Display Format**: Choose how to show languages
   - **Style**: Select visual style
   - **Size**: Choose flag size
   - **Transparent Mode**: Enable for transparent headers
   - **Dropdown Width**: Auto, Custom, or Full Width

### Shortcodes

#### 1. Flag Switcher

```php
[pfs_flags display_format="flag_short" layout="horizontal" size="medium"]
```

**Parameters:**

- `display_format`: `flag_only`, `flag_short`, `flag_full`, `short_only`, `full_only`
- `layout`: `horizontal`, `vertical`
- `size`: `small`, `medium`, `large`, `extra-large`
- `style`: `rounded`, `square`, `circle`, `shadow`, `border`, `minimal`
- `show_current`: `true`, `false`
- `hide_current`: `true`, `false`
- `native_name`: `true`, `false`
- `force_home`: `true`, `false`
- `class`: Custom CSS class
- `id`: Custom element ID

**Examples:**

```php
// Horizontal flags with short codes
[pfs_flags display_format="flag_short" layout="horizontal"]

// Vertical list with full names
[pfs_flags display_format="flag_full" layout="vertical" size="large"]

// Flags only, hide current language
[pfs_flags display_format="flag_only" hide_current="true"]
```

---

#### 2. Language Dropdown

```php
[pfs_dropdown display_format="flag_short" transparent="true" width="200px"]
```

**Parameters:**

- `display_format`: `flag_only`, `flag_short`, `flag_full`, `short_only`, `full_only`
- `size`: `small`, `medium`, `large`, `extra-large`
- `style`: `rounded`, `square`, `circle`, `shadow`, `border`, `minimal`
- `transparent`: `true`, `false` - Enable transparent mode
- `show_current_in_dropdown`: `true`, `false` - Show current language in options
- `width`: `200px`, `100%`, `auto` - Custom width
- `native_name`: `true`, `false`
- `class`: Custom CSS class
- `id`: Custom element ID

**Examples:**

```php
// Transparent dropdown for header
[pfs_dropdown display_format="flag_only" transparent="true" width="80px"]

// Full width dropdown for mobile
[pfs_dropdown display_format="flag_full" width="100%" show_current_in_dropdown="true"]

// Compact dropdown with short codes
[pfs_dropdown display_format="short_only" width="120px"]
```

---

#### 3. Single Flag

```php
[pfs_flag language="en" display_format="flag_short"]
```

**Parameters:**

- `language`: Language code (e.g., `en`, `th`, `fr`) - **Required**
- `display_format`: `flag_only`, `flag_short`, `flag_full`, `short_only`, `full_only`
- `size`: `small`, `medium`, `large`, `extra-large`
- `style`: `rounded`, `square`, `circle`, `shadow`, `border`, `minimal`
- `link`: `true`, `false` - Make it clickable
- `native_name`: `true`, `false`
- `class`: Custom CSS class
- `id`: Custom element ID

**Examples:**

```php
// English flag with short code
[pfs_flag language="en" display_format="flag_short"]

// Thai flag only, no link
[pfs_flag language="th" display_format="flag_only" link="false"]

// Large French flag with full name
[pfs_flag language="fr" display_format="flag_full" size="large"]
```

---

## Display Format Examples

| Format       | Code                          | Result            |
| ------------ | ----------------------------- | ----------------- |
| Flag Only    | `display_format="flag_only"`  | 🇹🇭 🇺🇸             |
| Flag + Short | `display_format="flag_short"` | 🇹🇭 TH 🇺🇸 EN       |
| Flag + Full  | `display_format="flag_full"`  | 🇹🇭 ไทย 🇺🇸 English |
| Short Only   | `display_format="short_only"` | TH EN             |
| Full Only    | `display_format="full_only"`  | ไทย English       |

---

## Use Cases

### 1. Transparent Header

```php
[pfs_dropdown
    display_format="flag_only"
    transparent="true"
    width="80px"
    style="minimal"
]
```

### 2. Mobile Menu

```php
[pfs_dropdown
    display_format="flag_full"
    width="100%"
    show_current_in_dropdown="true"
    size="large"
]
```

### 3. Sidebar Widget

```php
[pfs_flags
    display_format="flag_short"
    layout="vertical"
    size="medium"
]
```

### 4. Footer

```php
[pfs_flags
    display_format="short_only"
    layout="horizontal"
    size="small"
    style="minimal"
]
```

### 5. Language Indicator

```php
[pfs_flag
    language="en"
    display_format="flag_short"
    link="false"
    size="small"
]
```

---

## CSS Classes

### Main Containers

- `.pfs-flag-switcher` - Flag switcher container
- `.pfs-language-dropdown` - Dropdown container
- `.pfs-single-flag` - Single flag container

### Layouts

- `.pfs-layout-horizontal` - Horizontal layout
- `.pfs-layout-vertical` - Vertical layout

### Styles

- `.pfs-style-rounded` - Rounded style
- `.pfs-style-square` - Square style
- `.pfs-style-circle` - Circle style
- `.pfs-style-shadow` - Shadow style
- `.pfs-style-border` - Border style
- `.pfs-style-minimal` - Minimal style

### Sizes

- `.pfs-size-small` - Small size
- `.pfs-size-medium` - Medium size
- `.pfs-size-large` - Large size
- `.pfs-size-extra-large` - Extra large size

### Special

- `.pfs-transparent` - Transparent mode
- `.pfs-full-width` - Full width dropdown
- `.pfs-current-language` - Current language item
- `.pfs-current-option` - Current language in dropdown

---

## Custom CSS Examples

### Change Dropdown Background

```css
.pfs-language-dropdown .pfs-current-display {
  background-color: #f5f5f5;
}
```

### Custom Hover Color

```css
.pfs-language-link:hover {
  background-color: #e3f2fd;
  color: #1976d2;
}
```

### Larger Flags

```css
.pfs-flag {
  width: 32px;
  height: 24px;
}
```

### Custom Dropdown Width

```css
.pfs-language-dropdown {
  min-width: 180px;
}
```

---

## JavaScript API

### Refresh Dropdowns

```javascript
if (window.PFS) {
  window.PFS.refreshDropdowns();
}
```

### Get Language Data

```javascript
if (window.PFS) {
  window.PFS.getLanguageData().then((data) => {
    console.log(data);
  });
}
```

### Track Language Switch

```javascript
document.addEventListener("pfs:language_switch", (e) => {
  console.log("Language switched:", e.detail);
});
```

---

## Browser Support

- ✅ Chrome (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ✅ Mobile browsers

---

## Requirements

- WordPress 5.0 or higher
- Polylang 2.0 or higher
- PHP 7.0 or higher
- Elementor 3.5+ (for Elementor widget)

---

## Changelog

### Version 1.0.0

- Initial release
- Material Design UI
- Pure ES6 (no jQuery)
- Display format options
- Transparent mode
- Custom width control
- Show current in dropdown
- Elementor widget
- Shortcode support
- Dark mode support
- Accessibility features

---

## Support

For support, please visit the plugin's support forum or contact the developer.

---

## License

This plugin is licensed under the GPL v2 or later.

---

## Credits

Developed with ❤️ using Material Design principles and modern web standards.
#   p o l y l a n g - f l a g - s w i t c h e r  
 