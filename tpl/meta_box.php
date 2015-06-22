<?php wp_nonce_field('rdir_post_settings', 'rdir_post_settings_nonce'); ?>

<p>
    <?php $post = get_post(); if ($shortlink = get_post_meta($post->ID, 'rdir_shortlink', true)) { ?>
        <label for="rdir_shortlink">Shortlink</label>
        <br />
        <input class="widefat" type="text" name="rdir_shortlink" id="rdir_shortlink"
            value="<?php echo esc_attr($shortlink); ?>"
            placeholder="<?php echo esc_attr($shortlink); ?>" />
    <?php } else { ?>
        <label for="rdir_post_tags">Tags</label>
        <br />
        <input class="widefat" type="text" name="rdir_post_tags" id="rdir_post_tags"
            value="<?php echo esc_attr(get_post_meta($object->ID, 'rdir_post_tags', true) ?: get_option('rdir_global_tags')); ?>"
            placeholder="<?php echo esc_attr(get_option('rdir_global_tags')); ?>" />

        <br />
        <br />

        <label for="rdir_post_slug">Slug</label>
        <br />
        <input class="widefat" type="text" name="rdir_post_slug" value="<?php echo esc_attr(get_post_meta($object->ID, 'rdir_post_slug', true)); ?>" id="rdir_post_slug" placeholder="automatic" />
    <?php } ?>
</p>
