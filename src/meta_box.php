<?php

add_action('add_meta_boxes', function ($post_type) {
    add_meta_box('rdir_post_settings', 'Redirect Toolkit', function ($object, $box) {
        require_once __DIR__.'/../tpl/meta_box.php';
    }, 'post', 'normal', 'default');
    add_meta_box('rdir_post_settings', 'Redirect Toolkit', function ($object, $box) {
        require_once __DIR__.'/../tpl/meta_box.php';
    }, 'page', 'normal', 'default');
});
