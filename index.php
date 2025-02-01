<?php

/**
 * Plugin Name: WordpressVue Plugin
 * Description: A WordPress Plugin use Vue 3 + Vite.
 * Version: 1.0.0
 * Author: Bac Truong Van
 */

use Clyper\WordpressVuePlugin\App;

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

function plugin_init()
{
    $plugin = new App();
    $plugin->run();
}

add_action('plugins_loaded', 'plugin_init');

register_activation_hook(__FILE__, [App::class, 'activate']);
register_deactivation_hook(__FILE__, [App::class, 'deactivate']);
