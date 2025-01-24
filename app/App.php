<?php

namespace KayB\BMICalculator;

use KayB\BMICalculator\Controllers\AdminController;
use KayB\BMICalculator\Controllers\PublicController;

class App
{
    public function __construct()
    {
        $this->_define_admin_hooks();
        $this->_define_public_hooks();
    }

    public function run()
    {
    }

    private function _define_admin_hooks()
    {
        $adminController = new AdminController();
        add_action('admin_menu', [$adminController, 'register_menu']);
        add_action('admin_enqueue_scripts', [$adminController, 'enqueue_scripts']);
    }

    private function _define_public_hooks()
    {
        $publicController = new PublicController();
        add_shortcode('healthcheck_bmi', [$publicController, 'render']);
        add_action('wp_enqueue_scripts', [$publicController, 'enqueue_scripts']);
    }
}
