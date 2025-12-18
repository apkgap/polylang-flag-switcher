<?php

/**
 * Plugin Name: Polylang Flag Switcher
 * Plugin URI: https://example.com/polylang-flag-switcher
 * Description: A comprehensive plugin for displaying flag buttons to switch languages with Polylang. Includes shortcodes and Elementor widgets.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: polylang-flag-switcher
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Tested up to: 6.0
 */

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('PFS_VERSION', '1.0.0');
define('PFS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PFS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PFS_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
class Polylang_Flag_Switcher
{

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'init'));
        add_action('init', array($this, 'load_textdomain'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }

    /**
     * Initialize the plugin
     */
    public function init()
    {
        // Include required files FIRST (needed for Elementor controls even without Polylang)
        $this->includes();

        // Check if Polylang is active
        if (!function_exists('PLL')) {
            add_action('admin_notices', array($this, 'polylang_not_active_notice'));
            // Still initialize Elementor widget even without Polylang (for controls to work)
        } else {
            // Initialize shortcodes (only when Polylang is active)
            $this->init_shortcodes();
        }

        // Initialize Elementor widget only if Elementor is active
        if (did_action('elementor/loaded')) {
            $this->init_elementor();
        } else {
            add_action('elementor/loaded', array($this, 'init_elementor'));
        }

        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain()
    {
        load_plugin_textdomain('polylang-flag-switcher', false, dirname(PFS_PLUGIN_BASENAME) . '/languages');
    }

    /**
     * Include required files
     */
    private function includes()
    {
        require_once PFS_PLUGIN_DIR . 'includes/functions.php';
        require_once PFS_PLUGIN_DIR . 'includes/shortcodes.php';
    }

    /**
     * Initialize shortcodes
     */
    private function init_shortcodes()
    {
        new PFS_Shortcodes();
    }

    /**
     * Initialize Elementor widgets
     */
    public function init_elementor()
    {
        // Register widgets with the proper hook for Elementor 3.5+
        add_action('elementor/widgets/register', array($this, 'register_elementor_widgets'));
    }

    /**
     * Register Elementor widgets
     * 
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager
     */
    public function register_elementor_widgets($widgets_manager)
    {
        // Require the widget file
        require_once PFS_PLUGIN_DIR . 'widgets/flag-switcher-widget.php';

        // Register the widget
        $widgets_manager->register(new \PFS_Flag_Switcher_Widget());
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style(
            'pfs-frontend-style',
            PFS_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            PFS_VERSION
        );

        wp_enqueue_script(
            'pfs-frontend-script',
            PFS_PLUGIN_URL . 'assets/js/frontend.js',
            array(), // No dependencies - Pure ES6
            PFS_VERSION,
            true
        );

        wp_localize_script('pfs-frontend-script', 'pfs_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pfs_nonce'),
        ));
    }

    /**
     * Enqueue admin scripts and styles
     */
    public function admin_enqueue_scripts()
    {
        wp_enqueue_style(
            'pfs-admin-style',
            PFS_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            PFS_VERSION
        );
    }

    /**
     * Plugin activation
     */
    public function activate()
    {
        // Activation tasks
        flush_rewrite_rules();
    }

    /**
     * Plugin deactivation
     */
    public function deactivate()
    {
        // Deactivation tasks
        flush_rewrite_rules();
    }

    /**
     * Show notice if Polylang is not active
     */
    public function polylang_not_active_notice()
    {
?>
        <div class="notice notice-error">
            <p><?php _e('Polylang Flag Switcher requires Polylang plugin to be installed and activated.', 'polylang-flag-switcher'); ?></p>
        </div>
<?php
    }
}

// Initialize the plugin
new Polylang_Flag_Switcher();
