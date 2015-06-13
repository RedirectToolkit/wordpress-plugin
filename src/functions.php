<?php

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
        CURLINFO_HEADER_OUT => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => array(
            'X-Authorization: '.get_option('rdir_api_key'),
        ),
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array(
            'link' => array(
                'url' => $url,
                'host' => get_option('rdir_global_host') ?: 'rdir.io',
                'settings' => array(
                    'tags' => get_option('rdir_global_tags'),
                ),
            ),
        )),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => 'http://api.rdir.io/links',
    ));
    $response = curl_exec($handler);
    curl_close($handler);

    if (!$response) {
        return false;
    }

    $data = json_decode($response, true);
    if (!isset($data['shortlink'])) {
        return false;
    }

    return $data['shortlink'];
}
