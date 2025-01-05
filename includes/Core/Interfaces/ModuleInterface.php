<?php
namespace Peacock\Core\Interfaces;

interface ModuleInterface
{
    public function getName();
    public function initDefault();
    public function getLoadHook();
    public function getBootstrapHook();
    public function getPriority();
    public function bootstrap();
    public function execute();
}