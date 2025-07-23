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
    
    $post_ids = $wpdb->get_col("SELECT post_id FROM $table_name");
    
    if (empty($post_ids)) {
        return false;
    }
    
    $args = [
        'post_type' => 'post',
        'post__in' => $post_ids,
        'post_status' => ['publish', 'pending', 'draft'],
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    
    return new WP_Query($args);
}