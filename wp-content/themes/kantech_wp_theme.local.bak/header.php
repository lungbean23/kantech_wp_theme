<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and
 * everything up until <main>.
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="header">
  <div class="logo-area">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?> logo" class="logo" />
    </a>
    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php bloginfo( 'name' ); ?></a></h1>
  </div>
  <div class="search-cart-area">
    <input type="text" id="searchInput" placeholder="kantech_wp_theme buffalllooo…" aria-label="Search products" />
    <!-- Cart placeholder: functionality can be implemented via a plugin like WooCommerce -->
    <button class="cart-button" disabled>🛒 Cart (0)</button>
  </div>
</header>
