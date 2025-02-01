<?php

namespace Clyper\WordpressVuePlugin\Controllers;

class AdminController
{
    public function register_menu()
    {
        add_menu_page(
            'WordpressVue Plugin',
            'WordpressVue',
            'manage_options',
            'wordpressvue-plugin',
            [$this, 'render_page'],
            'dashicons-heart'
        );
    }

    public function render_page()
    {
        echo '<div id="wordpress-plugin-admin-app"></div>';
    }

    public static function init_options()
    {
        return [];
    }

    public function enqueue_scripts()
    {
        $scriptName = 'wordpress-plugin-admin';

        if (defined('WP_DEBUG') && WP_DEBUG) {
            wp_enqueue_script(
                'vite-client',
                'http://localhost:3000/@vite/client',
                [],
                null,
                true
            );
            wp_enqueue_script(
                $scriptName,
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
                $scriptName,
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
                    "$scriptName-style",
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
        if (in_array($handle, ['vite-client', 'wordpress-plugin-admin'])) {
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }

        return $tag;
    }

    public function register_route()
    {
        /*register_rest_route('healthcheck-bmi/admin/v1', '/config', [*/
        /*  'methods' => 'GET',*/
        /*  'callback' => [$this, 'get_config'],*/
        /*]);*/
        /**/
    }
}
