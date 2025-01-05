<?php
namespace Peacock\Modules\Backend;

use Peacock\Core\Abstracts\ModuleAbstract;

class AuthorSettingsModule extends ModuleAbstract
{
    public function getName()
    {
        return 'author_settings';
    }

    public function execute()
    {
        add_action('show_user_profile', [$this, 'addAuthorSettingsFields']);
        add_action('edit_user_profile', [$this, 'addAuthorSettingsFields']);
        add_action('personal_options_update', [$this, 'saveAuthorSettings']);
        add_action('edit_user_profile_update', [$this, 'saveAuthorSettings']);
    }

    public function addAuthorSettingsFields($user)
    {
        $metaValue = get_user_meta($user->ID, '_author_setting', true);
        ?>
        <h3>Author Settings</h3>
        <table class="form-table">
            <tr>
                <th><label for="author_setting">Custom Setting</label></th>
                <td><input type="text" name="author_setting" id="author_setting" value="<?php echo esc_attr($metaValue); ?>" /></td>
            </tr>
        </table>
        <?php
    }

    public function saveAuthorSettings($userId)
    {
        if (array_key_exists('author_setting', $_POST)) {
            update_user_meta($userId, '_author_setting', sanitize_text_field($_POST['author_setting']));
        }
    }
}