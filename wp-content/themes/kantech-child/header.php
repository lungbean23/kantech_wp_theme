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
  <div class="container header-inner">
    <div class="logo-area">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?> logo" class="logo" />
      </a>
      <span class="site-title">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php bloginfo( 'name' ); ?></a>
      </span>
    </div>

    <button class="menu-toggle" data-menu-toggle aria-expanded="false" aria-controls="main-nav">Menu</button>

    <nav class="nav" aria-label="Main">
      <?php
      wp_nav_menu([
        'theme_location' => 'top-menu',
        'container'      => false,
        'menu_class'     => 'main-nav',
        'menu_id'        => 'main-nav',
        'items_wrap'     => '<ul id="%1$s" class="%2$s" data-main-nav>%3$s</ul>',
        'fallback_cb'    => false
      ]);
      ?>
    </nav>

    <div class="search-cart-area">
      <?php if ( function_exists( 'get_product_search_form' ) ) { get_product_search_form(); } else { get_search_form(); } ?>
      <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
        <a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
          🛒 Cart
          <span class="count">
            <?php echo ( function_exists('WC') && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0; ?>
          </span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>
