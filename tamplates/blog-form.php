<div class="blog-write-container">
    <?php if (isset($_GET['blog_write_success'])) : ?>
        <div class="blog-write-notice success">Your blog post has been published successfully!</div>
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data" class="blog-write-form">
        <?php wp_nonce_field('blog_write_action', 'blog_write_nonce'); ?>
        
        <div class="form-group">
            <label for="blog_title">Post Title</label>
            <input type="text" name="blog_title" id="blog_title" required>
        </div>
        
        <div class="form-group">
            <label for="blog_content">Post Content</label>
            <?php 
            wp_editor('', 'blog_content', array(
                'textarea_name' => 'blog_content',
                'media_buttons' => true,
                'teeny'         => true
            )); 
            ?>
        </div>
        
        <div class="form-group">
            <label for="featured_image">Featured Image</label>
            <input type="file" name="featured_image" id="featured_image">
        </div>
        
        <div class="form-group">
            <input type="submit" name="blog_write_submit" value="Publish Post">
        </div>
    </form>
</div>