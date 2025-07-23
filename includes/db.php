<?php
function blog_write_create_db_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'blog_write_posts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        post_id bigint(20) NOT NULL,
        submitted_by varchar(255) NOT NULL,
        submitted_at datetime NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'blog_write_create_db_table');