<?php
/**
 * @package Redirect Toolkit
 * @version 0.1.0
 */
/*
Plugin Name: Redirect Toolkit
Plugin URI: https://github.com/RedirectToolkit/wordpress-plugin
Description: This plugin allows you to create automatically short link for posts and pages using rdir.io.
Author: Redirect Toolkit
Version: 0.1.0
Author URI: http://rdir.io/
*/

foreach (glob(__DIR__.'/src/*.php') as $source) {
    require_once $source;
}

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
        register_setting('rdir-settings-group', 'rdir_global_host');
        register_setting('rdir-settings-group', 'rdir_predefined_callback');
        register_setting('rdir-settings-group', 'rdir_use_slugs');
    });
});
