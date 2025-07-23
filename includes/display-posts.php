<?php
function blog_write_get_form_submitted_posts() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'blog_write_posts';
    
    // First check if the custom table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        error_log('Blog Write Plugin: Custom table does not exist');
        return false;
    }
    
    // Get post IDs with additional debug information
    $post_ids = $wpdb->get_col(
        "SELECT bw.post_id 
         FROM $table_name bw
         INNER JOIN {$wpdb->posts} p ON bw.post_id = p.ID
         WHERE p.post_type = 'post'
         AND p.post_status IN ('publish', 'pending', 'draft', 'private')
         ORDER BY p.post_date DESC"
    );
    
    // Debug logging
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Blog Write Plugin: Found ' . count($post_ids) . ' posts in custom table');
        if (!empty($post_ids)) {
            error_log('Blog Write Plugin: Post IDs: ' . implode(', ', $post_ids));
        }
    }
    
    if (empty($post_ids)) {
        return false;
    }
    
    // Get complete post objects with all required data
    $args = [
        'post__in'            => $post_ids,
        'post_type'          => 'post',
        'posts_per_page'     => -1,
        'orderby'            => 'post__in', // Maintain original order
        'post_status'        => ['publish', 'pending', 'draft', 'private'],
        'ignore_sticky_posts' => true,
        'no_found_rows'      => true, // For performance
    ];
    
    $query = new WP_Query($args);
    
    // Additional debug
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Blog Write Plugin: WP_Query found ' . $query->post_count . ' posts');
    }
    
    return $query;
}