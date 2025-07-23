<?php
function blog_write_handle_submission() {
    if (isset($_POST['blog_write_submit']) && wp_verify_nonce($_POST['blog_write_nonce'], 'blog_write_action')) {
        
        // Verify reCAPTCHA if enabled
        if (get_option('blog_write_enable_recaptcha')) {
            $recaptcha_secret = get_option('blog_write_recaptcha_secret_key');
            $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
            
            $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
                'body' => [
                    'secret' => $recaptcha_secret,
                    'response' => $recaptcha_response,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                ]
            ]);
            
            $response_data = json_decode(wp_remote_retrieve_body($response));
            if (!$response_data->success) {
                wp_die('reCAPTCHA verification failed. Please try again.');
            }
        }
        
        // Handle author
        if (is_user_logged_in()) {
            $author_id = get_current_user_id();
        } else {
            $guest_name = sanitize_text_field($_POST['guest_name']);
            $guest_email = sanitize_email($_POST['guest_email']);
            
            // Create guest user if email doesn't exist
            $user_id = email_exists($guest_email);
            if (!$user_id) {
                $random_password = wp_generate_password();
                $user_id = wp_create_user($guest_email, $random_password, $guest_email);
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $guest_name,
                    'role' => 'guest_author'
                ]);
            }
            $author_id = $user_id;
        }
        
        // Create post
        $new_post = [
            'post_title' => sanitize_text_field($_POST['blog_title']),
            'post_content' => wp_kses_post($_POST['blog_content']),
            'post_status' => get_option('blog_write_default_status', 'pending'),
            'post_author' => $author_id,
            'post_type' => 'post'
        ];
        
        $post_id = wp_insert_post($new_post);
        
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
        
        wp_redirect(add_query_arg('blog_write_success', '1', get_permalink()));
        exit;
    }
}
add_action('init', 'blog_write_handle_submission');