<?php
function blog_write_get_user_posts($user_id = null) {
    if (!$user_id && is_user_logged_in()) {
        $user_id = get_current_user_id();
    } elseif (!$user_id) {
        return false;
    }
    
    $args = [
        'author' => $user_id,
        'post_type' => 'post',
        'post_status' => ['publish', 'pending', 'draft'],
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    
    return new WP_Query($args);
}

function blog_write_get_form_submitted_posts() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'blog_write_posts';
    
    // Get only posts that exist in WordPress (inner join with posts table)
    $query = $wpdb->prepare(
        "SELECT p.* FROM {$wpdb->posts} p
        INNER JOIN $table_name bw ON p.ID = bw.post_id
        WHERE p.post_type = 'post'
        AND p.post_status IN ('publish', 'pending', 'draft')
        ORDER BY p.post_date DESC"
    );
    
    $post_ids = $wpdb->get_col($query);
    
    if (empty($post_ids)) {
        return false;
    }
    
    return new WP_Query([
        'post__in' => $post_ids,
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'post__in', // Maintain the order from our query
        'post_status' => ['publish', 'pending', 'draft']
    ]);
}