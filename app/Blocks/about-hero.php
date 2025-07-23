<?php
/**
 * About Hero Block
 * 
 * Custom Gutenberg block for the About page hero section.
 * This matches the Figma design with image on left and text on right.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register About Hero Block
 */
function register_about_hero_block() {
    // Check if Gutenberg is available
    if (!function_exists('register_block_type')) {
        return;
    }

    // Register the block
    register_block_type('floorspace/about-hero', [
        'title' => __('About Hero Section', 'floorspace'),
        'description' => __('Hero section for the About page with image and text content.', 'floorspace'),
        'category' => 'floorspace-blocks',
        'icon' => 'admin-users',
        'keywords' => ['about', 'hero', 'section'],
        'supports' => [
            'align' => ['wide', 'full'],
            'anchor' => true,
        ],
        'attributes' => [
            'heroImage' => [
                'type' => 'object',
                'default' => null,
            ],
            'heading' => [
                'type' => 'string',
                'default' => 'Our story',
            ],
            'content' => [
                'type' => 'string',
                'source' => 'html',
                'default' => '<p>We started with a simple goal: to create a better way to vacation. What began as a passion for hosting has grown into a commitment to providing comfortable, reliable stays and memorable experiences. We\'re here to ensure every stay is welcoming, worry-free, and unforgettable.</p><p>Over the years, we\'ve learned that the little things make a big difference—thoughtful touches, clear communication, and genuine care. Whether it\'s your first visit or your fifth, we\'re dedicated to making your experience smooth and enjoyable. Our story is built on hospitality, and we\'re excited to be part of yours.</p>',
            ],
            'signature' => [
                'type' => 'string',
                'default' => '— Kim and Connor',
            ],
            'backgroundColor' => [
                'type' => 'string',
                'default' => '#ffffff',
            ],
            'textColor' => [
                'type' => 'string',
                'default' => '#000000',
            ],
        ],
        'render_callback' => 'render_about_hero_block',
        'editor_script' => 'about-hero-editor',
        'editor_style' => 'about-hero-editor',
        'style' => 'about-hero-style',
    ]);
}
add_action('init', 'register_about_hero_block');

/**
 * Render the About Hero Block
 */
function render_about_hero_block($attributes) {
    // Extract attributes with defaults
    $hero_image = $attributes['heroImage'] ?? null;
    $heading = $attributes['heading'] ?? 'Our story';
    $content = $attributes['content'] ?? '';
    $signature = $attributes['signature'] ?? '— Kim and Connor';
    $background_color = $attributes['backgroundColor'] ?? '#000000';
    $text_color = $attributes['textColor'] ?? '#ffffff';
    
    // Generate unique ID for this block instance
    $block_id = 'about-hero-' . wp_generate_uuid4();
    
    ob_start();
    ?>
    <section 
        id="<?php echo esc_attr($block_id); ?>" 
        class="about-hero-section"
        style="background-color: <?php echo esc_attr($background_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
    >
        <div class="about-hero-container">
            <div class="about-hero-content">
                <!-- Image Column -->
                <div class="about-hero-image">
                    <?php if ($hero_image && isset($hero_image['url'])): ?>
                        <img 
                            src="<?php echo esc_url($hero_image['url']); ?>" 
                            alt="<?php echo esc_attr($hero_image['alt'] ?? ''); ?>"
                            class="about-hero-img"
                        />
                    <?php else: ?>
                        <div class="about-hero-placeholder">
                            <div class="placeholder-content">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                                <p>Add your hero image</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Text Column -->
                <div class="about-hero-text">
                    <h2 class="about-hero-heading"><?php echo esc_html($heading); ?></h2>
                    
                    <?php if ($content): ?>
                        <div class="about-hero-paragraph">
                            <?php echo wp_kses_post($content); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($signature): ?>
                        <div class="about-hero-signature">
                            <?php echo esc_html($signature); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <style>
    .about-hero-section {
        padding: 4rem 0;
        min-height: 600px;
        display: flex;
        align-items: center;
    }
    
    .about-hero-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        width: 100%;
    }
    
    .about-hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    
    .about-hero-image {
        position: relative;
    }
    
    .about-hero-img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        object-fit: cover;
        aspect-ratio: 4/3;
    }
    
    .about-hero-placeholder {
        width: 100%;
        aspect-ratio: 4/3;
        border: 2px dashed rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
    }
    
    .placeholder-content {
        text-align: center;
        opacity: 0.6;
    }
    
    .placeholder-content svg {
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .about-hero-text {
        padding-left: 2rem;
    }
    
    .about-hero-heading {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 2rem;
        line-height: 1.2;
    }
    
    .about-hero-paragraph {
        font-size: 1.125rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .about-hero-paragraph p {
        margin-bottom: 1.5rem;
    }
    
    .about-hero-paragraph p:last-child {
        margin-bottom: 0;
    }
    
    .about-hero-signature {
        font-size: 1.125rem;
        font-style: italic;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .about-hero-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .about-hero-text {
            padding-left: 0;
            text-align: center;
        }
        
        .about-hero-heading {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .about-hero-section {
            padding: 2rem 0;
        }
    }
    
    @media (max-width: 480px) {
        .about-hero-container {
            padding: 0 1rem;
        }
        
        .about-hero-heading {
            font-size: 1.75rem;
        }
        
        .about-hero-paragraph {
            font-size: 1rem;
        }
    }
    </style>
    <?php
    
    return ob_get_clean();
}

/**
 * Register custom block category
 */
function register_floorspace_block_category($categories) {
    return array_merge($categories, [
        [
            'slug' => 'floorspace-blocks',
            'title' => __('Perfect Stays Blocks', 'floorspace'),
            'icon' => 'building',
        ],
    ]);
}
add_filter('block_categories_all', 'register_floorspace_block_category');

/**
 * Enqueue block editor assets
 */
function enqueue_about_hero_block_assets() {
    $script_path = get_template_directory() . '/resources/js/blocks/about-hero.js';
    $style_path = get_template_directory() . '/resources/css/blocks/about-hero.css';
    
    // Get file modification times safely
    $script_version = file_exists($script_path) ? filemtime($script_path) : '1.0.0';
    $style_version = file_exists($style_path) ? filemtime($style_path) : '1.0.0';
    
    // Enqueue editor script
    if (file_exists($script_path)) {
        wp_register_script(
            'about-hero-editor',
            get_template_directory_uri() . '/resources/js/blocks/about-hero.js',
            ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'],
            $script_version
        );
    }
    
    // Enqueue editor styles
    if (file_exists($style_path)) {
        wp_register_style(
            'about-hero-editor',
            get_template_directory_uri() . '/resources/css/blocks/about-hero.css',
            ['wp-edit-blocks'],
            $style_version
        );
        
        // Register frontend styles (same as editor for consistency)
        wp_register_style(
            'about-hero-style',
            get_template_directory_uri() . '/resources/css/blocks/about-hero.css',
            [],
            $style_version
        );
    }
}
add_action('init', 'enqueue_about_hero_block_assets'); 