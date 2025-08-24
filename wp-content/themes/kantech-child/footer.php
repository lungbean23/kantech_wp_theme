<?php
/**
 * Minimal footer for kantech-child.
 */
?>
<footer class="footer" role="contentinfo">
  <div class="container footer-inner">
    <div class="footer-left">
      <a class="footer-brand" href="<?php echo esc_url( home_url('/') ); ?>">
        <?php bloginfo('name'); ?>
      </a>
      <small>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</small>
    </div>
    <nav class="footer-nav" aria-label="Footer">
      <?php if ( function_exists('wc_get_page_permalink') ) : ?>
        <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>">Shop</a>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Cart</a>
        <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>">
          <?php echo is_user_logged_in() ? 'My account' : 'Login / Register'; ?>
        </a>
      <?php else : ?>
        <a href="<?php echo esc_url( home_url('/') ); ?>">Home</a>
        <a href="<?php echo esc_url( wp_login_url() ); ?>">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
