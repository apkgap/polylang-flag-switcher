<?php

/**
 * Shortcodes for Polylang Flag Switcher
 */

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcodes class
 */
class PFS_Shortcodes
{

    /**
     * Constructor
     */
    public function __construct()
    {
        add_shortcode('polylang_flags', array($this, 'flag_switcher_shortcode'));
        add_shortcode('pfs_flags', array($this, 'flag_switcher_shortcode'));
        add_shortcode('polylang_flag', array($this, 'single_flag_shortcode'));
        add_shortcode('pfs_flag', array($this, 'single_flag_shortcode'));
        add_shortcode('polylang_language_dropdown', array($this, 'language_dropdown_shortcode'));
        add_shortcode('pfs_dropdown', array($this, 'language_dropdown_shortcode'));
    }

    /**
     * Flag switcher shortcode
     * 
     * Usage: [pfs_flags display_format="flag_short" show_current="true"]
     * 
     * @param array $atts Shortcode attributes
     * @return string Generated HTML
     */
    public function flag_switcher_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'style' => 'rounded',
            'layout' => 'horizontal',
            'size' => 'medium',
            'display_format' => 'flag_short', // flag_only, flag_short, flag_full, short_only, full_only
            'native_name' => 'true',
            'show_current' => 'true',
            'hide_current' => 'false',
            'force_home' => 'false',
            'class' => '',
            'id' => '',
        ), $atts, 'polylang_flags');

        // Convert string values to boolean
        $options = array(
            'style' => $atts['style'],
            'layout' => $atts['layout'],
            'size' => $atts['size'],
            'display_format' => $atts['display_format'],
            'native_name' => filter_var($atts['native_name'], FILTER_VALIDATE_BOOLEAN),
            'show_current' => filter_var($atts['show_current'], FILTER_VALIDATE_BOOLEAN),
            'hide_current' => filter_var($atts['hide_current'], FILTER_VALIDATE_BOOLEAN),
            'force_home' => filter_var($atts['force_home'], FILTER_VALIDATE_BOOLEAN),
            'class' => $atts['class'],
            'id' => $atts['id'],
        );

        return $this->generate_flag_switcher($options);
    }

    /**
     * Single flag shortcode
     * 
     * Usage: [pfs_flag language="en" display_format="flag_short"]
     * 
     * @param array $atts Shortcode attributes
     * @return string Generated HTML
     */
    public function single_flag_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'language' => '',
            'style' => 'rounded',
            'size' => 'medium',
            'display_format' => 'flag_short',
            'native_name' => 'true',
            'link' => 'true',
            'class' => '',
            'id' => '',
        ), $atts, 'polylang_flag');

        if (empty($atts['language'])) {
            return '';
        }

        $options = array(
            'language' => $atts['language'],
            'style' => $atts['style'],
            'size' => $atts['size'],
            'display_format' => $atts['display_format'],
            'native_name' => filter_var($atts['native_name'], FILTER_VALIDATE_BOOLEAN),
            'link' => filter_var($atts['link'], FILTER_VALIDATE_BOOLEAN),
            'class' => $atts['class'],
            'id' => $atts['id'],
        );

        return $this->generate_single_flag($options);
    }

    /**
     * Language dropdown shortcode
     * 
     * Usage: [pfs_dropdown display_format="flag_short" transparent="true" width="200px"]
     * 
     * @param array $atts Shortcode attributes
     * @return string Generated HTML
     */
    public function language_dropdown_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'style' => 'rounded',
            'size' => 'medium',
            'display_format' => 'flag_short',
            'native_name' => 'true',
            'show_current_in_dropdown' => 'false',
            'transparent' => 'false',
            'width' => '', // e.g., "200px", "100%", "auto"
            'class' => '',
            'id' => '',
        ), $atts, 'polylang_language_dropdown');

        $options = array(
            'style' => $atts['style'],
            'size' => $atts['size'],
            'display_format' => $atts['display_format'],
            'native_name' => filter_var($atts['native_name'], FILTER_VALIDATE_BOOLEAN),
            'show_current_in_dropdown' => filter_var($atts['show_current_in_dropdown'], FILTER_VALIDATE_BOOLEAN),
            'transparent_mode' => filter_var($atts['transparent'], FILTER_VALIDATE_BOOLEAN),
            'width' => $atts['width'],
            'class' => $atts['class'],
            'id' => $atts['id'],
        );

        return $this->generate_language_dropdown($options);
    }

    /**
     * Format language display based on display_format option
     */
    private function format_language_display($lang_code, $lang_data, $options)
    {
        $name = $options['native_name']
            ? $lang_data['name']
            : (isset($lang_data['translated_name']) ? $lang_data['translated_name'] : $lang_data['name']);

        $flag_url = !empty($lang_data['flag']) ? $lang_data['flag'] : pfs_get_default_flag($lang_code);
        $short_code = strtoupper($lang_code);

        $html = '';

        switch ($options['display_format']) {
            case 'flag_only':
                if (!empty($flag_url)) {
                    $html .= '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($name) . '" class="pfs-flag" />';
                }
                break;

            case 'flag_short':
                if (!empty($flag_url)) {
                    $html .= '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($name) . '" class="pfs-flag" />';
                }
                $html .= '<span class="pfs-language-name">' . esc_html($short_code) . '</span>';
                break;

            case 'flag_full':
                if (!empty($flag_url)) {
                    $html .= '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($name) . '" class="pfs-flag" />';
                }
                $html .= '<span class="pfs-language-name">' . esc_html($name) . '</span>';
                break;

            case 'short_only':
                $html .= '<span class="pfs-language-name">' . esc_html($short_code) . '</span>';
                break;

            case 'full_only':
                $html .= '<span class="pfs-language-name">' . esc_html($name) . '</span>';
                break;

            default:
                // Default: flag + short
                if (!empty($flag_url)) {
                    $html .= '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($name) . '" class="pfs-flag" />';
                }
                $html .= '<span class="pfs-language-name">' . esc_html($short_code) . '</span>';
                break;
        }

        return $html;
    }

    /**
     * Generate flag switcher HTML
     * 
     * @param array $options Display options
     * @return string Generated HTML
     */
    private function generate_flag_switcher($options)
    {
        $languages = pfs_get_languages();

        if (empty($languages)) {
            return '';
        }

        $css_classes = array('pfs-flag-switcher', 'pfs-layout-' . $options['layout'], 'pfs-style-' . $options['style'], 'pfs-size-' . $options['size']);

        if (!empty($options['class'])) {
            $css_classes[] = esc_attr($options['class']);
        }

        $html = '<div class="' . implode(' ', $css_classes) . '"';

        if (!empty($options['id'])) {
            $html .= ' id="' . esc_attr($options['id']) . '"';
        }

        $html .= '>';

        foreach ($languages as $lang_code => $lang_data) {
            $is_current = pfs_is_current_language($lang_code);

            if ($options['hide_current'] && $is_current) {
                continue;
            }

            if (!$options['show_current'] && $is_current) {
                continue;
            }

            $html .= $this->generate_language_item($lang_code, $lang_data, $options, $is_current);
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate single language item
     * 
     * @param string $lang_code Language code
     * @param array $lang_data Language data
     * @param array $options Display options
     * @param bool $is_current Whether this is the current language
     * @return string Generated HTML
     */
    private function generate_language_item($lang_code, $lang_data, $options, $is_current = false)
    {
        $url = $options['force_home']
            ? (isset($lang_data['home_url']) ? $lang_data['home_url'] : $lang_data['url'])
            : $lang_data['url'];

        $item_classes = array('pfs-language-item');

        if ($is_current) {
            $item_classes[] = 'pfs-current-language';
        }

        $html = '<div class="' . implode(' ', $item_classes) . '">';

        if (!$is_current) {
            $html .= '<a href="' . esc_url($url) . '" class="pfs-language-link">';
        } else {
            $html .= '<span class="pfs-language-link">';
        }

        $html .= $this->format_language_display($lang_code, $lang_data, $options);

        if (!$is_current) {
            $html .= '</a>';
        } else {
            $html .= '</span>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate single flag HTML
     * 
     * @param array $options Display options
     * @return string Generated HTML
     */
    private function generate_single_flag($options)
    {
        $languages = pfs_get_languages();

        if (empty($languages) || !isset($languages[$options['language']])) {
            return '';
        }

        $lang_code = $options['language'];
        $lang_data = $languages[$lang_code];
        $is_current = pfs_is_current_language($lang_code);

        $url = $lang_data['url'];

        $css_classes = array('pfs-single-flag', 'pfs-style-' . $options['style'], 'pfs-size-' . $options['size']);

        if ($is_current) {
            $css_classes[] = 'pfs-current-language';
        }

        if (!empty($options['class'])) {
            $css_classes[] = esc_attr($options['class']);
        }

        $html = '<div class="' . implode(' ', $css_classes) . '"';

        if (!empty($options['id'])) {
            $html .= ' id="' . esc_attr($options['id']) . '"';
        }

        $html .= '>';

        if ($options['link'] && !$is_current) {
            $html .= '<a href="' . esc_url($url) . '" class="pfs-flag-link">';
        } else {
            $html .= '<span class="pfs-flag-link">';
        }

        $html .= $this->format_language_display($lang_code, $lang_data, $options);

        if ($options['link'] && !$is_current) {
            $html .= '</a>';
        } else {
            $html .= '</span>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate language dropdown HTML
     * 
     * @param array $options Display options
     * @return string Generated HTML
     */
    private function generate_language_dropdown($options)
    {
        $languages = pfs_get_languages();

        if (empty($languages)) {
            return '';
        }

        $current_lang = pfs_get_current_language();
        $css_classes = array('pfs-language-dropdown', 'pfs-style-' . $options['style'], 'pfs-size-' . $options['size']);

        if (!empty($options['transparent_mode'])) {
            $css_classes[] = 'pfs-transparent';
        }

        if (!empty($options['class'])) {
            $css_classes[] = esc_attr($options['class']);
        }

        $inline_style = '';
        if (!empty($options['width'])) {
            $inline_style = ' style="width: ' . esc_attr($options['width']) . ';"';
        }

        $html = '<div class="' . implode(' ', $css_classes) . '"';

        if (!empty($options['id'])) {
            $html .= ' id="' . esc_attr($options['id']) . '"';
        }

        $html .= $inline_style . '>';

        // Current language display (ALWAYS show for dropdown - it's the button!)
        $current_data = isset($languages[$current_lang]) ? $languages[$current_lang] : reset($languages);

        $html .= '<div class="pfs-current-display" data-current-lang="' . esc_attr($current_lang) . '">';
        $html .= $this->format_language_display($current_lang, $current_data, $options);
        $html .= '<span class="pfs-dropdown-arrow"></span>';
        $html .= '</div>';

        // Dropdown options
        $html .= '<div class="pfs-dropdown-options">';

        foreach ($languages as $lang_code => $lang_data) {
            // Skip current language unless show_current_in_dropdown is enabled
            if ($lang_code === $current_lang && !$options['show_current_in_dropdown']) {
                continue;
            }

            $url = $lang_data['url'];

            $option_classes = 'pfs-dropdown-option';
            if ($lang_code === $current_lang) {
                $option_classes .= ' pfs-current-option';
            }

            $html .= '<a href="' . esc_url($url) . '" class="' . $option_classes . '">';
            $html .= $this->format_language_display($lang_code, $lang_data, $options);
            $html .= '</a>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
