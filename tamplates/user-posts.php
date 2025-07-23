<div class="blog-write-posts">
    <h3>Your Published Posts</h3>
    
    <?php 
    $user_posts = blog_write_get_user_posts();
    
    if ($user_posts && $user_posts->have_posts()) : 
        while ($user_posts->have_posts()) : $user_posts->the_post(); ?>
            <article class="blog-write-post">
                <h4><?php the_title(); ?></h4>
                <div class="post-meta">
                    Status: <?php echo get_post_status(); ?> | 
                    Published on: <?php echo get_the_date(); ?>
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
    else : ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>