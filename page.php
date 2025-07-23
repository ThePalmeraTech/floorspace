<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .site-header {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .header-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        .site-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .btn-primary {
            background: #D9F275;
            color: #0F2F14;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #c8e066;
            transform: translateY(-2px);
        }
        .page-content {
            min-height: calc(100vh - 200px);
        }
        .site-footer {
            background: #f8f9fa;
            padding: 2rem 0;
            text-align: center;
            color: #666;
            margin-top: 3rem;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 1rem;
            }
            .nav-links {
                gap: 1rem;
            }
            .btn-primary {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header">
        <div class="header-container">
            <nav class="header-nav">
                <a href="<?php echo home_url(); ?>" class="site-title">
                    Perfect Stays
                </a>
                <div class="nav-links">
                    <a href="<?php echo get_post_type_archive_link('property'); ?>">Properties</a>
                    <a href="<?php echo home_url('/about'); ?>">About</a>
                    <a href="<?php echo get_post_type_archive_link('property'); ?>" class="btn-primary">
                        Book now
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main class="page-content">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <p>&copy; <?php echo date('Y'); ?> Perfect Stays. Built with care for memorable experiences.</p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html> 