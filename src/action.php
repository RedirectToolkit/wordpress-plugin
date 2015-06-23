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

// this is slightly modified from the original
// rel_canonical function in /wp-includes/link-template.php
if (get_option('rdir_replace_canonical')) {
    remove_action('wp_head', 'rel_canonical');
    add_action('wp_head', function () {
        // original code
        if (!is_singular()) {
            return;
        }

        global $wp_the_query;
        if (!$id = $wp_the_query->get_queried_object_id()) {
            return;
        }

        // new code - if there is a meta property defined
        // use that as the canonical url
        $canonical = get_post_meta($id, 'rdir_shortlink', true);
        if ($canonical) {
            echo "<link rel='canonical' href='".$canonical."' />\n";

            return;
        }

        // original code
        $link = get_permalink($id);
        if ($page = get_query_var('cpage')) {
            $link = get_comments_pagenum_link($page);
        }

        echo "<link rel='canonical' href='".$link."' />\n";
    });
}
