<?php
get_header();
echo '<main id="site-content">';
while ( have_posts() ) { the_post(); the_content(); }
echo '</main>';
get_footer();
