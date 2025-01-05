<?php
namespace Peacock\Modules\Backend;

use Peacock\Core\Abstracts\ModuleAbstract;

class GlobalSettingsModule extends ModuleAbstract
{
    public function getName()
    {
        return 'global_settings';
    }

    public function execute()
    {
        add_action('admin_menu', [$this, 'addSettingsPage']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    public function addSettingsPage()
    {
        add_options_page(
            'Global Settings',
            'Global Settings',
            'manage_options',
            'global-settings',
            [$this, 'renderSettingsPage']
        );
    }

    public function registerSettings()
    {
        register_setting('global_settings_group', 'setting_1');
        register_setting('global_settings_group', 'setting_2');
    }

    public function renderSettingsPage()
    {
        ?>
        <div class="wrap">
            <h1>Global Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('global_settings_group');
                do_settings_sections('global_settings_group');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Setting 1</th>
                        <td><input type="text" name="setting_1" value="<?php echo esc_attr(get_option('setting_1')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Setting 2</th>
                        <td><input type="text" name="setting_2" value="<?php echo esc_attr(get_option('setting_2')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}