<?php /* defined('ABSPATH') or die('Plugin file cannot be accessed directly.'); */ ?>

<div class="wrap">
    <h2>
        <img src="http://rdir.io/favicon.ico" style="width:25px;height:25px;position:relative;bottom:-5px" />
        Redirect Toolkit
    </h2>

    <form method="post" action="options.php">
        <?php settings_fields('rdir-settings-group'); ?>
        <?php do_settings_sections('rdir-settings-group'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">API key</th>
                <td>
                    <input name="rdir_api_key" value="<?= esc_attr(get_option('rdir_api_key')); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Global Tags</th>
                <td>
                    <input name="rdir_global_tags" value="<?= esc_attr(get_option('rdir_global_tags')); ?>" />
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>

    </form>
</div>
