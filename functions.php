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
add_action('after_setup_theme', 'vacarme_setup');
    
function vacarme_scripts()
{
    wp_enqueue_style('vacarme', get_stylesheet_uri());
    wp_enqueue_style('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
    wp_enqueue_script('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js');
    wp_enqueue_script('vacarme', get_template_directory_uri() . '/map.js');

    $map_hyperlinks = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'map-hyperlink',
    ));
    $json_map_hyperlinks = array_map(function ($post) {
        $geojson = json_decode($post->post_content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        $geojson['properties']['url'] = get_post_permalink($geojson['properties']['linkedPostId']);
        return json_encode($geojson);
    }, $map_hyperlinks);

    wp_add_inline_script(
        'vacarme',
        'const geojsonHyperlinks = [' . join(',', $json_map_hyperlinks) . '];',
        'before'
    );
}
add_action('wp_enqueue_scripts', 'vacarme_scripts');
