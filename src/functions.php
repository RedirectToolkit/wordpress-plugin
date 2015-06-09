<?php

// defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

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
    curl_setopt_array($handler, array(
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => array(
            'X-Authorization: '.get_option('rdir_api_key'),
        ),
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array(
            'link' => array(
                'url' => $url,
                'host' => 'rdir.io',
                'settings' => array(
                    'tags' => get_option('rdir_global_tags'),
                ),
            ),
        )),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => 'http://api.rdir.io/links',
    ));
    $response = @curl_exec($handler);
    curl_close($handler);

    if (!$response) {
        return false;
    }

    $json = json_decode($response);
    if (!$json || !$json->host || !$json->slug) {
        return false;
    }

    return sprintf('http://%s/%s', $json->host, $json->slug);
}
