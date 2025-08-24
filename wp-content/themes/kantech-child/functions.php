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

    // Child with cache-busting
    wp_enqueue_style(
        'kantech-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['kantech_wp_theme-style'],
        filemtime( get_stylesheet_directory() . '/style.css' )
    );

    // Needed so the cart count updates live
    wp_enqueue_script('wc-cart-fragments');
}, 20);




add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});
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
