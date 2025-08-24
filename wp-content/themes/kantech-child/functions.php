<?php
/**
 * Kantech-child Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kantech-child
 */
add_action('wp_enqueue_scripts', function () {
    // Parent first
    wp_enqueue_style(
        'kantech_wp_theme-style',
        get_template_directory_uri() . '/style.css',
        [],
        '0.1.0'
    );

    // Child CSS (theme header + tiny overrides)
    wp_enqueue_style(
        'kantech-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['kantech_wp_theme-style'],
        filemtime( get_stylesheet_directory() . '/style.css' )
    );

    // App CSS
    $app_css = get_stylesheet_directory() . '/assets/css/app.css';
    if ( file_exists($app_css) ) {
        wp_enqueue_style(
            'kantex-app',
            get_stylesheet_directory_uri() . '/assets/css/app.css',
            ['kantech-child-style'],
            filemtime($app_css)
        );
    }

    // Small theme JS
    $app_js = get_stylesheet_directory() . '/assets/js/theme.js';
    if ( file_exists($app_js) ) {
        wp_enqueue_script(
            'kantex-app',
            get_stylesheet_directory_uri() . '/assets/js/theme.js',
            [],
            filemtime($app_js),
            true
        );
    }

    // Woo live cart fragments
    wp_enqueue_script('wc-cart-fragments');
}, 20);



/**
 * Auto-update the header cart count after AJAX add-to-cart.
 */
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    if ( function_exists('WC') && WC()->cart ) {
        ob_start(); ?>
        <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php
        $fragments['.cart-link .count'] = ob_get_clean();
    }
    return $fragments;
});
add_filter('script_loader_tag', function($tag, $handle, $src){
    if ($handle === 'kantex-app') {
        return '<script src="'.esc_url($src).'" defer></script>' . "\n";
    }
    return $tag;
}, 10, 3);
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
    add_theme_support('title-tag');
    add_theme_support('html5', ['search-form','gallery','caption','style','script']);
    register_nav_menus([
        'top-menu' => __('Top Menu','kantex')
    ]);
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
});



add_action('wp_head', function(){
    $logo = get_stylesheet_directory_uri() . '/images/logo.png';
    echo '<link rel="preload" as="image" href="'.esc_url($logo).'" imagesrcset="'.esc_url($logo).'" />' . "\n";
}, 1);

// Preconnect hint
add_filter('wp_resource_hints', function($urls, $relation_type){
    if ('preconnect' === $relation_type) {
        $urls[] = ['href' => 'https://s.w.org', 'crossorigin' => ''];
    }
    return $urls;
}, 10, 2);

add_action('wp', function () {
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
});
add_filter('woocommerce_show_page_title', '__return_false');


