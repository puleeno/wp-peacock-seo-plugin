<?php
namespace Peacock;

use Peacock\Core\ModuleManager;

final class Peacock
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @var \Peacock\Core\ModuleManager
     */
    protected $moduleManager;

    protected function __construct()
    {
        $this->bootstrap();
        $this->initHooks();
        add_action('admin_menu', [$this, 'addOptionsPage']);
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function bootstrap()
    {
        $this->moduleManager = ModuleManager::getInstance();
    }

    private function initHooks()
    {
        register_activation_hook(WP_PEACOCK_SEO_PLUGIN_FILE, [Install::class, 'active']);
        register_deactivation_hook(WP_PEACOCK_SEO_PLUGIN_FILE, [Install::class, 'deactive']);

        add_action('plugins_loaded', [$this->moduleManager, 'load'], 15);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $name;
        }
    }

    public function addOptionsPage()
    {
        add_menu_page(
            'Peacock SEO Options',
            'Peacock',
            'manage_options',
            'peacock-seo-options',
            [$this, 'renderOptionsPage'],
            'dashicons-admin-generic',
            100
        );
    }

    public function renderOptionsPage()
    {
        ?>
        <div class="wrap">
            <div id="peacock-seo-app"></div>
        </div>
        <script src="<?php echo plugins_url('assets/dist/bundle.js', __FILE__); ?>"></script>
        <?php
    }
}
