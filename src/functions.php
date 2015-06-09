<?php

defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

/**
 * Rdir.io short link generation.
 *
 * @param string $url Long URL.
 *
 * @return string
 */
function rdir_shortlink_generator($url)
{
    $api = sprintf(
        'http://rdir.io/tmp_api/new?url=%s&tags=%s&api_key=%s',
        urlencode($url),
        urlencode(get_option('rdir_global_tags')),
        urlencode(get_option('rdir_api_key'))
    );
    $response = wp_remote_get($api);

    if (!$response || !is_array($response) || $response['response']['code'] != 200 || $response['body'] == '') {
        return false;
    }

    $json = json_decode($response['body']);
    if (!$json || $json->ok != true || is_string($json->output)) {
        return false;
    }

    return $json->output;
}
