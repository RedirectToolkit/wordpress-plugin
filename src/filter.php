<?php

add_filter('pre_get_shortlink', function ($post_id) {
    $post = get_post($post_id);

    if (!$post->ID || !in_array($post->post_status, ['publish', 'private'])) {
        return false;
    }

    $shortlink = get_post_meta($post->ID, 'rdir_shortlink', true);

    if ($shortlink && is_string($shortlink)) {
        return $shortlink;
    }

    $slugs = array();

    if ($customSlug = get_post_meta($post->ID, 'rdir_post_slug', true)) {
        $slugs[] = $customSlug;
    }

    if (get_option('rdir_use_slugs')) {
        $slugs[] = $post->post_name;
        for ($i = 1; $i < 6; $i++) {
            $slugs[] = $slugs[0].'-'.$i;
        }
    }

    $slugs[] = null;

    foreach ($slugs as $slug) {
        $rdir_shortlink = rdir_shortlink_generator($post, $slug);

        if ($rdir_shortlink) {
            break;
        }
    }

    if (false === $rdir_shortlink) {
        return $shortlink ?: false;
    }

    $shortlink = $rdir_shortlink;

    if (!add_post_meta($post->ID, 'rdir_shortlink', $shortlink, true)) {
        update_post_meta($post->ID, 'rdir_shortlink', $shortlink);
    }

    return $shortlink;
});

if (!get_option('rdir_dont_replace_permalinks')) {
    add_filter('the_permalink', function ($url) {
        $postId = url_to_postid($url);

        return get_post_meta($postId, 'rdir_shortlink', true) ?: $url;
    });
}

add_filter('sharing_permalink', function ($url, $post_id) {
    return get_post_meta($post_id, 'rdir_shortlink', true) ?: $url;
}, 10, 2);
