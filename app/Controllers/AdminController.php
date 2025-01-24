<?php

namespace KayB\BMICalculator\Controllers;

class AdminController
{
    public function register_menu()
    {
        add_menu_page(
            'BMI Calculator',
            'BMI Calculator',
            'manage_options',
            'healthcheck-bmi',
            [$this, 'render_admin_page'],
            'dashicons-heart'
        );
    }

    public function render_admin_page()
    {
        include plugin_dir_path(__FILE__) . '../Views/admin-page.php';
    }

    public static function init_options()
    {
        return [
          "lang" => "ja",
          "show_popup_result" => false
        ];
    }

    public function enqueue_scripts()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            wp_enqueue_script(
                'vite-client',
                'http://localhost:3000/@vite/client',
                [],
                null,
                true
            );
            wp_enqueue_script(
                'healthcheck-bmi-admin',
                'http://localhost:3000/assets/src/admin/main.js',
                [],
                null,
                true
            );

            add_filter('script_loader_tag', [$this, 'add_module_type'], 10, 3);

            return;
        }

        $manifest_path = plugin_dir_path(__FILE__) . '../../dist/.vite/manifest.json';
        if (!file_exists($manifest_path)) {
            return;
        }
        $manifest = json_decode(file_get_contents($manifest_path), true);
        $entry = $manifest['assets/src/admin/main.js'];

        // Enqueue the JS file
        if (!empty($entry['file'])) {
            wp_enqueue_script(
                'healthcheck-bmi-admin',
                plugin_dir_url(__FILE__) . '../../dist/' . $entry['file'],
                [],
                null,
                true
            );
        }

        // Enqueue the CSS file
        if (!empty($entry['css'])) {
            foreach ($entry['css'] as $css_file) {
                wp_enqueue_style(
                    'healthcheck-bmi-admin-style',
                    plugin_dir_url(__FILE__) . '../../dist/' . $css_file,
                    [],
                    null
                );
            }
        }

        add_filter('script_loader_tag', [$this, 'add_module_type'], 10, 3);
    }

    public function add_module_type($tag, $handle, $src)
    {
        if (in_array($handle, ['vite-client', 'healthcheck-bmi-admin'])) {
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }
}
