<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;
$table_name = $wpdb->prefix . 'blog_write_posts';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

delete_option('blog_write_default_status');
delete_option('blog_write_enable_recaptcha');
delete_option('blog_write_recaptcha_site_key');
delete_option('blog_write_recaptcha_secret_key');