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
        .btn-primary { background: #D9F275; color: #0F2F14; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 500; display: inline-block; transition: all 0.3s ease; }
        .btn-primary:hover { background: #c8e066; transform: translateY(-2px); }
        .property-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
        .property-card { border: 1px solid #e5e5e5; border-radius: 12px; overflow: hidden; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .property-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .property-image { aspect-ratio: 16/9; overflow: hidden; position: relative; }
        .property-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
        .property-card:hover .property-image img { transform: scale(1.05); }
        .property-price { position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.8); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: bold; }
        .property-content { padding: 1.5rem; }
        .property-title { font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem; color: #0B1134; }
        .property-title a { text-decoration: none; color: inherit; }
        .property-location { display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap; }
        .location-tag { background: #f0f0f1; border: 1px solid #8c8f94; border-radius: 3px; padding: 0.25rem 0.5rem; font-size: 0.8rem; color: #666; }
        .property-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; margin-bottom: 1rem; }
        .stat-item { text-align: center; padding: 0.5rem; background: #f8f9fa; border-radius: 6px; }
        .stat-number { font-size: 1.1rem; font-weight: bold; color: #0B1134; }
        .stat-label { font-size: 0.75rem; color: #666; }
        .property-amenities { margin-bottom: 1rem; }
        .amenities-preview { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .amenity-tag { background: #D9F275; color: #0F2F14; padding: 0.25rem 0.5rem; border-radius: 15px; font-size: 0.75rem; font-weight: 500; }
        .property-actions { display: flex; justify-content: space-between; align-items: center; }
        .filters { background: #f8f9fa; padding: 2rem; border-radius: 12px; margin-bottom: 3rem; }
        .filter-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .filter-group select { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; }
        @media (max-width: 768px) {
            .property-stats { grid-template-columns: repeat(2, 1fr); }
            .filter-row { grid-template-columns: 1fr; }
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
                    <a href="<?php echo get_post_type_archive_link('property'); ?>" style="margin-right: 1rem; text-decoration: none; color: #333; font-weight: 500;">Properties</a>
                    <a href="<?php echo home_url('/about'); ?>" style="margin-right: 1rem; text-decoration: none; color: #333;">About</a>
                    <a href="<?php echo get_post_type_archive_link('property'); ?>" class="btn-primary">
                        Book now
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main style="padding: 2rem 0;">
        <div class="container">
            <!-- Page Header -->
            <header style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 3rem; margin-bottom: 1rem; color: #0B1134;">Perfect Stays</h1>
                <p style="font-size: 1.125rem; color: #666; max-width: 600px; margin: 0 auto;">
                    Discover unique vacation rentals that provide comfortable, reliable stays and memorable experiences.
                </p>
            </header>

            <!-- Filters Section -->
            <div class="filters">
                <form method="GET" style="margin-bottom: 1rem;">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Location</label>
                            <select name="location">
                                <option value="">All Locations</option>
                                <?php
                                $cities = get_terms(['taxonomy' => 'city', 'hide_empty' => true]);
                                foreach ($cities as $city) {
                                    $selected = isset($_GET['location']) && $_GET['location'] == $city->slug ? 'selected' : '';
                                    echo '<option value="' . esc_attr($city->slug) . '" ' . $selected . '>' . esc_html($city->name) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Guests</label>
                            <select name="guests">
                                <option value="">Any</option>
                                <?php for ($i = 1; $i <= 12; $i++): 
                                    $selected = isset($_GET['guests']) && $_GET['guests'] == $i ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?> <?php echo $i == 1 ? 'Guest' : 'Guests'; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Price Range</label>
                            <select name="price_range">
                                <option value="">Any Price</option>
                                <option value="0-500" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '0-500' ? 'selected' : ''; ?>>$0 - $500</option>
                                <option value="500-1000" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '500-1000' ? 'selected' : ''; ?>>$500 - $1,000</option>
                                <option value="1000+" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '1000+' ? 'selected' : ''; ?>>$1,000+</option>
                            </select>
                        </div>
                        <div class="filter-group" style="display: flex; align-items: end;">
                            <button type="submit" class="btn-primary" style="width: 100%; text-align: center;">
                                Filter Properties
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if (have_posts()): ?>
                <div class="property-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <article class="property-card">
                            <!-- Property Image with Price Overlay -->
                            <div class="property-image">
                                <?php 
                                $gallery = get_field('photo_gallery');
                                if ($gallery && !empty($gallery)): ?>
                                    <img src="<?php echo esc_url($gallery[0]['sizes']['large']); ?>" alt="<?php echo esc_attr($gallery[0]['alt']); ?>">
                                <?php elseif (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php else: ?>
                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='225'%3E%3Crect width='400' height='225' fill='%23f0f0f0'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' font-family='Arial' font-size='18' fill='%23999'%3ENo Image%3C/text%3E%3C/svg%3E" alt="No image available">
                                <?php endif; ?>
                                
                                <!-- Price Overlay -->
                                <?php 
                                $booking_form = get_field('booking_form');
                                if ($booking_form === 'button' && get_field('nightly_price')): ?>
                                    <div class="property-price">
                                        $<?php echo esc_html(get_field('nightly_price')); ?>/night
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="property-content">
                                <!-- Property Title -->
                                <h2 class="property-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <!-- Location Tags -->
                                <div class="property-location">
                                    <?php 
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

                                <!-- Amenities Preview -->
                                <?php 
                                $amenities = get_field('amenities');
                                if ($amenities): ?>
                                    <div class="property-amenities">
                                        <div class="amenities-preview">
                                            <?php 
                                            $displayed = 0;
                                            foreach ($amenities as $amenity): 
                                                if ($displayed >= 3) break;
                                                ?>
                                                <span class="amenity-tag"><?php echo esc_html(ucwords(str_replace('_', ' ', $amenity))); ?></span>
                                                <?php 
                                                $displayed++;
                                            endforeach; 
                                            
                                            if (count($amenities) > 3): ?>
                                                <span class="amenity-tag" style="background: #e0e0e0; color: #666;">+<?php echo count($amenities) - 3; ?> more</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Description Excerpt -->
                                <?php if (get_field('description')): ?>
                                    <p style="color: #666; margin-bottom: 1rem; font-size: 0.9rem; line-height: 1.4;">
                                        <?php echo wp_trim_words(strip_tags(get_field('description')), 15, '...'); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <!-- Actions -->
                                <div class="property-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn-primary">
                                        View Details
                                    </a>
                                    <?php if ($booking_form === 'button' && get_field('nightly_price')): ?>
                                        <span style="font-weight: bold; color: #0B1134;">
                                            $<?php echo esc_html(get_field('nightly_price')); ?>/night
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <?php if ($wp_query->max_num_pages > 1): ?>
                    <nav style="margin-top: 3rem; text-align: center;">
                        <?php
                        echo paginate_links([
                            'current' => max(1, get_query_var('paged')),
                            'total' => $wp_query->max_num_pages,
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                            'type' => 'list',
                        ]);
                        ?>
                    </nav>
                <?php endif; ?>

            <?php else: ?>
                <div style="text-align: center; padding: 4rem 0;">
                    <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #0B1134;">No Properties Found</h2>
                    <p style="color: #666; margin-bottom: 2rem;">
                        We don't have any properties that match your criteria. Try adjusting your filters or check back soon!
                    </p>
                    <?php if (current_user_can('edit_posts')): ?>
                        <a href="<?php echo admin_url('post-new.php?post_type=property'); ?>" class="btn-primary">
                            Add First Property
                        </a>
                    <?php else: ?>
                        <a href="<?php echo home_url(); ?>" class="btn-primary">
                            Back to Home
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer style="background: #f8f9fa; padding: 2rem 0; margin-top: 3rem; text-align: center; color: #666;">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Perfect Stays. Built with care for memorable experiences.</p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html> 