<?php
namespace Peacock\Core\Abstracts;

use Peacock\Core\Interfaces\ModuleInterface;

abstract class ModuleAbstract implements ModuleInterface
{
    public function initDefault()
    {
        // default object properties can be init at this method
    }

    public function getLoadHook()
    {
        return null;
    }

    public function getBootstrapHook()
    {
        return 'after_setup_theme';
    }

    public function getPriority()
    {
        return 10;
    }

    public function bootstrap()
    {
        // bootstrap module after theme loaded
    }
}