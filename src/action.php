<?php

add_action('save_post', function ($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['rdir_post_settings_nonce'])) {
        return;
    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['rdir_post_settings_nonce'], 'rdir_post_settings')) {
        return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sanitize user input.
    $rdirPostTags = sanitize_text_field($_POST['rdir_post_tags']);
    // Update the meta field in the database.
    update_post_meta($post_id, 'rdir_post_tags', $rdirPostTags);

    // Sanitize user input.
    $rdirPostSlug = sanitize_text_field($_POST['rdir_post_slug']);
    // Update the meta field in the database.
    update_post_meta($post_id, 'rdir_post_slug', $rdirPostSlug);

    // Sanitize user input.
    $rdirShortlink = sanitize_text_field($_POST['rdir_shortlink']);
    // Update the meta field in the database.
    update_post_meta($post_id, 'rdir_shortlink', $rdirShortlink);
});

add_action('admin_notices', function () {
    if (!get_option('rdir_api_key')) {
        require_once __DIR__.'/../tpl/admin_notice.php';
    }
});
