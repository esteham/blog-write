<?php
function blog_write_form_shortcode($atts = []) {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/blog-form.php';
    return ob_get_clean();
}
add_shortcode('blog_write_form', 'blog_write_form_shortcode');

function blog_write_display_posts_shortcode($atts = []) {
    ob_start();
    
    $submitted_posts = blog_write_get_form_submitted_posts();
    
    if ($submitted_posts && $submitted_posts->have_posts()) {
        echo '<div class="blog-write-posts">';
        while ($submitted_posts->have_posts()) : $submitted_posts->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" class="blog-write-post">
                <header class="entry-header">
                    <h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="entry-meta">
                        <span class="posted-on">Posted on <?php echo get_the_date(); ?></span>
                        <?php if (current_user_can('edit_posts')): ?>
                            <span class="post-status"> | Status: <?php echo ucfirst(get_post_status()); ?></span>
                        <?php endif; ?>
                    </div>
                </header>
                
                <?php if (has_post_thumbnail()): ?>
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'wp-post-image']); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>" class="read-more">Continue reading</a>
                </div>
            </article>
            <?php
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<div class="blog-write-no-posts">';
        echo '<p>No posts found in the blog write system.</p>';
        
        // Admin debug information
        if (current_user_can('manage_options')) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'blog_write_posts';
            
            echo '<div class="blog-write-debug-info">';
            echo '<h4>Debug Information (Admin Only)</h4>';
            
            // Check if table exists
            $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
            echo '<p>Custom table exists: ' . ($table_exists ? 'Yes' : 'No') . '</p>';
            
            if ($table_exists) {
                // Count posts in custom table
                $custom_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
                echo '<p>Total posts in custom table: ' . $custom_count . '</p>';
                
                // Count posts that exist in both tables
                $valid_count = $wpdb->get_var(
                    "SELECT COUNT(*) FROM $table_name bw
                     INNER JOIN {$wpdb->posts} p ON bw.post_id = p.ID
                     WHERE p.post_type = 'post'"
                );
                echo '<p>Valid WordPress posts: ' . $valid_count . '</p>';
                
                // List invalid post IDs (in custom table but not in wp_posts)
                $invalid_ids = $wpdb->get_col(
                    "SELECT bw.post_id FROM $table_name bw
                     LEFT JOIN {$wpdb->posts} p ON bw.post_id = p.ID
                     WHERE p.ID IS NULL"
                );
                
                if (!empty($invalid_ids)) {
                    echo '<p>Invalid post IDs in custom table: ' . implode(', ', $invalid_ids) . '</p>';
                }
            }
            
            echo '</div>';
        }
        echo '</div>';
    }
    
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');