<?php
/*
Plugin Name: Blog Write
Plugin URI: https://xetout.xetroot.com/
Description: Allows users to write and publish blog posts from the frontend.
Version: 1.0
Author: Esteham H. Zihad Ansari
Author URI: https://xetroot.com
License: GPL2
*/

// Security check
defined('ABSPATH') or die('No direct access allowed!');

// Define plugin constants
define('BLOG_WRITE_PATH', plugin_dir_path(__FILE__));
define('BLOG_WRITE_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once BLOG_WRITE_PATH . 'includes/shortcodes.php';
require_once BLOG_WRITE_PATH . 'includes/form-handler.php';
require_once BLOG_WRITE_PATH . 'includes/display-posts.php';

// Load assets
function blog_write_load_assets() {
    wp_enqueue_style('blog-write-style', BLOG_WRITE_URL . 'assets/css/style.css');
    wp_enqueue_script('blog-write-script', BLOG_WRITE_URL . 'assets/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'blog_write_load_assets');