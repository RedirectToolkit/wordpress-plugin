<?php
/**
 * @package Redirect Toolkit
 * @version 0.0.1
 */
/*
Plugin Name: Redirect Toolkit
Plugin URI: https://github.com/RedirectToolkit/wordpress-plugin
Description: This plugin allows you to create automatically short link for posts and pages using rdir.io.
Author: Redirect Toolkit
Version: 0.0.1
Author URI: http://rdir.io/
*/

defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

add_filter('pre_get_shortlink', function ($post_id) {
    $post = get_post($post_id);

    if (!$post->ID) {
        return false;
    }

    $shortlink = get_post_meta($post->ID, 'rdir_shortlink', true);

    if (is_string($shortlink) && 'rdir.io' == parse_url($shortlink, PHP_URL_HOST)) {
        return $shortlink;
    }

    require_once __DIR__.'/src/settings.php';
    $rdir_shortlink = rdir_shortlink_generator($post->guid);

    if (false === $rdir_shortlink) {
        return $shortlink ?: false;
    }

    $shortlink = $rdir_shortlink;

    if (!add_post_meta($post->ID, 'rdir_shortlink', $shortlink, true)) {
        update_post_meta($post->ID, 'rdir_shortlink', $shortlink);
    }

    return $shortlink;
});

// create custom plugin settings menu
add_action('admin_menu', function () {
    // create new top-level menu
    add_menu_page('Redirect Toolkit', 'Redirect Toolkit', 'administrator', __FILE__, function () {
        require_once __DIR__.'/tpl/settings.php';
    });

    add_action('admin_init', function () {
        // register our settings
        register_setting('rdir-settings-group', 'rdir_api_key');
        register_setting('rdir-settings-group', 'rdir_global_tags');
    });
});
