<?php
namespace Peacock\Modules\Backend;

use Peacock\Core\Abstracts\ModuleAbstract;

class PostSettingsModule extends ModuleAbstract
{
    public function getName()
    {
        return 'post_settings';
    }

    public function execute()
    {
        add_action('add_meta_boxes', [$this, 'addPostSettingsMetaBox']);
        add_action('save_post', [$this, 'savePostSettings']);
    }

    public function addPostSettingsMetaBox()
    {
        add_meta_box(
            'post_settings_meta_box',
            'Post Settings',
            [$this, 'renderPostSettingsMetaBox'],
            'post',
            'normal',
            'high'
        );
    }

    public function renderPostSettingsMetaBox($post)
    {
        $metaValue = get_post_meta($post->ID, '_post_setting', true);
        ?>
        <label for="post_setting">Custom Setting:</label>
        <input type="text" name="post_setting" value="<?php echo esc_attr($metaValue); ?>" />
        <?php
    }

    public function savePostSettings($postId)
    {
        if (array_key_exists('post_setting', $_POST)) {
            update_post_meta($postId, '_post_setting', sanitize_text_field($_POST['post_setting']));
        }
    }
}