<?php
function blog_write_form_shortcode($atts = []) {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/blog-form.php';
    return ob_get_clean();
}
add_shortcode('blog_write_form', 'blog_write_form_shortcode');

function blog_write_display_posts_shortcode($atts = []) {
    ob_start();
    
    if (is_user_logged_in()) {
        include BLOG_WRITE_PATH . 'templates/user-posts.php';
    } else {
        echo '<p class="blog-write-login-notice">Please <a href="' . wp_login_url(get_permalink()) . '">log in</a> to view your posts.</p>';
    }
    
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');