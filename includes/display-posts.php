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