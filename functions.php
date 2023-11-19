<?php
if (!function_exists('vacarme_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook.
     */
    function vacarme_setup()
    {
        // Add support for block styles.
        add_theme_support('wp-block-styles');
    }
endif;

function vacarme_scripts()
{
    wp_enqueue_style('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
    wp_enqueue_script('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js');
}

add_action('after_setup_theme', 'vacarme_setup');
add_action('wp_enqueue_scripts', 'vacarme_scripts');
