<?php
namespace Peacock\Modules\Backend;

use Peacock\Core\Abstracts\ModuleAbstract;

class CategorySettingsModule extends ModuleAbstract
{
    public function getName()
    {
        return 'category_settings';
    }

    public function execute()
    {
        add_action('category_add_form_fields', [$this, 'addCategorySettingsFields']);
        add_action('category_edit_form_fields', [$this, 'editCategorySettingsFields']);
        add_action('created_category', [$this, 'saveCategorySettings']);
        add_action('edited_category', [$this, 'saveCategorySettings']);
    }

    public function addCategorySettingsFields()
    {
        ?>
        <div class="form-field">
            <label for="category_setting">Custom Setting:</label>
            <input type="text" name="category_setting" id="category_setting" value="" />
        </div>
        <?php
    }

    public function editCategorySettingsFields($term)
    {
        $metaValue = get_term_meta($term->term_id, '_category_setting', true);
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="category_setting">Custom Setting:</label></th>
            <td><input type="text" name="category_setting" id="category_setting" value="<?php echo esc_attr($metaValue); ?>" /></td>
        </tr>
        <?php
    }

    public function saveCategorySettings($termId)
    {
        if (array_key_exists('category_setting', $_POST)) {
            update_term_meta($termId, '_category_setting', sanitize_text_field($_POST['category_setting']));
        }
    }
}