<?php

/**
 * Plugin Name: HealthCheck BMI
 * Description: A WordPress to calculate the Body Mass Index (BMI).
 * Version: 1.0.0
 * Author: Bac Truong Van
 * License: GPL-2.0-or-later
 */


defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use KayB\BMICalculator\App;

function plugin_init()
{
    $plugin = new App();
    $plugin->run();
}

add_action('plugins_loaded', 'plugin_init');
