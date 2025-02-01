<?php

use Clyper\App;

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

register_uninstall_hook(__FILE__, [App::class, 'uninstall']);
