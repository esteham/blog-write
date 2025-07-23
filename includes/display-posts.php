<?php
function blog_write_get_form_submitted_posts() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'blog_write_posts';
    
    // First check if the custom table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        error_log('Blog Write Plugin: Custom table does not exist');
        return false;
    }
    
    // Get complete post data in a single query
    $query_args = [
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'meta_query'     => [
            [
                'key'     => '_blog_write_submission',
                'compare' => 'EXISTS'
            ]
        ],
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => ['publish', 'pending', 'draft', 'private']
    ];
    
    $query = new WP_Query($query_args);
    
    // Debug logging
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Blog Write Plugin: WP_Query found ' . $query->post_count . ' posts');
        if ($query->post_count > 0) {
            error_log('Blog Write Plugin: Post IDs: ' . implode(', ', wp_list_pluck($query->posts, 'ID')));
        }
    }
    
    return $query;
}