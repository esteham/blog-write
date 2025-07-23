<div class="wrap">
    <h1>Blog Write Settings</h1>
    
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <th scope="row">Default Post Status</th>
                <td>
                    <select name="default_status">
                        <option value="pending" <?php selected(get_option('blog_write_default_status'), 'pending'); ?>>Pending Review</option>
                        <option value="publish" <?php selected(get_option('blog_write_default_status'), 'publish'); ?>>Publish Immediately</option>
                        <option value="draft" <?php selected(get_option('blog_write_default_status'), 'draft'); ?>>Save as Draft</option>
                    </select>
                    <p class="description">Set the default status for new submissions</p>
                </td>
            </tr>
            <tr>
                <th scope="row">Enable reCAPTCHA</th>
                <td>
                    <label>
                        <input type="checkbox" name="enable_recaptcha" value="1" <?php checked(get_option('blog_write_enable_recaptcha'), 1); ?>>
                        Enable Google reCAPTCHA
                    </label>
                </td>
            </tr>
            <tr class="recaptcha-settings">
                <th scope="row">reCAPTCHA Site Key</th>
                <td>
                    <input type="text" name="recaptcha_site_key" value="<?php echo esc_attr(get_option('blog_write_recaptcha_site_key')); ?>" class="regular-text">
                </td>
            </tr>
            <tr class="recaptcha-settings">
                <th scope="row">reCAPTCHA Secret Key</th>
                <td>
                    <input type="text" name="recaptcha_secret_key" value="<?php echo esc_attr(get_option('blog_write_recaptcha_secret_key')); ?>" class="regular-text">
                </td>
            </tr>
        </table>
        
        <?php submit_button('Save Settings', 'primary', 'blog_write_settings_submit'); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    function toggleRecaptchaSettings() {
        if ($('input[name="enable_recaptcha"]').is(':checked')) {
            $('.recaptcha-settings').show();
        } else {
            $('.recaptcha-settings').hide();
        }
    }
    
    $('input[name="enable_recaptcha"]').change(toggleRecaptchaSettings);
    toggleRecaptchaSettings();
});
</script>