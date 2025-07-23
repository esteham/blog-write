<?php
function blog_write_get_user_posts() {
    $user_id = get_current_user_id();
    
    $args = array(
        'author'         => $user_id,
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    
    return new WP_Query($args);
}