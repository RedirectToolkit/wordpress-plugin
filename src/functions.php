<?php

/**
 * Rdir.io short link generation.
 *
 * @param mixed  $post Post object.
 * @param string $slug If is not null, the system will try to generate a shortlink with passed slug.
 *
 * @return string
 */
function rdir_shortlink_generator($post, $slug = null)
{
    $data = rdir_request('links', array(
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array(
            'link' => array(
                'host' => get_option('rdir_global_host') ?: 'rdir.io',
                'settings' => array(
                    'tags' => get_post_meta($post->ID, 'rdir_post_tags', true) ?: get_option('rdir_global_tags'),
                    'callback' => get_option('rdir_predefined_callback'),
                ),
                'slug' => $slug,
                'url' => $post->guid,
            ),
        )),
    ));

    if (!$data || !isset($data['shortlink'])) {
        return false;
    }

    return $data['shortlink'];
}

/**
 * Generic request to api.rdir.io.
 *
 * @param string $api     API route.
 * @param array  $options Request options (optional).
 *
 * @return mixed
 */
function rdir_request($api, array $options = array())
{
    $handler = curl_init();

    curl_setopt_array($handler, array(
        CURLINFO_HEADER_OUT => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'X-Authorization: '.get_option('rdir_api_key'),
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => 'http://api.rdir.io/'.ltrim($api, '/'),
    ) + $options);

    $response = curl_exec($handler);

    if (curl_error($handler)) {
        curl_close($handler);

        return false;
    }

    curl_close($handler);

    return @json_decode($response, true);
}
