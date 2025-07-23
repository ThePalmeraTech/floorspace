<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            line-height: 1.6;
            color: var(--color-body);
            margin: 0;
            padding: 0;
            background-color: var(--color-background);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            color: var(--color-heading);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .header {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 0;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .site-title {
            font-family: var(--font-site-title);
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--color-heading);
            text-decoration: none;
        }
        .main {
            padding: 2rem 0;
            min-height: 60vh;
        }
        .property-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .property-card {
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }
        .property-image {
            width: 100%;
            height: 200px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        .property-content {
            padding: 1.5rem;
        }
        .property-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .property-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background: var(--color-primary, #D9F275);
            color: var(--color-button-text, #0F2F14);
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .footer {
            background: #f8f9fa;
            padding: 2rem 0;
            margin-top: 3rem;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="<?php echo home_url(); ?>" class="site-title">
                    Perfect Stays
                </a>
                <div>
                    <a href="<?php echo get_post_type_archive_link('property'); ?>">Properties</a>
                    <a href="<?php echo home_url('/about'); ?>" style="margin-left: 1rem;">About</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <?php if (is_home() || is_front_page()): ?>
                <h1>Welcome to Perfect Stays</h1>
                <p>Discover unique vacation rentals that provide comfortable, reliable stays and memorable experiences.</p>
                
                <?php
                // Show latest properties
                $properties = new WP_Query([
                    'post_type' => 'property',
                    'posts_per_page' => 6,
                ]);
                
                if ($properties->have_posts()): ?>
                    <h2>Featured Properties</h2>
                    <div class="property-grid">
                        <?php while ($properties->have_posts()): $properties->the_post(); ?>
                            <article class="property-card">
                                <div class="property-image">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else: ?>
                                        No image available
                                    <?php endif; ?>
                                </div>
                                <div class="property-content">
                                    <h3 class="property-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="property-meta">
                                        <?php if ($excerpt = get_the_excerpt()): ?>
                                            <p><?php echo wp_trim_words($excerpt, 20); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="btn-primary">
                                        View Details
                                    </a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                <?php 
                wp_reset_postdata();
                else: ?>
                    <p>No properties found. <a href="<?php echo admin_url('post-new.php?post_type=property'); ?>">Add your first property</a>.</p>
                <?php endif; ?>
                
            <?php else: ?>
                <!-- Standard WordPress loop for other pages -->
                <?php if (have_posts()): ?>
                    <?php while (have_posts()): the_post(); ?>
                        <article>
                            <h1><?php the_title(); ?></h1>
                            <div><?php the_content(); ?></div>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No content found.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Perfect Stays. Built with care for memorable experiences.</p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html> 