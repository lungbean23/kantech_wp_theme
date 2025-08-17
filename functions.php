<?php
/**
 * Kantech Equipment Theme functions and definitions
 *
 * This file sets up theme defaults and registers support for various
 * WordPress features. It also registers a custom post type for
 * products and a taxonomy for product categories.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Theme setup.
 */
function kantech_theme_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'kantech', get_template_directory() . '/languages' );

    // Add RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for post thumbnails.
    add_theme_support( 'post-thumbnails' );

    // Register a navigation menu for the top menu.
    register_nav_menus( array(
        'top-menu' => __( 'Top Menu', 'kantech' ),
    ) );
}
add_action( 'after_setup_theme', 'kantech_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function kantech_enqueue_scripts() {
    // Theme stylesheet
    wp_enqueue_style( 'kantech-style', get_stylesheet_uri(), array(), '1.0' );

    // Custom JavaScript for navigation tabs and search filtering
    wp_enqueue_script( 'kantech-theme', get_template_directory_uri() . '/script.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'kantech_enqueue_scripts' );

/**
 * Register custom post type for products and taxonomy for product categories.
 */
function kantech_register_custom_post_types() {
    // Product post type
    $labels = array(
        'name'               => _x( 'Products', 'post type general name', 'kantech' ),
        'singular_name'      => _x( 'Product', 'post type singular name', 'kantech' ),
        'menu_name'          => _x( 'Products', 'admin menu', 'kantech' ),
        'name_admin_bar'     => _x( 'Product', 'add new on admin bar', 'kantech' ),
        'add_new'            => _x( 'Add New', 'product', 'kantech' ),
        'add_new_item'       => __( 'Add New Product', 'kantech' ),
        'new_item'           => __( 'New Product', 'kantech' ),
        'edit_item'          => __( 'Edit Product', 'kantech' ),
        'view_item'          => __( 'View Product', 'kantech' ),
        'all_items'          => __( 'All Products', 'kantech' ),
        'search_items'       => __( 'Search Products', 'kantech' ),
        'parent_item_colon'  => __( 'Parent Products:', 'kantech' ),
        'not_found'          => __( 'No products found.', 'kantech' ),
        'not_found_in_trash' => __( 'No products found in Trash.', 'kantech' )
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'products' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    );
    register_post_type( 'product', $args );

    // Product category taxonomy
    $taxonomy_args = array(
        'labels' => array(
            'name'          => _x( 'Product Categories', 'taxonomy general name', 'kantech' ),
            'singular_name' => _x( 'Product Category', 'taxonomy singular name', 'kantech' ),
            'search_items'  => __( 'Search Product Categories', 'kantech' ),
            'all_items'     => __( 'All Product Categories', 'kantech' ),
            'edit_item'     => __( 'Edit Product Category', 'kantech' ),
            'update_item'   => __( 'Update Product Category', 'kantech' ),
            'add_new_item'  => __( 'Add New Product Category', 'kantech' ),
            'new_item_name' => __( 'New Product Category Name', 'kantech' ),
            'menu_name'     => __( 'Product Categories', 'kantech' ),
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array( 'slug' => 'product-category' ),
    );
    register_taxonomy( 'product_category', array( 'product' ), $taxonomy_args );
}
add_action( 'init', 'kantech_register_custom_post_types' );

/**
 * Register custom meta fields for products (price and extra images).
 */
function kantech_register_product_meta() {
    // Price field
    register_post_meta( 'product', '_kantech_price', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback'     => function() {
            return current_user_can( 'edit_posts' );
        }
    ) );
    // Extra images field: stored as comma-separated attachment IDs
    register_post_meta( 'product', '_kantech_extra_images', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback'     => function() {
            return current_user_can( 'edit_posts' );
        }
    ) );
}
add_action( 'init', 'kantech_register_product_meta' );