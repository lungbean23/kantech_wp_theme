<?php
get_header();

if ( function_exists('woocommerce_content') ) {
    // This shows the standard product archive (Shop grid) when is_shop().
    woocommerce_content();
} else {
    // Fallback (if Woo disabled)
    if ( have_posts() ) {
        while ( have_posts() ) { the_post(); the_content(); }
    }
}

get_footer();
