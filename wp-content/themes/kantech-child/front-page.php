<?php
get_header();
echo '<main id="site-content" class="container">';

if ( function_exists('woocommerce_content') ) {
    woocommerce_content(); // shop grid
} else {
    if ( have_posts() ) { while ( have_posts() ) { the_post(); the_content(); } }
}

echo '</main>';
get_footer();
