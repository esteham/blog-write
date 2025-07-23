<?php
function blog_write_form_shortcode($atts = []) {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/blog-form.php';
    return ob_get_clean();
}
add_shortcode('blog_write_form', 'blog_write_form_shortcode');

function blog_write_display_posts_shortcode($atts = []) {
    if (!is_user_logged_in()) {
        return '<p>Please log in to view your posts.</p>';
    }
    
    ob_start();
    include BLOG_WRITE_PATH . 'templates/user-posts.php';
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');