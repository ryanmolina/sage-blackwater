<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
    wp_enqueue_script('sage/general-customizer-control.js', asset_path('scripts/general-customizer-control.js', ['jquery', 'jquery-ui-draggable'], null, true));
});

add_action('customize_controls_enqueue_scripts', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
    wp_enqueue_script('sage/general-customizer-control.js', asset_path('scripts/general-customizer-control.js', ['jquery', 'jquery-ui-draggable'], null, true));
});

/**
 * Admin JS
 */
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
	wp_enqueue_script('sage/admin.js', asset_path('scripts/admin.js'), ['jquery'], '1.0.0', true);
});
