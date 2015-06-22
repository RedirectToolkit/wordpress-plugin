<?php
    $punycode = new \True\Punycode();
?>

<div class="wrap">
    <h2>
        <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/favicon.ico" class="favicon" />
        Redirect Toolkit
    </h2>

    <form method="post" action="options.php">
        <?php settings_fields('rdir-settings-group'); ?>
        <?php do_settings_sections('rdir-settings-group'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">API key</th>
                <td>
                    <input class="regular-text" name="rdir_api_key" value="<?php echo esc_attr(get_option('rdir_api_key')); ?>" <?php if (!get_option('rdir_api_key')) echo 'autofocus required'; ?> />
                    <p class="description"><b>Required</b>. API key used by this blog, visit <a href="http://rdir.io/profile/" target="_blank">your profile page</a> to obtain it.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Global Tags</th>
                <td>
                    <input class="regular-text" name="rdir_global_tags" value="<?php echo esc_attr(get_option('rdir_global_tags')); ?>" placeholder="Website, Social Networks, etc..." />
                    <p class="description">Tags globally applied to short links, separated by a comma,
                        use tags for an easier extraction for generated short links on rdir.io dashboard.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Predefined Host</th>
                <td>
                    <select name="rdir_global_host">
                        <?php foreach (rdir_request('/utils/hosts') ?: array() as $host) { ?>
                            <option value="<?php echo $host; ?>"<?php if (get_option('rdir_global_host') == $host) echo ' selected'; ?>><?php echo $punycode->decode($host); ?></option>
                        <?php } ?>
                    </select>
                    <p class="description">Host used to generate short links. <a href="http://rdir.io/custom-domains">Need a custom domain?</a></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Use post slug</th>
                <td>
                    <select name="rdir_use_slugs">
                        <option value="0"<?php if (!get_option('rdir_use_slugs')) echo ' selected'; ?>>Disabled</option>
                        <option value="1"<?php if (get_option('rdir_use_slugs')) echo ' selected'; ?>>Enabled</option>
                    </select>
                    <p class="description">
                        By checking this option, the system will try to use the post slug to generate short links slugs, if it's not possible, a number will be appended to the slug.
                        <br />
                        The post slug can be overridden on every post.
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Predefined callback URL</th>
                <td>
                    <input class="regular-text" name="rdir_predefined_callback" value="<?php echo esc_attr(get_option('rdir_predefined_callback')); ?>" placeholder="http://www.example.com/path/to/your/callback" />
                    <p class="description">This URL will be called by rdir.io on every short link visit.</p>
                </td>
            </tr>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>

    </form>
</div>

<style>
img.favicon
{
    width:25px;
    height:25px;
    position:relative;
    bottom:-5px
}
</style>
