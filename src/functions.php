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
    $handler = curl_init();
    curl_setopt($handler, CURLOPT_HEADER, false);
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handler, CURLOPT_URL, 'http://api.rdir.io/links');
    curl_setopt($handler, CURLOPT_POST, true);
    curl_setopt($handler, CURLOPT_HTTPHEADER, array(
        'X-Authorization: '.get_option('rdir_api_key'),
    ));
    curl_setopt($handler, CURLOPT_POSTFIELDS, array(
        'link' => array(
            'url' => $url,
            'host' => 'rdir.io',
            'settings' => array(
                'tags' => get_option('rdir_global_tags'),
            ),
        ),
    ));
    $response = curl_exec($handler);
    curl_close($handler);

    if (!$response) {
        return false;
    }

    $json = json_decode($response);
    if (!$json || $json->ok != true || is_string($json->output)) {
        return false;
    }

    return $json->output;
}
