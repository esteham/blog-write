<?php
function blog_write_display_posts_shortcode($atts = []) {
    ob_start();
    
    $submitted_posts = blog_write_get_form_submitted_posts();
    
    if ($submitted_posts && $submitted_posts->have_posts()) {
        echo '<div class="blog-write-posts">';
        while ($submitted_posts->have_posts()) : $submitted_posts->the_post(); 
            include BLOG_WRITE_PATH . 'templates/user-posts.php';
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No posts found in the blog write system.</p>';
        
        // Debug output (remove in production)
        if (current_user_can('manage_options')) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'blog_write_posts';
            $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
            echo '<div class="debug-info" style="display:none;">';
            echo 'Posts in custom table: ' . $count;
            echo '</div>';
        }
    }
    
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');