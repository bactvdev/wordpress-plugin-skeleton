<?php

namespace KayB\BMICalculator\Controllers;

class PublicController
{
    public function init()
    {
        add_shortcode('healthcheck_bmi', [$this, 'render']);
    }

    public function render()
    {
        $lang = 'en';
        return '<div><div id="healthcheck-bmi-public-app"></div> <input id="bmi-curr-lang" type="hidden" value="' . $lang . '" /> </div>';
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
                'bmi-calculator-public',
                'http://localhost:3000/assets/src/public/main.js',
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
        $entry = $manifest['assets/src/public/main.js'];

        // Enqueue the JS file
        if (!empty($entry['file'])) {
            wp_enqueue_script(
                'bmi-calculator-public',
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
                    'bmi-calculator-public-style',
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
        if (in_array($handle, ['vite-client', 'bmi-calculator-public'])) {
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }

    public function get_config()
    {
        $config = [
          "lang" => "en"
        ];
        return rest_ensure_response($config);
    }

    public function register_route()
    {
        register_rest_route('healthcheck-bmi/v1', '/config', [
          'methods' => 'GET',
          'callback' => [$this, 'get_config'],
        ]);
    }
}
