<?php
namespace Peacock\Modules\Backend;

use Peacock\Core\Abstracts\ModuleAbstract;

class TaxonomySettingsModule extends ModuleAbstract
{
    public function getName()
    {
        return 'taxonomy_settings';
    }

    public function execute()
    {
        add_action('taxonomy_add_form_fields', [$this, 'addTaxonomySettingsFields']);
        add_action('taxonomy_edit_form_fields', [$this, 'editTaxonomySettingsFields']);
        add_action('created_taxonomy', [$this, 'saveTaxonomySettings']);
        add_action('edited_taxonomy', [$this, 'saveTaxonomySettings']);
    }

    public function addTaxonomySettingsFields()
    {
        ?>
        <div class="form-field">
            <label for="taxonomy_setting">Custom Setting:</label>
            <input type="text" name="taxonomy_setting" id="taxonomy_setting" value="" />
        </div>
        <?php
    }

    public function editTaxonomySettingsFields($term)
    {
        $metaValue = get_term_meta($term->term_id, '_taxonomy_setting', true);
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="taxonomy_setting">Custom Setting:</label></th>
            <td><input type="text" name="taxonomy_setting" id="taxonomy_setting" value="<?php echo esc_attr($metaValue); ?>" /></td>
        </tr>
        <?php
    }

    public function saveTaxonomySettings($termId)
    {
        if (array_key_exists('taxonomy_setting', $_POST)) {
            update_term_meta($termId, '_taxonomy_setting', sanitize_text_field($_POST['taxonomy_setting']));
        }
    }
}