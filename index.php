<?php
get_header();
?>
<main id="site-content">
  <?php
  // If the front page template exists and we're on the front page, use it.
  if ( is_front_page() && locate_template('front-page.php') ) {
      include locate_template('front-page.php');
  } else {
      if ( have_posts() ) {
          while ( have_posts() ) { the_post(); the_content(); }
      } else {
          echo '<p>No content.</p>';
      }
  }
  ?>
</main>
<?php get_footer(); ?>
