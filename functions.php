<?php

/**
 * Perfect Stays WordPress Theme
 * 
 * Lightweight bootstrap file for the Perfect Stays vacation rental theme.
 * All custom functionality is organized in separate modules loaded from app/setup.php
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load Theme Setup and Custom Components
 * 
 * Include the main setup file that handles all custom post types,
 * fields, customizer settings, and other theme functionality.
 */
require_once get_theme_file_path('app/setup.php');

/**
 * Theme Setup and Support
 */
function perfect_stays_setup() {
    // Add theme support for various WordPress features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    
    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Navigation', 'floorspace'),
        'footer' => __('Footer Navigation', 'floorspace'),
    ]);
}
add_action('after_setup_theme', 'perfect_stays_setup');

/**
 * Enqueue Styles and Scripts
 */
function perfect_stays_scripts() {
    // Main theme stylesheet
    wp_enqueue_style(
        'perfect-stays-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );
    
    // Tailwind CSS (if not using Vite build)
    if (!file_exists(get_template_directory() . '/public/app.css')) {
        wp_enqueue_style(
            'tailwindcss',
            'https://cdn.tailwindcss.com',
            [],
            '3.3.5'
        );
    }
    
    // Main theme JavaScript (only if file exists)
    $js_file = get_template_directory() . '/public/app.js';
    if (file_exists($js_file)) {
        wp_enqueue_script(
            'perfect-stays-script',
            get_template_directory_uri() . '/public/app.js',
            ['wp-dom-ready'],
            wp_get_theme()->get('Version'),
            true
        );
    } else {
        // Fallback to resources/js/app.js
        $js_fallback = get_template_directory() . '/resources/js/app.js';
        if (file_exists($js_fallback)) {
            wp_enqueue_script(
                'perfect-stays-script',
                get_template_directory_uri() . '/resources/js/app.js',
                ['wp-dom-ready'],
                wp_get_theme()->get('Version'),
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'perfect_stays_scripts');







/**
 * Widget Areas
 */
function perfect_stays_widgets_init() {
    register_sidebar([
        'name' => __('Sidebar', 'floorspace'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'floorspace'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ]);
}
add_action('widgets_init', 'perfect_stays_widgets_init');

// Debug removed - theme should now work cleanly 