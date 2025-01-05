<?php
namespace Peacock\Modules\Backend;

use Peacock\Core\Abstracts\ModuleAbstract;

class PageSettingsModule extends ModuleAbstract
{
    public function getName()
    {
        return 'page_settings';
    }

    public function execute()
    {
        add_action('add_meta_boxes', [$this, 'addPageSettingsMetaBox']);
        add_action('save_post', [$this, 'savePageSettings']);
    }

    public function addPageSettingsMetaBox()
    {
        add_meta_box(
            'page_settings_meta_box',
            'Page Settings',
            [$this, 'renderPageSettingsMetaBox'],
            'page',
            'normal',
            'high'
        );
    }

    public function renderPageSettingsMetaBox($post)
    {
        $metaValue = get_post_meta($post->ID, '_page_setting', true);
        ?>
        <label for="page_setting">Custom Setting:</label>
        <input type="text" name="page_setting" value="<?php echo esc_attr($metaValue); ?>" />
        <?php
    }

    public function savePageSettings($postId)
    {
        if (array_key_exists('page_setting', $_POST)) {
            update_post_meta($postId, '_page_setting', sanitize_text_field($_POST['page_setting']));
        }
    }
}