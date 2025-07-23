<div class="blog-write-container">
    <?php if (isset($_GET['blog_write_success'])) : ?>
        <div class="blog-write-notice success">
            <?php 
            $status = get_option('blog_write_default_status', 'pending');
            if ($status === 'publish') {
                echo 'Your blog post has been published successfully!';
            } else {
                echo 'Thank you! Your post has been submitted for review.';
            }
            ?>
        </div>
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data" class="blog-write-form">
        <?php wp_nonce_field('blog_write_action', 'blog_write_nonce'); ?>
        
        <?php if (!is_user_logged_in()) : ?>
            <div class="form-group">
                <label for="guest_name">Your Name *</label>
                <input type="text" name="guest_name" id="guest_name" required>
            </div>
            <div class="form-group">
                <label for="guest_email">Your Email *</label>
                <input type="email" name="guest_email" id="guest_email" required>
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="blog_title">Post Title *</label>
            <input type="text" name="blog_title" id="blog_title" required>
        </div>
        
        <div class="form-group">
            <label for="blog_content">Post Content *</label>
            <?php 
            wp_editor('', 'blog_content', [
                'textarea_name' => 'blog_content',
                'media_buttons' => true,
                'teeny' => true,
                'quicktags' => true
            ]); 
            ?>
        </div>
        
        <div class="form-group">
            <label for="featured_image">Featured Image</label>
            <input type="file" name="featured_image" id="featured_image" accept="image/*">
        </div>
        
        <div class="form-group">
            <label for="blog_category">Category</label>
            <?php
            wp_dropdown_categories([
                'name' => 'blog_category',
                'id' => 'blog_category',
                'show_option_none' => 'Select a category',
                'option_none_value' => '',
                'hide_empty' => false
            ]);
            ?>
        </div>
        
        <?php if (get_option('blog_write_enable_recaptcha')) : ?>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_option('blog_write_recaptcha_site_key')); ?>"></div>
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <input type="submit" name="blog_write_submit" value="Submit Post">
        </div>
    </form>
</div>