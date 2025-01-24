<?php

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use KayB\BMICalculator\App;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

register_uninstall_hook(__FILE__, [App::class, 'uninstall']);
