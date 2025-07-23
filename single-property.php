<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
    <style>
        /* Import Theme Fonts */
        :root {
            --font-site-title: 'Instrument Serif', serif;
            --font-heading: 'Baskerville', serif; 
            --font-body: 'Instrument Sans', sans-serif;
            --color-primary: #D9F275;
            --color-button-text: #0F2F14;
            --color-body: #3D3A3A;
            --color-heading: #0B1134;
            --color-background: #FFFFFF;
        }
        
        body {
            font-family: var(--font-body);
            color: var(--color-body);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            color: var(--color-heading);
        }
        
        .site-title {
            font-family: var(--font-site-title);
        }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .btn-primary { background: #D9F275; color: #0F2F14; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 500; display: inline-block; transition: all 0.3s ease; border: none; cursor: pointer; box-sizing: border-box; max-width: 100%; }
        .btn-primary:hover { background: #c8e066; transform: translateY(-2px); }
        .property-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; margin-bottom: 3rem; }
        .gallery-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 2rem; }
        .gallery-main { aspect-ratio: 4/3; border-radius: 12px; overflow: hidden; }
        .gallery-thumbs { display: grid; grid-template-rows: repeat(2, 1fr); gap: 1rem; }
        .gallery-thumb { aspect-ratio: 4/3; border-radius: 8px; overflow: hidden; cursor: pointer; }
        .gallery-thumb img, .gallery-main img { width: 100%; height: 100%; object-fit: cover; }
        .property-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin: 1.5rem 0; }
        .stat-item { text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 8px; }
        .stat-number { font-size: 1.5rem; font-weight: bold; color: #0B1134; }
        .stat-label { font-size: 0.9rem; color: #666; margin-top: 0.25rem; }
        .amenities-grid { display: flex; flex-direction: column; gap: 1rem; }
        .amenity-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem; }
        .booking-box { background: #fff; border: 1px solid #e5e5e5; border-radius: 12px; padding: 2rem; position: sticky; top: 2rem; box-sizing: border-box; }
        .booking-box .btn-primary { width: 100% !important; box-sizing: border-box !important; }
        .location-tags { display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap; }
        .location-tag { background: #f0f0f1; border: 1px solid #8c8f94; border-radius: 3px; padding: 0.25rem 0.5rem; font-size: 0.85rem; color: #666; }
        @media (max-width: 768px) {
            .property-grid { grid-template-columns: 1fr; gap: 2rem; }
            .gallery-grid { grid-template-columns: 1fr; }
            .gallery-thumbs { grid-template-columns: repeat(4, 1fr); grid-template-rows: 1fr; }
            .property-stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="header">
        <div class="container">
            <nav style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0;">
                <a href="<?php echo home_url(); ?>" class="site-title" style="font-size: 1.5rem; font-weight: bold; text-decoration: none; color: var(--color-heading);">
                    Perfect Stays
                </a>
                <div>
                    <a href="<?php echo get_post_type_archive_link('property'); ?>" style="margin-right: 1rem; text-decoration: none; color: #333;">Properties</a>
                    <a href="<?php echo home_url('/about'); ?>" style="margin-right: 1rem; text-decoration: none; color: #333;">About</a>
                    <a href="<?php echo get_post_type_archive_link('property'); ?>" class="btn-primary">
                        Book now
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <?php while (have_posts()): the_post(); ?>
        <main style="padding: 2rem 0;">
            <div class="container">
                <!-- Property Hero Section -->
                <div class="property-grid">
                    <!-- Left Column: Images & Details -->
                    <div>
                        <!-- Photo Gallery - Static Images -->
                        <?php 
                        // Static gallery images for demo purposes
                        $static_gallery = [
                            [
                                'url' => home_url('/wp-content/uploads/2025/07/bear-lake-house-outdoors.jpg'),
                                'alt' => 'Bear Lake House - Outdoor View'
                            ],
                            [
                                'url' => home_url('/wp-content/uploads/2025/07/bear-lake-house-indoors.jpg'),
                                'alt' => 'Bear Lake House - Indoor View'
                            ]
                        ];
                        ?>
                        
                        <div class="gallery-grid">
                            <div class="gallery-main">
                                <img src="<?php echo esc_url($static_gallery[0]['url']); ?>" alt="<?php echo esc_attr($static_gallery[0]['alt']); ?>" id="main-gallery-image">
                            </div>
                            <div class="gallery-thumbs">
                                <div class="gallery-thumb" onclick="changeMainImage('<?php echo esc_url($static_gallery[1]['url']); ?>')">
                                    <img src="<?php echo esc_url($static_gallery[1]['url']); ?>" alt="<?php echo esc_attr($static_gallery[1]['alt']); ?>">
                                </div>
                                <div class="gallery-thumb" style="position: relative; background: linear-gradient(135deg, #D9F275, #c8e066); display: flex; align-items: center; justify-content: center; color: #0F2F14; font-weight: bold; border-radius: 8px;">
                                    <span style="text-align: center; font-size: 0.9rem;">More photos<br>coming soon</span>
                                </div>
                            </div>
                        </div>

                        <!-- Property Header -->
                        <header style="margin-bottom: 2rem;">
                            <h1 style="font-size: 3rem; font-weight: bold; margin-bottom: 1rem; color: #0B1134;">
                                <?php the_title(); ?>
                            </h1>
                            
                            <!-- Location Tags -->
                            <div class="location-tags">
                                <?php 
                                // Display location taxonomies
                                $city = get_the_terms(get_the_ID(), 'city');
                                $state = get_the_terms(get_the_ID(), 'state_territory');
                                $country = get_the_terms(get_the_ID(), 'country');
                                
                                if ($city && !is_wp_error($city)):
                                    foreach ($city as $term): ?>
                                        <span class="location-tag"><?php echo esc_html($term->name); ?></span>
                                    <?php endforeach;
                                endif;
                                
                                if ($state && !is_wp_error($state)):
                                    foreach ($state as $term): ?>
                                        <span class="location-tag"><?php echo esc_html($term->name); ?></span>
                                    <?php endforeach;
                                endif;
                                
                                if ($country && !is_wp_error($country)):
                                    foreach ($country as $term): ?>
                                        <span class="location-tag"><?php echo esc_html($term->name); ?></span>
                                    <?php endforeach;
                                endif; ?>
                            </div>

                            <!-- Street Address -->
                            <?php if (get_field('street_address')): ?>
                                <p style="color: #666; margin-bottom: 1rem;">
                                    📍 <?php echo esc_html(get_field('street_address')); ?>
                                </p>
                            <?php endif; ?>
                        </header>

                        <!-- Property Stats -->
                        <div class="property-stats">
                            <div class="stat-item">
                                <div class="stat-number"><?php echo esc_html(get_field('guests') ?: '4'); ?></div>
                                <div class="stat-label">Guests</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number"><?php echo esc_html(get_field('bedrooms') ?: '2'); ?></div>
                                <div class="stat-label">Bedrooms</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number"><?php echo esc_html(get_field('bathrooms') ?: '1'); ?></div>
                                <div class="stat-label">Bathrooms</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number"><?php echo esc_html(get_field('beds') ?: '3'); ?></div>
                                <div class="stat-label">Beds</div>
                            </div>
                        </div>

                        <!-- Property Description -->
                        <?php if (get_field('description')): ?>
                            <section style="margin-bottom: 3rem;">
                                <h2 style="font-size: 2rem; margin-bottom: 1.5rem; color: #0B1134;">Description</h2>
                                <div style="font-size: 1.125rem; line-height: 1.6; color: #3D3A3A;">
                                    <?php echo get_field('description'); ?>
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Amenities -->
                        <?php 
                        $amenities = get_field('amenities');
                        if ($amenities): ?>
                            <section style="background: #f8f9fa; padding: 2rem; border-radius: 12px; margin-bottom: 3rem;">
                                <h2 style="font-size: 2rem; margin-bottom: 2rem; color: #0B1134;">Amenities</h2>
                                <div class="amenities-grid">
                                    <?php foreach ($amenities as $amenity): ?>
                                        <div class="amenity-item">
                                            <span style="color: #D9F275; font-size: 1.25rem;">✓</span>
                                            <span style="color: #3D3A3A;"><?php echo esc_html(ucwords(str_replace('_', ' ', $amenity))); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>
                    </div>

                    <!-- Right Column: Booking Box -->
                    <div>
                        <div class="booking-box">
                            <?php 
                            // Get booking configuration
                            $booking_form = get_field('booking_form') ?: 'default';
                            $price = get_field('nightly_price') ?: '899';
                            $button_text = get_field('button_text') ?: 'Check availability';
                            $button_link = get_field('button_link') ?: '#';
                            $below_text = get_field('below_button_text') ?: 'Or call us at 555-555-1234';
                            
                            if ($booking_form === 'button'): ?>
                                <!-- Button-based booking -->
                                <div style="margin-bottom: 2rem;">
                                    <span style="font-size: 2rem; font-weight: bold; color: #0B1134;">$<?php echo esc_html($price); ?></span>
                                    <span style="color: #666;"> / night</span>
                                </div>
                                
                                <a href="<?php echo esc_url($button_link); ?>" class="btn-primary" style="width: 100%; text-align: center; margin-bottom: 1rem; display: block;">
                                    <?php echo esc_html($button_text); ?>
                                </a>
                                
                                <p style="text-align: center; color: #666; font-size: 0.9rem; margin: 0;">
                                    <?php echo esc_html($below_text); ?>
                                </p>

                            <?php elseif ($booking_form === 'embed_code'): 
                                $embed_code = get_field('booking_form_code');
                                if ($embed_code): ?>
                                    <!-- Embedded booking form -->
                                    <div style="margin-bottom: 1rem;">
                                        <h3 style="margin-bottom: 1rem; color: #0B1134;">Book Your Stay</h3>
                                        <?php echo $embed_code; ?>
                                    </div>
                                <?php else: 
                                    // Fallback if embed code is empty
                                    ?>
                                    <div style="margin-bottom: 2rem;">
                                        <span style="font-size: 2rem; font-weight: bold; color: #0B1134;">$<?php echo esc_html($price); ?></span>
                                        <span style="color: #666;"> / night</span>
                                    </div>
                                    
                                    <a href="<?php echo esc_url($button_link); ?>" class="btn-primary" style="width: 100%; text-align: center; margin-bottom: 1rem; display: block;">
                                        <?php echo esc_html($button_text); ?>
                                    </a>
                                    
                                    <p style="text-align: center; color: #666; font-size: 0.9rem; margin: 0;">
                                        <?php echo esc_html($below_text); ?>
                                    </p>
                                <?php endif; ?>
                            <?php else: ?>
                                <!-- Default booking form (always shows) -->
                                <div style="margin-bottom: 2rem;">
                                    <span style="font-size: 2rem; font-weight: bold; color: #0B1134;">$<?php echo esc_html($price); ?></span>
                                    <span style="color: #666;"> / night</span>
                                </div>
                                
                                <a href="<?php echo esc_url($button_link); ?>" class="btn-primary" style="width: 100%; text-align: center; margin-bottom: 1rem; display: block;">
                                    <?php echo esc_html($button_text); ?>
                                </a>
                                
                                <p style="text-align: center; color: #666; font-size: 0.9rem; margin: 0;">
                                    <?php echo esc_html($below_text); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php endwhile; ?>

    <footer style="background: #f8f9fa; padding: 2rem 0; margin-top: 3rem; text-align: center; color: #666;">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Perfect Stays. Built with care for memorable experiences.</p>
        </div>
    </footer>

    <script>
        function changeMainImage(src) {
            document.getElementById('main-gallery-image').src = src;
        }
    </script>

    <?php wp_footer(); ?>
</body>
</html> 