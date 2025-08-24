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
<?php wp_body_open(); ?>
<header class="header">
  <div class="logo-area">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?> logo" class="logo" />
    </a>
    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php bloginfo( 'name' ); ?></a></h1>
  </div>
<div class="nav">
  <?php
  wp_nav_menu([
    'theme_location' => 'top-menu',
    'container'      => false,        // no extra <nav>
    'menu_class'     => 'main-nav',   // class on <ul>
    'fallback_cb'    => false
  ]);
  ?>
</div>
 <div class="search-cart-area">
  <?php
  // Woo product-only search (fallback to WP search if Woo missing)
  if ( function_exists( 'get_product_search_form' ) ) {
    get_product_search_form();
  } else {
    get_search_form();
  }
  ?>

  <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
    <a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
      🛒 Cart
      <span class="count">
        <?php echo ( function_exists('WC') && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0; ?>
      </span>
    </a>
  <?php endif; ?>
</div>




</header>


