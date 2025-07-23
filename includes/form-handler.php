<?php
function blog_write_handle_submission() {
    if (isset($_POST['blog_write_submit']) && isset($_POST['blog_write_nonce']) && wp_verify_nonce($_POST['blog_write_nonce'], 'blog_write_action')){
        
        // Verify reCAPTCHA if enabled
        if (get_option('blog_write_enable_recaptcha')) {
            $recaptcha_secret = get_option('blog_write_recaptcha_secret_key');
            $recaptcha_response = isset($_POST['g-recaptcha-response']) ? sanitize_text_field($_POST['g-recaptcha-response']) : '';
            
            $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
                'body' => [
                    'secret' => $recaptcha_secret,
                    'response' => $recaptcha_response,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                ]
            ]);
            
            if (!is_wp_error($response)) {
                $response_data = json_decode(wp_remote_retrieve_body($response));
                if (!$response_data->success) {
                    wp_die('reCAPTCHA verification failed. Please try again.');
                }
            }
        }
        
        // Handle author
        if (is_user_logged_in()) {
            $author_id = get_current_user_id();
        } else {
            // Create guest author automatically
            $author_id = 1; // Or set to default admin ID
        }
        
        // Validate required fields
        if (empty($_POST['blog_title']) || empty($_POST['blog_content'])) {
            wp_die('Post title and content are required.');
        }
        
        // Create post
        $new_post = [
            'post_title' => sanitize_text_field($_POST['blog_title']),
            'post_content' => wp_kses_post($_POST['blog_content']),
            'post_status' => get_option('blog_write_default_status', 'pending'),
            'post_author' => $author_id,
            'post_type' => 'post'
        ];
        
        $post_id = wp_insert_post($new_post, true);
        
        if (is_wp_error($post_id)) {
            wp_die($post_id->get_error_message());
        }
        
        // Handle featured image
        if (!empty($_FILES['featured_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            
            $attachment_id = media_handle_upload('featured_image', $post_id);
            if (!is_wp_error($attachment_id)) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
        
        // Handle categories if needed
        if (!empty($_POST['blog_category'])) {
            wp_set_post_categories($post_id, [intval($_POST['blog_category'])]);
        }
        
        // Redirect with success message
        wp_redirect(add_query_arg('blog_write_success', '1', wp_get_referer()));
        exit;
    }
}
add_action('init', 'blog_write_handle_submission');