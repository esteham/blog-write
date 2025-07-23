<?php
function blog_write_form_shortcode($atts = []) {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/blog-form.php';
    return ob_get_clean();
}
add_shortcode('blog_write_form', 'blog_write_form_shortcode');

function blog_write_display_posts_shortcode($atts = []) {
    ob_start();
    
    // Always show posts if user is logged in
    if (is_user_logged_in()) {
        $user_posts = blog_write_get_user_posts(get_current_user_id());
        
        if ($user_posts && $user_posts->have_posts()) {
            include BLOG_WRITE_PATH . 'templates/user-posts.php';
        } else {
            echo '<p>No posts found. Would you like to <a href="' . get_permalink() . '">create one</a>?</p>';
        }
    } else {
        // Show login message with link to login page
        $login_url = wp_login_url(get_permalink());
        $register_url = wp_registration_url();
        echo '<div class="blog-write-login-notice">';
        echo '<p>Please <a href="' . esc_url($login_url) . '">log in</a> to view your posts.</p>';
        echo '<p>Don\'t have an account? <a href="' . esc_url($register_url) . '">Register here</a>.</p>';
        echo '</div>';
    }
    
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');