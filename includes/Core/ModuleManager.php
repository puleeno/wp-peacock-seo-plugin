<?php
namespace Peacock\Core;

use Peacock\Core\Abstracts\ModuleAbstract;

class ModuleManager
{
    protected static $instance;
    protected $modules = [];

    protected function __construct()
    {
        // Đăng ký các module mặc định
        $this->registerDefaultModules();
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function register($moduleClass)
    {
        if (class_exists($moduleClass)) {
            $module = new $moduleClass();
            $this->modules[$module->getName()] = $module;
            $module->execute(); // Khởi chạy module
        }
    }

    private function registerDefaultModules()
    {
        // Đăng ký các module mặc định
        $this->register(\Peacock\Modules\Backend\GlobalSettingsModule::class);
        $this->register(\Peacock\Modules\Backend\PostSettingsModule::class);
        $this->register(\Peacock\Modules\Backend\PageSettingsModule::class);
        $this->register(\Peacock\Modules\Backend\CategorySettingsModule::class);
        $this->register(\Peacock\Modules\Backend\TaxonomySettingsModule::class);
        $this->register(\Peacock\Modules\Backend\AuthorSettingsModule::class);
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function load() {
        // load modules
    }
}
