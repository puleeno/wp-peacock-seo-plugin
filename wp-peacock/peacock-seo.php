<?php
/**
 * Plugin Name: WP Peacock
 * Description: A WordPress SEO plugin.
 * Author: Your Name
 * Version: 1.0.0
 */

defined('ABSPATH') or die('No script kiddies please!');

require_once __DIR__ . '/includes/Core/ModuleManager.php';
require_once __DIR__ . '/includes/Modules/Backend/GlobalSettingsModule.php';
require_once __DIR__ . '/includes/Modules/Backend/PostSettingsModule.php';
require_once __DIR__ . '/includes/Modules/Backend/PageSettingsModule.php';
require_once __DIR__ . '/includes/Modules/Backend/CategorySettingsModule.php';
require_once __DIR__ . '/includes/Modules/Backend/TaxonomySettingsModule.php';
require_once __DIR__ . '/includes/Modules/Backend/AuthorSettingsModule.php';

$moduleManager = \Peacock\Core\ModuleManager::getInstance();