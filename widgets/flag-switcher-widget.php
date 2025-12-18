<?php

/**
 * Elementor Widget for Polylang Flag Switcher
 */

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

// Check if Elementor is active
if (!class_exists('\Elementor\Widget_Base')) {
    return;
}

/**
 * Flag Switcher Widget class
 */
class PFS_Flag_Switcher_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name
     * 
     * @return string Widget name
     */
    public function get_name()
    {
        return 'polylang-flag-switcher';
    }

    /**
     * Get widget title
     * 
     * @return string Widget title
     */
    public function get_title()
    {
        return __('Polylang Flag Switcher', 'polylang-flag-switcher');
    }

    /**
     * Get widget icon
     * 
     * @return string Widget icon
     */
    public function get_icon()
    {
        return 'eicon-language';
    }

    /**
     * Get widget categories
     * 
     * @return array Widget categories
     */
    public function get_categories()
    {
        return array('general', 'theme-elements');
    }

    /**
     * Get widget keywords
     * 
     * @return array Widget keywords
     */
    public function get_keywords()
    {
        return array('polylang', 'language', 'flag', 'switcher', 'translation');
    }

    /**
     * Get style dependencies
     * 
     * @return array Style dependencies
     */
    public function get_style_depends()
    {
        return array('pfs-frontend-style');
    }

    /**
     * Get script dependencies
     * 
     * @return array Script dependencies
     */
    public function get_script_depends()
    {
        return array('pfs-frontend-script');
    }

    /**
     * Register widget controls
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            array(
                'label' => __('Content', 'polylang-flag-switcher'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'display_type',
            array(
                'label' => __('Display Type', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'flags',
                'options' => array(
                    'flags' => __('Flag Switcher', 'polylang-flag-switcher'),
                    'dropdown' => __('Language Dropdown', 'polylang-flag-switcher'),
                    'single' => __('Single Language Flag', 'polylang-flag-switcher'),
                ),
            )
        );

        $this->add_control(
            'single_language',
            array(
                'label' => __('Language Code', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g. en, th, fr', 'polylang-flag-switcher'),
                'condition' => array(
                    'display_type' => 'single',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            array(
                'label' => __('Style', 'polylang-flag-switcher'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'flag_style',
            array(
                'label' => __('Flag Style', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'rounded',
                'options' => pfs_get_flag_styles(),
            )
        );

        $this->add_control(
            'layout',
            array(
                'label' => __('Layout', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => pfs_get_layout_options(),
                'condition' => array(
                    'display_type' => 'flags',
                ),
            )
        );

        $this->add_control(
            'size',
            array(
                'label' => __('Size', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => pfs_get_size_options(),
            )
        );


        $this->add_control(
            'display_format',
            array(
                'label' => __('Display Format', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'flag_short',
                'options' => array(
                    'flag_only' => __('🏴 Flag Only', 'polylang-flag-switcher'),
                    'flag_short' => __('🏴 Flag + Short (TH, EN)', 'polylang-flag-switcher'),
                    'flag_full' => __('🏴 Flag + Full Name', 'polylang-flag-switcher'),
                    'short_only' => __('📝 Short Name Only (TH, EN)', 'polylang-flag-switcher'),
                    'full_only' => __('📝 Full Name Only', 'polylang-flag-switcher'),
                ),
            )
        );

        $this->add_control(
            'show_current_in_dropdown',
            array(
                'label' => __('Show Current in Dropdown', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => __('Include current language in dropdown options', 'polylang-flag-switcher'),
                'condition' => array(
                    'display_type' => 'dropdown',
                ),
            )
        );

        $this->add_control(
            'native_names',
            array(
                'label' => __('Use Native Names', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => array(
                    'show_names' => 'yes',
                ),
            )
        );

        $this->add_control(
            'show_current',
            array(
                'label' => __('Show Current Language', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => array(
                    'display_type' => 'flags',
                ),
            )
        );

        $this->add_control(
            'hide_current',
            array(
                'label' => __('Hide Current Language', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => array(
                    'display_type' => 'flags',
                ),
            )
        );

        $this->add_control(
            'force_home',
            array(
                'label' => __('Force Link to Home', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            )
        );

        $this->add_control(
            'transparent_mode',
            array(
                'label' => __('Transparent Mode', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => __('Enable for use in transparent headers', 'polylang-flag-switcher'),
            )
        );

        $this->add_control(
            'dropdown_width_type',
            array(
                'label' => __('Dropdown Width', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => array(
                    'auto' => __('Auto', 'polylang-flag-switcher'),
                    'custom' => __('Custom', 'polylang-flag-switcher'),
                    'full' => __('Full Width (100%)', 'polylang-flag-switcher'),
                ),
                'condition' => array(
                    'display_type' => 'dropdown',
                ),
            )
        );

        $this->add_control(
            'dropdown_width_custom',
            array(
                'label' => __('Custom Width', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'vw'),
                'range' => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 500,
                        'step' => 10,
                    ),
                    '%' => array(
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ),
                    'vw' => array(
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ),
                ),
                'default' => array(
                    'unit' => 'px',
                    'size' => 200,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .pfs-language-dropdown' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'display_type' => 'dropdown',
                    'dropdown_width_type' => 'custom',
                ),
            )
        );

        $this->add_control(
            'add_link',
            array(
                'label' => __('Add Link to Single Flag', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => array(
                    'display_type' => 'single',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'advanced_section',
            array(
                'label' => __('Advanced', 'polylang-flag-switcher'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'custom_css',
            array(
                'label' => __('Custom CSS', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::CODE,
                'language' => 'css',
                'rows' => 10,
            )
        );

        $this->add_control(
            'css_class',
            array(
                'label' => __('CSS Class', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Additional CSS class', 'polylang-flag-switcher'),
            )
        );

        $this->add_control(
            'element_id',
            array(
                'label' => __('Element ID', 'polylang-flag-switcher'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Custom element ID', 'polylang-flag-switcher'),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (!function_exists('PLL')) {
            echo '<div class="elementor-alert elementor-alert-danger">' . __('Polylang plugin is not active.', 'polylang-flag-switcher') . '</div>';
            return;
        }

        $options = array(
            'style' => $settings['flag_style'],
            'layout' => $settings['layout'],
            'size' => $settings['size'],
            'display_format' => $settings['display_format'],
            'native_name' => $settings['native_names'] === 'yes',
            'show_current' => $settings['show_current'] === 'yes',
            'hide_current' => $settings['hide_current'] === 'yes',
            'show_current_in_dropdown' => $settings['show_current_in_dropdown'] === 'yes',
            'force_home' => $settings['force_home'] === 'yes',
            'transparent_mode' => $settings['transparent_mode'] === 'yes',
            'dropdown_width_type' => $settings['dropdown_width_type'],
            'class' => $settings['css_class'],
            'id' => $settings['element_id'],
        );

        if (!empty($settings['custom_css'])) {
            $options['custom_css'] = $settings['custom_css'];
        }

        $output = '';

        switch ($settings['display_type']) {
            case 'dropdown':
                $output = $this->generate_language_dropdown($options);
                break;
            case 'single':
                $options['language'] = $settings['single_language'];
                $options['link'] = $settings['add_link'] === 'yes';
                $output = $this->generate_single_flag($options);
                break;
            default:
                $output = $this->generate_flag_switcher($options);
                break;
        }

        // Show placeholder in Elementor Editor if no output
        if (empty($output)) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="pfs-editor-placeholder" style="padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; text-align: center; color: #fff;">';
                echo '<span class="eicon-language" style="font-size: 32px; display: block; margin-bottom: 10px;"></span>';
                echo '<strong>' . __('Polylang Flag Switcher', 'polylang-flag-switcher') . '</strong><br>';
                echo '<small>' . __('No languages configured in Polylang. Please add languages in Settings → Languages.', 'polylang-flag-switcher') . '</small>';
                echo '</div>';
            }
            return;
        }

        echo $output;

        // Add inline JavaScript for dropdown functionality (works in Elementor Editor)
        if ($settings['display_type'] === 'dropdown') {
?>
            <script>
                (function() {
                    // Wait for DOM to be ready
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initPFSDropdown);
                    } else {
                        initPFSDropdown();
                    }

                    function initPFSDropdown() {
                        var dropdowns = document.querySelectorAll('.pfs-language-dropdown');

                        dropdowns.forEach(function(dropdown) {
                            var currentDisplay = dropdown.querySelector('.pfs-current-display');

                            if (!currentDisplay) return;

                            // Remove existing listeners
                            var newCurrentDisplay = currentDisplay.cloneNode(true);
                            currentDisplay.parentNode.replaceChild(newCurrentDisplay, currentDisplay);
                            currentDisplay = newCurrentDisplay;

                            // Toggle dropdown
                            currentDisplay.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                // Close other dropdowns
                                document.querySelectorAll('.pfs-language-dropdown.active').forEach(function(other) {
                                    if (other !== dropdown) {
                                        other.classList.remove('active');
                                    }
                                });

                                // Toggle current
                                dropdown.classList.toggle('active');
                            });

                            // Set ARIA attributes
                            currentDisplay.setAttribute('role', 'button');
                            currentDisplay.setAttribute('tabindex', '0');
                            currentDisplay.setAttribute('aria-expanded', 'false');
                            currentDisplay.setAttribute('aria-haspopup', 'true');
                        });

                        // Close on outside click
                        document.addEventListener('click', function(e) {
                            if (!e.target.closest('.pfs-language-dropdown')) {
                                document.querySelectorAll('.pfs-language-dropdown.active').forEach(function(dropdown) {
                                    dropdown.classList.remove('active');
                                });
                            }
                        });
                    }
                })();
            </script>
<?php
        }
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

        $options = pfs_sanitize_options($options);
        $css_classes = pfs_generate_css_classes($options);

        if (!empty($options['class'])) {
            $css_classes .= ' ' . esc_attr($options['class']);
        }

        $html = '<div class="' . $css_classes . '"';

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
        // Support both pll_the_languages() and direct PLL() API formats
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

        // Use format_language_display
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
        $name = $options['native_name']
            ? $lang_data['name']
            : (isset($lang_data['translated_name']) ? $lang_data['translated_name'] : $lang_data['name']);
        $flag_url = !empty($lang_data['flag']) ? $lang_data['flag'] : pfs_get_default_flag($lang_code);

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

        // Flag
        if (!empty($flag_url)) {
            $html .= '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($name) . '" class="pfs-flag" />';
        }

        // Language name
        if ($options['show_name']) {
            $html .= '<span class="pfs-language-name">' . esc_html($name) . '</span>';
        }

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

        if (!empty($options['dropdown_width_type']) && $options['dropdown_width_type'] === 'full') {
            $css_classes[] = 'pfs-full-width';
        }

        if (!empty($options['class'])) {
            $css_classes[] = esc_attr($options['class']);
        }

        $html = '<div class="' . implode(' ', $css_classes) . '"';

        if (!empty($options['id'])) {
            $html .= ' id="' . esc_attr($options['id']) . '"';
        }

        $html .= '>';

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
