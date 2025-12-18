<?php

/**
 * Core functions for Polylang Flag Switcher
 */

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get all available languages from Polylang
 * 
 * @return array List of languages with their details
 */
function pfs_get_languages()
{
    if (!function_exists('PLL')) {
        return array();
    }

    // Try to get languages using pll_the_languages first (works on frontend)
    $languages = pll_the_languages(array('raw' => 1));

    // If empty (e.g., in Elementor Editor), try direct PLL() API
    if (empty($languages) && function_exists('pll_languages_list')) {
        $languages = array();
        $lang_list = pll_languages_list();

        foreach ($lang_list as $lang_slug) {
            $lang_obj = PLL()->model->get_language($lang_slug);
            if ($lang_obj) {
                $languages[$lang_slug] = array(
                    'id' => $lang_obj->term_id,
                    'slug' => $lang_slug,
                    'name' => $lang_obj->name,
                    'url' => pll_home_url($lang_slug),
                    'flag' => $lang_obj->flag_url,
                    'current_lang' => (pll_current_language() === $lang_slug),
                    'no_translation' => false,
                );
            }
        }
    }

    return is_array($languages) ? $languages : array();
}

/**
 * Get current language
 * 
 * @return string Current language code
 */
function pfs_get_current_language()
{
    if (!function_exists('PLL')) {
        return '';
    }

    return pll_current_language('slug');
}

/**
 * Get flag URL for a language
 * 
 * @param string $lang_code Language code
 * @return string Flag URL
 */
function pfs_get_flag_url($lang_code)
{
    if (!function_exists('PLL')) {
        return '';
    }

    $languages = pfs_get_languages();

    if (isset($languages[$lang_code])) {
        return $languages[$lang_code]['flag'];
    }

    return '';
}

/**
 * Get language name
 * 
 * @param string $lang_code Language code
 * @param bool $native Whether to return native name or default
 * @return string Language name
 */
function pfs_get_language_name($lang_code, $native = true)
{
    if (!function_exists('PLL')) {
        return '';
    }

    $languages = pfs_get_languages();

    if (isset($languages[$lang_code])) {
        return $native ? $languages[$lang_code]['name'] : $languages[$lang_code]['translated_name'];
    }

    return '';
}

/**
 * Get language URL
 * 
 * @param string $lang_code Language code
 * @return string Language URL
 */
function pfs_get_language_url($lang_code)
{
    if (!function_exists('PLL')) {
        return '';
    }

    $languages = pfs_get_languages();

    if (isset($languages[$lang_code])) {
        return $languages[$lang_code]['url'];
    }

    return '';
}

/**
 * Check if language is current
 * 
 * @param string $lang_code Language code
 * @return bool True if current language
 */
function pfs_is_current_language($lang_code)
{
    return pfs_get_current_language() === $lang_code;
}

/**
 * Get available flag styles
 * 
 * @return array Available flag styles
 */
function pfs_get_flag_styles()
{
    return array(
        'rounded' => __('Rounded', 'polylang-flag-switcher'),
        'square' => __('Square', 'polylang-flag-switcher'),
        'circle' => __('Circle', 'polylang-flag-switcher'),
        'shadow' => __('Shadow', 'polylang-flag-switcher'),
        'border' => __('Border', 'polylang-flag-switcher'),
        'minimal' => __('Minimal', 'polylang-flag-switcher'),
    );
}

/**
 * Get available layout options
 * 
 * @return array Available layout options
 */
function pfs_get_layout_options()
{
    return array(
        'horizontal' => __('Horizontal', 'polylang-flag-switcher'),
        'vertical' => __('Vertical', 'polylang-flag-switcher'),
        'dropdown' => __('Dropdown', 'polylang-flag-switcher'),
        'modal' => __('Modal', 'polylang-flag-switcher'),
    );
}

/**
 * Get available size options
 * 
 * @return array Available size options
 */
