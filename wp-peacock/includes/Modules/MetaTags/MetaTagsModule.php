<?php
namespace Peacock\Modules\MetaTags;

use Peacock\Core\Abstracts\ModuleAbstract;

class MetaTagsModule extends ModuleAbstract
{
    public function getName()
    {
        return 'meta_tags';
    }

    public function execute()
    {
        add_action('wp_head', [$this, 'addMetaTags']);
    }

    public function addMetaTags()
    {
        $metaDescription = get_option('meta_description', '');
        if ($metaDescription) {
            echo '<meta name="description" content="' . esc_attr($metaDescription) . '">' . "\n";
        }
    }
}