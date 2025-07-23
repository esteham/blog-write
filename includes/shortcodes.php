<?php
function blog_write_form_shortcode() {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/blog-form.php';
    return ob_get_clean();
}
add_shortcode('blog_write_form', 'blog_write_form_shortcode');

function blog_write_display_posts_shortcode() {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/user-posts.php';
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');