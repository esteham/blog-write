<?php
/*
Plugin Name: Blog Write
Plugin URI: https://xetout.xetroot.com
Description: Allows users and guests to write and publish blog posts from the frontend.
Version: 1.0
Author: Esteham H Zihad Ansari
Author URI: https://xetroot.com
License: GPL2
*/

defined('ABSPATH') or die('No direct access allowed!');

// Define plugin constants
define('BLOG_WRITE_PATH', plugin_dir_path(__FILE__));
define('BLOG_WRITE_URL', plugin_dir_url(__FILE__));

// Activation hook
function blog_write_activate() {
    // Create guest author role
    if (!get_role('guest_author')) {
        add_role('guest_author', 'Guest Author', array(
            'read' => true,
        ));
    }
    
    // Set default options
    add_option('blog_write_default_status', 'pending');
    add_option('blog_write_enable_recaptcha', 0);
    add_option('blog_write_recaptcha_site_key', '');
    add_option('blog_write_recaptcha_secret_key', '');
}
register_activation_hook(__FILE__, 'blog_write_activate');

// Include necessary files
require_once BLOG_WRITE_PATH . 'includes/shortcodes.php';
require_once BLOG_WRITE_PATH . 'includes/form-handler.php';
require_once BLOG_WRITE_PATH . 'includes/display-posts.php';

// Load assets
function blog_write_load_assets() {
    wp_enqueue_style('blog-write-style', BLOG_WRITE_URL . 'assets/css/style.css');
    wp_enqueue_script('blog-write-script', BLOG_WRITE_URL . 'assets/js/script.js', array('jquery'), '1.0', true);
    
    // Add reCAPTCHA if enabled
    if (get_option('blog_write_enable_recaptcha')) {
        wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js');
    }
}
add_action('wp_enqueue_scripts', 'blog_write_load_assets');

// Admin settings
function blog_write_settings_page() {
    add_options_page(
        'Blog Write Settings',
        'Blog Write',
        'manage_options',
        'blog-write-settings',
        'blog_write_settings_page_html'
    );
}
add_action('admin_menu', 'blog_write_settings_page');

function blog_write_settings_page_html() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Save settings if form submitted
    if (isset($_POST['blog_write_settings_submit'])) {
        check_admin_referer('blog_write_settings');
        
        update_option('blog_write_enable_recaptcha', isset($_POST['enable_recaptcha']) ? 1 : 0);
        update_option('blog_write_recaptcha_site_key', sanitize_text_field($_POST['recaptcha_site_key']));
        update_option('blog_write_recaptcha_secret_key', sanitize_text_field($_POST['recaptcha_secret_key']));
        update_option('blog_write_default_status', sanitize_text_field($_POST['default_status']));
        
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    
    // Include settings template
    include BLOG_WRITE_PATH . 'templates/settings-page.php';
}

// Initialize plugin
function blog_write_init() {
    // Nothing needed here for now
}
add_action('plugins_loaded', 'blog_write_init');