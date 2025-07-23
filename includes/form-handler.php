<?php
function blog_write_handle_submission() {
    if (isset($_POST['blog_write_submit']) && wp_verify_nonce($_POST['blog_write_nonce'], 'blog_write_action')) {
        $user_id = get_current_user_id();
        $title = sanitize_text_field($_POST['blog_title']);
        $content = wp_kses_post($_POST['blog_content']);
        
        $new_post = array(
            'post_title'    => $title,
            'post_content'  => $content,
            'post_status'   => 'publish',
            'post_author'   => $user_id,
            'post_type'     => 'post'
        );
        
        $post_id = wp_insert_post($new_post);
        
        if ($post_id) {
            // Handle featured image upload if needed
            if (!empty($_FILES['featured_image']['name'])) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                
                $attachment_id = media_handle_upload('featured_image', $post_id);
                
                if (!is_wp_error($attachment_id)) {
                    set_post_thumbnail($post_id, $attachment_id);
                }
            }
            
            wp_redirect(add_query_arg('blog_write_success', '1', get_permalink()));
            exit;
        }
    }
}
add_action('init', 'blog_write_handle_submission');