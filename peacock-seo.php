<?php
/**
 * Plugin Name: Peacock SEO
 * Description: Highlight your site in search results of Search Engines
 * Author: Puleeno Nguyen
 * Author URI: https://puleeno.com
 * Tag: SEO
 */

use Peacock\Peacock;

define('WP_PEACOCK_SEO_PLUGIN_FILE', __FILE__);

class Peacock_SEO
{
    protected $isReady = false;

    public function bootstrap()
    {
        $composerAutoloader = sprintf('%s/vendor/autoload.php', dirname(__FILE__));
        if (file_exists($composerAutoloader)) {
            require_once $composerAutoloader;
            $this->isReady = true;
        }
    }

    public function load()
    {
        if (empty($this->isReady)) {
            return;
        }

        // Load features
        Peacock::getInstance();

        $moduleManager = \Peacock\Core\ModuleManager::getInstance();

        // Add options page
        add_action('admin_menu', [$this, 'addOptionsPage']);

        // Register settings
        add_action('admin_init', [$this, 'registerSettings']);

        // Handle AJAX request
        add_action('wp_ajax_save_peacock_options', [$this, 'savePeacockOptions']);
        add_action('wp_ajax_nopriv_save_peacock_options', [$this, 'savePeacockOptions']);

        // Thêm action để xử lý yêu cầu AJAX
        add_action('wp_ajax_load_peacock_options', [$this, 'loadPeacockOptions']);
        add_action('wp_ajax_get_seo_score', [$this, 'getSeoScore']);
    }

    public function addOptionsPage()
    {
        add_menu_page(
            'Peacock SEO Options', // Page title
            'Peacock',            // Menu title
            'manage_options',     // Capability
            'peacock-seo-options', // Menu slug
            [$this, 'renderOptionsPage'], // Callback function
            'dashicons-admin-generic', // Icon
            100 // Position
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

    public function registerSettings()
    {
        register_setting('peacock_seo_options_group', 'option_1');
        register_setting('peacock_seo_options_group', 'option_2');
    }

    public function savePeacockOptions()
    {
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized', 403);
            return;
        }

        // Get the options from the request
        $options = isset($_POST['options']) ? $_POST['options'] : [];

        // Save options
        update_option('option_1', sanitize_text_field($options['option_1']));
        update_option('option_2', sanitize_text_field($options['option_2']));

        // Send success response
        wp_send_json_success();
    }

    public function loadPeacockOptions()
    {
        // Kiểm tra quyền người dùng
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized', 403);
            return;
        }

        // Lấy các tùy chọn từ cơ sở dữ liệu
        $options = [
            'option_1' => get_option('option_1', ''),
            'option_2' => get_option('option_2', ''),
        ];

        // Gửi phản hồi thành công
        wp_send_json_success($options);
    }

    public function getSeoScore()
    {
        // Kiểm tra quyền người dùng
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized', 403);
            return;
        }

        // Tính toán điểm SEO (ví dụ: 85)
        $score = 85; // Đây chỉ là một ví dụ, bạn có thể thay đổi logic tính toán

        // Gửi phản hồi thành công
        wp_send_json_success(['score' => $score]);
    }
}

$peacock = new Peacock_SEO();
$peacock->bootstrap();
$peacock->load();