function pfs_get_size_options()
{
    return array(
        'small' => __('Small', 'polylang-flag-switcher'),
        'medium' => __('Medium', 'polylang-flag-switcher'),
        'large' => __('Large', 'polylang-flag-switcher'),
        'extra-large' => __('Extra Large', 'polylang-flag-switcher'),
    );
}

/**
 * Sanitize and validate style options
 * 
 * @param array $options Raw options
 * @return array Sanitized options
 */
function pfs_sanitize_options($options)
{
    $defaults = array(
        'style' => 'rounded',
        'layout' => 'horizontal',
        'size' => 'medium',
        'show_name' => true,
        'show_current' => true,
        'native_name' => true,
        'hide_current' => false,
        'force_home' => false,
        'show_flags' => true,
        'echo' => false,
    );

    $options = wp_parse_args($options, $defaults);

    // Sanitize individual options
    $options['style'] = in_array($options['style'], array_keys(pfs_get_flag_styles())) ? $options['style'] : 'rounded';
    $options['layout'] = in_array($options['layout'], array_keys(pfs_get_layout_options())) ? $options['layout'] : 'horizontal';
    $options['size'] = in_array($options['size'], array_keys(pfs_get_size_options())) ? $options['size'] : 'medium';
    $options['show_name'] = (bool) $options['show_name'];
    $options['show_current'] = (bool) $options['show_current'];
    $options['native_name'] = (bool) $options['native_name'];
    $options['hide_current'] = (bool) $options['hide_current'];
    $options['force_home'] = (bool) $options['force_home'];
    $options['show_flags'] = (bool) $options['show_flags'];
    $options['echo'] = (bool) $options['echo'];

    return $options;
}

/**
 * Generate CSS classes for flag switcher
 * 
 * @param array $options Display options
 * @return string CSS classes
 */
function pfs_generate_css_classes($options)
{
    $classes = array('pfs-flag-switcher');

    $classes[] = 'pfs-style-' . $options['style'];
    $classes[] = 'pfs-layout-' . $options['layout'];
    $classes[] = 'pfs-size-' . $options['size'];

    if (!$options['show_flags']) {
        $classes[] = 'pfs-no-flags';
    }

    if (!$options['show_name']) {
        $classes[] = 'pfs-no-names';
    }

    if ($options['hide_current']) {
        $classes[] = 'pfs-hide-current';
    }

    return implode(' ', $classes);
}

/**
 * Generate inline CSS for custom styling
 * 
 * @param array $options Display options
 * @return string Inline CSS
 */
function pfs_generate_inline_css($options)
{
    $css = '';

    // Add custom CSS if provided
    if (!empty($options['custom_css'])) {
        $css .= $options['custom_css'];
    }

    return $css;
}

/**
 * Get default flag image if Polylang flag is not available
 * 
 * @param string $lang_code Language code
 * @return string Default flag URL
 */
function pfs_get_default_flag($lang_code)
{
    $flags = array(
        'en' => PFS_PLUGIN_URL . 'assets/images/flags/en.png',
        'th' => PFS_PLUGIN_URL . 'assets/images/flags/th.png',
        'de' => PFS_PLUGIN_URL . 'assets/images/flags/de.png',
        'fr' => PFS_PLUGIN_URL . 'assets/images/flags/fr.png',
        'es' => PFS_PLUGIN_URL . 'assets/images/flags/es.png',
        'it' => PFS_PLUGIN_URL . 'assets/images/flags/it.png',
        'pt' => PFS_PLUGIN_URL . 'assets/images/flags/pt.png',
        'ru' => PFS_PLUGIN_URL . 'assets/images/flags/ru.png',
        'ja' => PFS_PLUGIN_URL . 'assets/images/flags/ja.png',
        'zh' => PFS_PLUGIN_URL . 'assets/images/flags/zh.png',
        'ko' => PFS_PLUGIN_URL . 'assets/images/flags/ko.png',
        'ar' => PFS_PLUGIN_URL . 'assets/images/flags/ar.png',
    );

    return isset($flags[$lang_code]) ? $flags[$lang_code] : '';
}
