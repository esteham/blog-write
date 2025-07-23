<?php
function blog_write_form_shortcode($atts = []) {
    ob_start();
    include BLOG_WRITE_PATH . 'templates/blog-form.php';
    return ob_get_clean();
}
add_shortcode('blog_write_form', 'blog_write_form_shortcode');

function blog_write_display_posts_shortcode($atts = []) {
    ob_start();
    
    // Get all published posts for everyone (no login required)
    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    ];
    
    $all_posts = new WP_Query($args);
    
    if ($all_posts->have_posts()) {
        while ($all_posts->have_posts()) : $all_posts->the_post(); ?>
            <article class="blog-write-post">
                <h4><?php the_title(); ?></h4>
                <div class="post-meta">
                    Published on: <?php echo get_the_date(); ?>
                    <?php if (is_user_logged_in()): ?>
                        | Status: <?php echo ucfirst(get_post_status()); ?>
                    <?php endif; ?>
                </div>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                <?php endif; ?>
                <div class="post-content"><?php the_content(); ?></div>
            </article>
        <?php endwhile;
        wp_reset_postdata();
    } else {
        echo '<p>No posts found.</p>';
    }
    
    return ob_get_clean();
}
add_shortcode('blog_write_posts', 'blog_write_display_posts_shortcode');