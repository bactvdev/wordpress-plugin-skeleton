<?php

namespace KayB\BMICalculator;

use KayB\BMICalculator\Controllers\AdminController;
use KayB\BMICalculator\Controllers\PublicController;

class App
{
    private $adminController;
    private $publicController;

    public function __construct()
    {
        $this->adminController = new AdminController();
        $this->publicController = new PublicController();

        $this->_define_admin_hooks();
        $this->_define_public_hooks();
    }

    public static function activate()
    {
        add_option('kayb_bmi_config', AdminController::init_options());
    }

    public static function deactivate()
    {
        delete_option('kayb_bmi_config');
    }

    public static function uninstall()
    {
    }

    public function run()
    {
    }

    private function _define_admin_hooks()
    {
        add_action('admin_menu', [$this->adminController, 'register_menu']);
        add_action('admin_enqueue_scripts', [$this->adminController, 'enqueue_scripts']);
        add_action('rest_api_init', [$this->adminController, 'register_route']);
    }

    private function _define_public_hooks()
    {
        add_shortcode('healthcheck_bmi', [$this->publicController, 'render']);
        add_action('wp_enqueue_scripts', [$this->publicController, 'enqueue_scripts']);
        add_action('rest_api_init', [$this->publicController, 'register_route']);
    }
}
