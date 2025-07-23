<?php

/**
 * Perfect Stays Theme Setup
 * 
 * This file handles the initialization and setup of all custom theme components.
 * It serves as a central bootstrap for loading custom post types, fields, and
 * other theme-specific functionality.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Include Custom Field Definitions
 * 
 * Load all ACF field group definitions for the theme.
 * These define the custom fields used by various post types.
 */
require_once get_theme_file_path('app/Custom/Fields/property-fields.php');

/**
 * Include Custom Gutenberg Blocks
 * 
 * Load all custom block definitions for the theme.
 */
require_once get_theme_file_path('app/Blocks/about-hero.php');

/**
 * Custom Post Types and Taxonomies Registration
 * 
 * Register all custom post types and taxonomies used by the theme.
 * This code automatically registers with CPT UI plugin for management.
 */
function perfect_stays_register_post_types() {
    // Property Custom Post Type
    register_post_type('property', [
        'labels' => [
            'name' => __('Properties', 'floorspace'),
            'singular_name' => __('Property', 'floorspace'),
            'add_new_item' => __('Add New Property', 'floorspace'),
            'edit_item' => __('Edit Property', 'floorspace'),
            'new_item' => __('New Property', 'floorspace'),
            'view_item' => __('View Property', 'floorspace'),
            'search_items' => __('Search Properties', 'floorspace'),
            'not_found' => __('No properties found', 'floorspace'),
            'not_found_in_trash' => __('No properties found in trash', 'floorspace'),
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon' => 'dashicons-building',
        'rewrite' => ['slug' => 'properties'],
    ]);
    
    // Amenity Taxonomy
    register_taxonomy('amenity', 'property', [
        'labels' => [
            'name' => __('Amenities', 'floorspace'),
            'singular_name' => __('Amenity', 'floorspace'),
            'add_new_item' => __('Add New Amenity', 'floorspace'),
            'edit_item' => __('Edit Amenity', 'floorspace'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical' => false,
        'rewrite' => ['slug' => 'amenities'],
    ]);
    
    // City Taxonomy for location tags
    register_taxonomy('city', 'property', [
        'labels' => [
            'name' => __('Cities', 'floorspace'),
            'singular_name' => __('City', 'floorspace'),
            'add_new_item' => __('Add New City', 'floorspace'),
            'edit_item' => __('Edit City', 'floorspace'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical' => false,
        'rewrite' => ['slug' => 'cities'],
    ]);
    
    // State/Territory Taxonomy for location tags
    register_taxonomy('state_territory', 'property', [
        'labels' => [
            'name' => __('States/Territories', 'floorspace'),
            'singular_name' => __('State/Territory', 'floorspace'),
            'add_new_item' => __('Add New State/Territory', 'floorspace'),
            'edit_item' => __('Edit State/Territory', 'floorspace'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical' => false,
        'rewrite' => ['slug' => 'states'],
    ]);
    
    // Country Taxonomy for location tags
    register_taxonomy('country', 'property', [
        'labels' => [
            'name' => __('Countries', 'floorspace'),
            'singular_name' => __('Country', 'floorspace'),
            'add_new_item' => __('Add New Country', 'floorspace'),
            'edit_item' => __('Edit Country', 'floorspace'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical' => false,
        'rewrite' => ['slug' => 'countries'],
    ]);
}
add_action('init', 'perfect_stays_register_post_types');

/**
 * Register Post Types with CPT UI for Management
 * 
 * This makes our code-based post types appear in CPT UI interface
 */
function perfect_stays_register_with_cpt_ui() {
    // Only run if CPT UI is active
    if (!function_exists('cptui_get_post_type_data')) {
        return;
    }
    
    // Get existing CPT UI post types
    $existing_post_types = get_option('cptui_post_types', []);
    
    // Define our Property post type for CPT UI
    $existing_post_types['property'] = [
        'name' => 'property',
        'label' => 'Properties',
        'singular_label' => 'Property',
        'description' => 'Vacation rental properties for Perfect Stays',
        'public' => '1',
        'publicly_queryable' => '1',
        'show_ui' => '1',
        'show_in_nav_menus' => '1',
        'delete_with_user' => '0',
        'show_in_rest' => '1',
        'rest_base' => '',
        'rest_controller_class' => '',
        'has_archive' => '1',
        'has_archive_string' => '',
        'exclude_from_search' => '0',
        'capability_type' => 'post',
        'hierarchical' => '0',
        'rewrite' => '1',
        'rewrite_slug' => 'properties',
        'rewrite_withfront' => '1',
        'query_var' => '1',
        'query_var_slug' => '',
        'menu_position' => '',
        'show_in_menu' => '1',
        'show_in_menu_string' => '',
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies' => ['amenity', 'city', 'state_territory', 'country'],
        'labels' => [
            'menu_name' => 'Properties',
            'all_items' => 'All Properties',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Property',
            'edit_item' => 'Edit Property',
            'new_item' => 'New Property',
            'view_item' => 'View Property',
            'view_items' => 'View Properties',
            'search_items' => 'Search Properties',
            'not_found' => 'No properties found',
            'not_found_in_trash' => 'No properties found in trash',
            'parent' => 'Parent Property:',
            'featured_image' => 'Featured image',
            'set_featured_image' => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image' => 'Use as featured image',
            'archives' => 'Property archives',
            'insert_into_item' => 'Insert into property',
            'uploaded_to_this_item' => 'Uploaded to this property',
            'filter_items_list' => 'Filter properties list',
            'items_list_navigation' => 'Properties list navigation',
            'items_list' => 'Properties list',
            'attributes' => 'Property attributes',
            'name_admin_bar' => 'Property',
            'item_published' => 'Property published',
            'item_published_privately' => 'Property published privately',
            'item_reverted_to_draft' => 'Property reverted to draft',
            'item_scheduled' => 'Property scheduled',
            'item_updated' => 'Property updated',
            'parent_item_colon' => 'Parent Property:',
        ]
    ];
    
    // Update CPT UI option
    update_option('cptui_post_types', $existing_post_types);
    
    // Get existing CPT UI taxonomies
    $existing_taxonomies = get_option('cptui_taxonomies', []);
    
    // Define our Amenity taxonomy for CPT UI
    $existing_taxonomies['amenity'] = [
        'name' => 'amenity',
        'label' => 'Amenities',
        'singular_label' => 'Amenity',
        'description' => 'Property amenities and features',
        'public' => '1',
        'publicly_queryable' => '1',
        'hierarchical' => '0',
        'show_ui' => '1',
        'show_in_menu' => '1',
        'show_in_nav_menus' => '1',
        'query_var' => '1',
        'rewrite' => '1',
        'rewrite_slug' => 'amenities',
        'rewrite_withfront' => '1',
        'rewrite_hierarchical' => '0',
        'show_admin_column' => '1',
        'show_in_rest' => '1',
        'show_tagcloud' => '1',
        'sort' => '0',
        'object_types' => ['property'],
        'labels' => [
            'menu_name' => 'Amenities',
            'all_items' => 'All Amenities',
            'edit_item' => 'Edit Amenity',
            'view_item' => 'View Amenity',
            'update_item' => 'Update Amenity',
            'add_new_item' => 'Add New Amenity',
            'new_item_name' => 'New Amenity Name',
            'parent_item' => 'Parent Amenity',
            'parent_item_colon' => 'Parent Amenity:',
            'search_items' => 'Search Amenities',
            'popular_items' => 'Popular Amenities',
            'separate_items_with_commas' => 'Separate amenities with commas',
            'add_or_remove_items' => 'Add or remove amenities',
            'choose_from_most_used' => 'Choose from the most used amenities',
            'not_found' => 'No amenities found',
            'no_terms' => 'No amenities',
            'items_list_navigation' => 'Amenities list navigation',
            'items_list' => 'Amenities list',
            'most_used' => 'Most Used',
            'back_to_items' => '← Back to Amenities',
        ]
    ];
    
    // Define City taxonomy for CPT UI
    $existing_taxonomies['city'] = [
        'name' => 'city',
        'label' => 'Cities',
        'singular_label' => 'City',
        'description' => 'Property cities for location tagging',
        'public' => '1',
        'publicly_queryable' => '1',
        'hierarchical' => '0',
        'show_ui' => '1',
        'show_in_menu' => '1',
        'show_in_nav_menus' => '1',
        'query_var' => '1',
        'rewrite' => '1',
        'rewrite_slug' => 'cities',
        'rewrite_withfront' => '1',
        'rewrite_hierarchical' => '0',
        'show_admin_column' => '1',
        'show_in_rest' => '1',
        'show_tagcloud' => '1',
        'sort' => '0',
        'object_types' => ['property'],
        'labels' => [
            'menu_name' => 'Cities',
            'all_items' => 'All Cities',
            'edit_item' => 'Edit City',
            'view_item' => 'View City',
            'update_item' => 'Update City',
            'add_new_item' => 'Add New City',
            'new_item_name' => 'New City Name',
            'parent_item' => 'Parent City',
            'parent_item_colon' => 'Parent City:',
            'search_items' => 'Search Cities',
            'popular_items' => 'Popular Cities',
            'separate_items_with_commas' => 'Separate cities with commas',
            'add_or_remove_items' => 'Add or remove cities',
            'choose_from_most_used' => 'Choose from the most used cities',
            'not_found' => 'No cities found',
            'no_terms' => 'No cities',
            'items_list_navigation' => 'Cities list navigation',
            'items_list' => 'Cities list',
            'most_used' => 'Most Used',
            'back_to_items' => '← Back to Cities',
        ]
    ];
    
    // Define State/Territory taxonomy for CPT UI
    $existing_taxonomies['state_territory'] = [
        'name' => 'state_territory',
        'label' => 'States/Territories',
        'singular_label' => 'State/Territory',
        'description' => 'Property states and territories for location tagging',
        'public' => '1',
        'publicly_queryable' => '1',
        'hierarchical' => '0',
        'show_ui' => '1',
        'show_in_menu' => '1',
        'show_in_nav_menus' => '1',
        'query_var' => '1',
        'rewrite' => '1',
        'rewrite_slug' => 'states',
        'rewrite_withfront' => '1',
        'rewrite_hierarchical' => '0',
        'show_admin_column' => '1',
        'show_in_rest' => '1',
        'show_tagcloud' => '1',
        'sort' => '0',
        'object_types' => ['property'],
        'labels' => [
            'menu_name' => 'States/Territories',
            'all_items' => 'All States/Territories',
            'edit_item' => 'Edit State/Territory',
            'view_item' => 'View State/Territory',
            'update_item' => 'Update State/Territory',
            'add_new_item' => 'Add New State/Territory',
            'new_item_name' => 'New State/Territory Name',
            'parent_item' => 'Parent State/Territory',
            'parent_item_colon' => 'Parent State/Territory:',
            'search_items' => 'Search States/Territories',
            'popular_items' => 'Popular States/Territories',
            'separate_items_with_commas' => 'Separate states/territories with commas',
            'add_or_remove_items' => 'Add or remove states/territories',
            'choose_from_most_used' => 'Choose from the most used states/territories',
            'not_found' => 'No states/territories found',
            'no_terms' => 'No states/territories',
            'items_list_navigation' => 'States/Territories list navigation',
            'items_list' => 'States/Territories list',
            'most_used' => 'Most Used',
            'back_to_items' => '← Back to States/Territories',
        ]
    ];
    
    // Define Country taxonomy for CPT UI
    $existing_taxonomies['country'] = [
        'name' => 'country',
        'label' => 'Countries',
        'singular_label' => 'Country',
        'description' => 'Property countries for location tagging',
        'public' => '1',
        'publicly_queryable' => '1',
        'hierarchical' => '0',
        'show_ui' => '1',
        'show_in_menu' => '1',
        'show_in_nav_menus' => '1',
        'query_var' => '1',
        'rewrite' => '1',
        'rewrite_slug' => 'countries',
        'rewrite_withfront' => '1',
        'rewrite_hierarchical' => '0',
        'show_admin_column' => '1',
        'show_in_rest' => '1',
        'show_tagcloud' => '1',
        'sort' => '0',
        'object_types' => ['property'],
        'labels' => [
            'menu_name' => 'Countries',
            'all_items' => 'All Countries',
            'edit_item' => 'Edit Country',
            'view_item' => 'View Country',
            'update_item' => 'Update Country',
            'add_new_item' => 'Add New Country',
            'new_item_name' => 'New Country Name',
            'parent_item' => 'Parent Country',
            'parent_item_colon' => 'Parent Country:',
            'search_items' => 'Search Countries',
            'popular_items' => 'Popular Countries',
            'separate_items_with_commas' => 'Separate countries with commas',
            'add_or_remove_items' => 'Add or remove countries',
            'choose_from_most_used' => 'Choose from the most used countries',
            'not_found' => 'No countries found',
            'no_terms' => 'No countries',
            'items_list_navigation' => 'Countries list navigation',
            'items_list' => 'Countries list',
            'most_used' => 'Most Used',
            'back_to_items' => '← Back to Countries',
        ]
    ];
    
    // Update CPT UI option
    update_option('cptui_taxonomies', $existing_taxonomies);
}
add_action('init', 'perfect_stays_register_with_cpt_ui', 11); // Run after post types are registered

/**
 * Register Post Types with ACF for Management
 * 
 * This makes our post types appear in ACF → Post Types interface
 */
function perfect_stays_register_with_acf() {
    // Only run if ACF is active
    if (!function_exists('acf_add_local_post_type')) {
        return;
    }
    
    // Register Property post type with ACF
    acf_add_local_post_type([
        'key' => 'post_type_property',
        'name' => 'property',
        'label' => 'Properties',
        'description' => 'Vacation rental properties for Perfect Stays',
        'labels' => [
            'name' => 'Properties',
            'singular_name' => 'Property',
            'menu_name' => 'Properties',
            'name_admin_bar' => 'Property',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Property',
            'new_item' => 'New Property',
            'edit_item' => 'Edit Property',
            'view_item' => 'View Property',
            'all_items' => 'All Properties',
            'search_items' => 'Search Properties',
            'parent_item_colon' => 'Parent Properties:',
            'not_found' => 'No properties found.',
            'not_found_in_trash' => 'No properties found in Trash.',
            'featured_image' => 'Featured Image',
            'set_featured_image' => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image' => 'Use as featured image',
            'archives' => 'Property Archives',
            'insert_into_item' => 'Insert into property',
            'uploaded_to_this_item' => 'Uploaded to this property',
            'filter_items_list' => 'Filter properties list',
            'items_list_navigation' => 'Properties list navigation',
            'items_list' => 'Properties list',
        ],
        'public' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-building',
        'capability_type' => 'post',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies' => ['amenity', 'city', 'state_territory', 'country'],
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'properties',
            'with_front' => true,
        ],
        'query_var' => true,
    ]);
    
    // Register Amenity taxonomy with ACF
    acf_add_local_taxonomy([
        'key' => 'taxonomy_amenity',
        'name' => 'amenity',
        'label' => 'Amenities',
        'description' => 'Property amenities and features',
        'labels' => [
            'name' => 'Amenities',
            'singular_name' => 'Amenity',
            'menu_name' => 'Amenities',
            'all_items' => 'All Amenities',
            'parent_item' => 'Parent Amenity',
            'parent_item_colon' => 'Parent Amenity:',
            'new_item_name' => 'New Amenity Name',
            'add_new_item' => 'Add New Amenity',
            'edit_item' => 'Edit Amenity',
            'update_item' => 'Update Amenity',
            'view_item' => 'View Amenity',
            'separate_items_with_commas' => 'Separate amenities with commas',
            'add_or_remove_items' => 'Add or remove amenities',
            'choose_from_most_used' => 'Choose from the most used',
            'popular_items' => 'Popular Amenities',
            'search_items' => 'Search Amenities',
            'not_found' => 'Not Found',
            'no_terms' => 'No amenities',
            'items_list' => 'Amenities list',
            'items_list_navigation' => 'Amenities list navigation',
        ],
        'object_types' => ['property'],
        'public' => true,
        'publicly_queryable' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'amenities',
            'with_front' => true,
            'hierarchical' => false,
        ],
        'query_var' => true,
    ]);
    
    // Register City taxonomy with ACF
    acf_add_local_taxonomy([
        'key' => 'taxonomy_city',
        'name' => 'city',
        'label' => 'Cities',
        'description' => 'Property cities for location tagging',
        'labels' => [
            'name' => 'Cities',
            'singular_name' => 'City',
            'menu_name' => 'Cities',
            'all_items' => 'All Cities',
            'parent_item' => 'Parent City',
            'parent_item_colon' => 'Parent City:',
            'new_item_name' => 'New City Name',
            'add_new_item' => 'Add New City',
            'edit_item' => 'Edit City',
            'update_item' => 'Update City',
            'view_item' => 'View City',
            'separate_items_with_commas' => 'Separate cities with commas',
            'add_or_remove_items' => 'Add or remove cities',
            'choose_from_most_used' => 'Choose from the most used',
            'popular_items' => 'Popular Cities',
            'search_items' => 'Search Cities',
            'not_found' => 'Not Found',
            'no_terms' => 'No cities',
            'items_list' => 'Cities list',
            'items_list_navigation' => 'Cities list navigation',
        ],
        'object_types' => ['property'],
        'public' => true,
        'publicly_queryable' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'cities',
            'with_front' => true,
            'hierarchical' => false,
        ],
        'query_var' => true,
    ]);
    
    // Register State/Territory taxonomy with ACF
    acf_add_local_taxonomy([
        'key' => 'taxonomy_state_territory',
        'name' => 'state_territory',
        'label' => 'States/Territories',
        'description' => 'Property states and territories for location tagging',
        'labels' => [
            'name' => 'States/Territories',
            'singular_name' => 'State/Territory',
            'menu_name' => 'States/Territories',
            'all_items' => 'All States/Territories',
            'parent_item' => 'Parent State/Territory',
            'parent_item_colon' => 'Parent State/Territory:',
            'new_item_name' => 'New State/Territory Name',
            'add_new_item' => 'Add New State/Territory',
            'edit_item' => 'Edit State/Territory',
            'update_item' => 'Update State/Territory',
            'view_item' => 'View State/Territory',
            'separate_items_with_commas' => 'Separate states/territories with commas',
            'add_or_remove_items' => 'Add or remove states/territories',
            'choose_from_most_used' => 'Choose from the most used',
            'popular_items' => 'Popular States/Territories',
            'search_items' => 'Search States/Territories',
            'not_found' => 'Not Found',
            'no_terms' => 'No states/territories',
            'items_list' => 'States/Territories list',
            'items_list_navigation' => 'States/Territories list navigation',
        ],
        'object_types' => ['property'],
        'public' => true,
        'publicly_queryable' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'states',
            'with_front' => true,
            'hierarchical' => false,
        ],
        'query_var' => true,
    ]);
    
    // Register Country taxonomy with ACF
    acf_add_local_taxonomy([
        'key' => 'taxonomy_country',
        'name' => 'country',
        'label' => 'Countries',
        'description' => 'Property countries for location tagging',
        'labels' => [
            'name' => 'Countries',
            'singular_name' => 'Country',
            'menu_name' => 'Countries',
            'all_items' => 'All Countries',
            'parent_item' => 'Parent Country',
            'parent_item_colon' => 'Parent Country:',
            'new_item_name' => 'New Country Name',
            'add_new_item' => 'Add New Country',
            'edit_item' => 'Edit Country',
            'update_item' => 'Update Country',
            'view_item' => 'View Country',
            'separate_items_with_commas' => 'Separate countries with commas',
            'add_or_remove_items' => 'Add or remove countries',
            'choose_from_most_used' => 'Choose from the most used',
            'popular_items' => 'Popular Countries',
            'search_items' => 'Search Countries',
            'not_found' => 'Not Found',
            'no_terms' => 'No countries',
            'items_list' => 'Countries list',
            'items_list_navigation' => 'Countries list navigation',
        ],
        'object_types' => ['property'],
        'public' => true,
        'publicly_queryable' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'countries',
            'with_front' => true,
            'hierarchical' => false,
        ],
        'query_var' => true,
    ]);
}
add_action('acf/init', 'perfect_stays_register_with_acf', 12); // Run after ACF init

/**
 * Theme Customizer Settings
 * 
 * Register customizer sections and controls for theme options.
 * This allows users to customize colors, fonts, and other theme settings.
 */
function perfect_stays_customize_register($wp_customize) {
    // Colors Section
    $wp_customize->add_section('perfect_stays_colors', [
        'title' => __('Perfect Stays Colors', 'floorspace'),
        'priority' => 30,
    ]);
    
    // Primary Color
    $wp_customize->add_setting('primary_color', [
        'default' => '#D9F275',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', [
        'label' => __('Primary Color', 'floorspace'),
        'section' => 'perfect_stays_colors',
        'settings' => 'primary_color',
    ]));
    
    // Button Text Color
    $wp_customize->add_setting('button_text_color', [
        'default' => '#0F2F14',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'button_text_color', [
        'label' => __('Button Text Color', 'floorspace'),
        'section' => 'perfect_stays_colors',
        'settings' => 'button_text_color',
    ]));
}
add_action('customize_register', 'perfect_stays_customize_register');

/**
 * Output Customizer CSS Variables
 * 
 * Generate CSS custom properties based on customizer settings.
 * These variables are used throughout the theme for consistent styling.
 */
function perfect_stays_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#D9F275');
    $button_text_color = get_theme_mod('button_text_color', '#0F2F14');
    
    echo '<style type="text/css">';
    echo ':root {';
    echo '--color-primary: ' . esc_attr($primary_color) . ';';
    echo '--color-button-text: ' . esc_attr($button_text_color) . ';';
    echo '}';
    echo '.btn-primary { background-color: var(--color-primary); color: var(--color-button-text); }';
    echo '</style>';
}
add_action('wp_head', 'perfect_stays_customizer_css'); 

/**
 * Automatically set the featured image to the first photo in the gallery
 * when a Property post is saved and no featured image is set.
 * Now uses the native WordPress gallery instead of ACF gallery field.
 */
function perfect_stays_set_featured_image_from_gallery($post_id, $post) {
    // Only target the 'property' post type and ignore autosaves/revisions
    if ($post->post_type !== 'property' || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    // If a featured image is already set, do nothing
    if (has_post_thumbnail($post_id)) {
        return;
    }

    // Get the native gallery IDs (returns an array of image IDs)
    $gallery_ids = get_post_meta($post_id, '_property_gallery', true);
    if ($gallery_ids && is_array($gallery_ids) && !empty($gallery_ids)) {
        // Use the first image ID
        $first_image_id = $gallery_ids[0];
        if ($first_image_id) {
            // Temporarily remove this action to avoid infinite loop when updating the post
            remove_action('save_post', 'perfect_stays_set_featured_image_from_gallery', 20);
            set_post_thumbnail($post_id, $first_image_id);
            // Re-add the action
            add_action('save_post', 'perfect_stays_set_featured_image_from_gallery', 20, 2);
        }
    }
}
add_action('save_post', 'perfect_stays_set_featured_image_from_gallery', 20, 2); 