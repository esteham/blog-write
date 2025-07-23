<?php
// Shortcode for the blog writing form
function blog_write_form_shortcode() {
    if (!is_user_logged_in()) {
        return '<div class="blog-write-notice">Please login to write a blog post.</div>';
    }
    
    ob_start();
    include BLOG_WRITE_PATH . 'templates/blog-form.php';
    return ob_get_clean();
}
add_shortcode('blog_write_form', 'blog_write_form_shortcode');

// Shortcode to display user's posts
function blog_write_display_posts_shortcode() {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/user-posts.php';
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');