<?php
/**
 * Example: How to display the Property Gallery in Frontend
 * 
 * This file shows different ways to display the native WordPress
 * gallery in your theme templates.
 * 
 * You can copy these examples to your single-property.php,
 * archive-property.php, or any template file.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Example 1: Simple Gallery Grid
 * Use this in your single-property.php template
 */
function display_property_gallery_simple() {
    $gallery = get_property_gallery(); // Uses the helper function we created
    
    if (empty($gallery)) {
        return;
    }
    
    echo '<div class="property-gallery">';
    echo '<h3>Photo Gallery</h3>';
    echo '<div class="gallery-grid">';
    
    foreach ($gallery as $image) {
        echo '<div class="gallery-item">';
        echo '<img src="' . esc_url($image['sizes']['medium'][0]) . '" ';
        echo 'alt="' . esc_attr($image['alt']) . '" ';
        echo 'title="' . esc_attr($image['title']) . '" />';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * Example 2: Gallery with Lightbox Support
 * Use this for a more advanced gallery with popup functionality
 */
function display_property_gallery_lightbox() {
    $gallery = get_property_gallery();
    
    if (empty($gallery)) {
        return;
    }
    
    echo '<div class="property-gallery-lightbox">';
    echo '<h3>Photo Gallery</h3>';
    echo '<div class="gallery-grid-lightbox">';
    
    foreach ($gallery as $index => $image) {
        echo '<div class="gallery-item-lightbox" data-index="' . $index . '">';
        echo '<img src="' . esc_url($image['sizes']['medium'][0]) . '" ';
        echo 'alt="' . esc_attr($image['alt']) . '" ';
        echo 'data-full="' . esc_url($image['url']) . '" />';
        echo '<div class="gallery-overlay">';
        echo '<span class="gallery-zoom">🔍</span>';
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * Example 3: Featured Image + Gallery Thumbnails
 * Use this for a main image with thumbnail navigation
 */
function display_property_gallery_featured() {
    $gallery = get_property_gallery();
    
    if (empty($gallery)) {
        return;
    }
    
    $featured_image = $gallery[0]; // First image as featured
    $thumbnails = array_slice($gallery, 1); // Rest as thumbnails
    
    echo '<div class="property-gallery-featured">';
    
    // Main featured image
    echo '<div class="featured-image">';
    echo '<img id="main-gallery-image" src="' . esc_url($featured_image['sizes']['large'][0]) . '" ';
    echo 'alt="' . esc_attr($featured_image['alt']) . '" />';
    echo '</div>';
    
    // Thumbnail navigation
    if (!empty($thumbnails)) {
        echo '<div class="gallery-thumbnails">';
        
        // Include the featured image as first thumbnail
        echo '<img class="thumbnail active" src="' . esc_url($featured_image['sizes']['thumbnail'][0]) . '" ';
        echo 'data-large="' . esc_url($featured_image['sizes']['large'][0]) . '" ';
        echo 'alt="' . esc_attr($featured_image['alt']) . '" />';
        
        foreach ($thumbnails as $image) {
            echo '<img class="thumbnail" src="' . esc_url($image['sizes']['thumbnail'][0]) . '" ';
            echo 'data-large="' . esc_url($image['sizes']['large'][0]) . '" ';
            echo 'alt="' . esc_attr($image['alt']) . '" />';
        }
        
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Example 4: Just get the gallery data as array
 * Use this if you want to create your own custom display
 */
function get_property_gallery_data_example() {
    $gallery = get_property_gallery();
    
    if (empty($gallery)) {
        return [];
    }
    
    // Example: Return just the data you need
    $gallery_data = [];
    
    foreach ($gallery as $image) {
        $gallery_data[] = [
            'id' => $image['ID'],
            'thumbnail' => $image['sizes']['thumbnail'][0],
            'medium' => $image['sizes']['medium'][0],
            'large' => $image['sizes']['large'][0],
            'full' => $image['url'],
            'alt' => $image['alt'],
            'title' => $image['title'],
            'caption' => $image['caption']
        ];
    }
    
    return $gallery_data;
}

/**
 * CSS Examples - Add this to your theme's style.css
 */
function property_gallery_css_examples() {
    ?>
    <style>
    /* Simple Gallery Grid */
    .property-gallery .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .property-gallery .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    
    .property-gallery .gallery-item img:hover {
        transform: scale(1.05);
    }
    
    /* Gallery with Lightbox */
    .gallery-grid-lightbox {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .gallery-item-lightbox {
        position: relative;
        cursor: pointer;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .gallery-item-lightbox img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-item-lightbox:hover .gallery-overlay {
        opacity: 1;
    }
    
    .gallery-zoom {
        color: white;
        font-size: 24px;
    }
    
    /* Featured Image + Thumbnails */
    .property-gallery-featured .featured-image {
        margin-bottom: 20px;
    }
    
    .property-gallery-featured .featured-image img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .gallery-thumbnails {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 10px 0;
    }
    
    .gallery-thumbnails .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.3s ease;
        flex-shrink: 0;
    }
    
    .gallery-thumbnails .thumbnail:hover,
    .gallery-thumbnails .thumbnail.active {
        opacity: 1;
        border: 2px solid #007cba;
    }
    </style>
    <?php
}

/**
 * JavaScript Example for Thumbnail Navigation
 */
function property_gallery_js_examples() {
    ?>
    <script>
    // Thumbnail navigation for featured gallery
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnails = document.querySelectorAll('.gallery-thumbnails .thumbnail');
        const mainImage = document.getElementById('main-gallery-image');
        
        thumbnails.forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                // Remove active class from all thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Update main image
                const largeUrl = this.getAttribute('data-large');
                const alt = this.getAttribute('alt');
                
                if (mainImage && largeUrl) {
                    mainImage.src = largeUrl;
                    mainImage.alt = alt;
                }
            });
        });
    });
    </script>
    <?php
}

/**
 * Usage Examples in your template files:
 * 
 * In single-property.php:
 * <?php display_property_gallery_simple(); ?>
 * 
 * Or:
 * <?php display_property_gallery_lightbox(); ?>
 * 
 * Or:
 * <?php display_property_gallery_featured(); ?>
 * 
 * Or get data and create custom display:
 * <?php 
 * $gallery_data = get_property_gallery_data_example();
 * foreach ($gallery_data as $image) {
 *     echo '<img src="' . $image['medium'] . '" alt="' . $image['alt'] . '">';
 * }
 * ?>
 */ 