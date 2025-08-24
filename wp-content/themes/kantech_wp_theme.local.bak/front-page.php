<?php
/**
 * Front page template
 *
 * Displays a hero section, category navigation and product grid. Products are custom
 * post types defined in functions.php. Categories are terms in the product_category
 * taxonomy. Clicking a category tab will show only that category's products.
 */

get_header();

// Fetch all product categories ordered by name
$categories = get_terms( array(
  'taxonomy'   => 'product_category',
  'hide_empty' => false,
) );

?>

<!-- Hero Section -->
<section class="hero">
  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/hero.png' ); ?>" alt="Security hero image" loading="lazy" />
  <div class="hero-text">
    <h2>Secure Your World with Kantech</h2>
    <p>Explore our full line of access control products</p>
  </div>
</section>

<!-- Top navigation populated with product categories -->
<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
  <nav class="top-nav" aria-label="Product categories">
    <ul>
      <?php foreach ( $categories as $index => $cat ) : ?>
        <li class="<?php echo $index === 0 ? 'active' : ''; ?>" data-target="<?php echo esc_attr( $cat->slug ); ?>">
          <?php echo esc_html( $cat->name ); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
<?php endif; ?>

<!-- Product Grid -->
<main class="content">
  <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
    <?php foreach ( $categories as $index => $cat ) : ?>
      <section id="<?php echo esc_attr( $cat->slug ); ?>" style="<?php echo $index === 0 ? '' : 'display:none;'; ?>">
        <?php
        // Query products in this category
        $args  = array(
          'post_type'      => 'product',
          'posts_per_page' => -1,
          'tax_query'      => array(
            array(
              'taxonomy' => 'product_category',
              'field'    => 'term_id',
              'terms'    => $cat->term_id,
            ),
          ),
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
          while ( $query->have_posts() ) :
            $query->the_post();
            ?>
            <div class="product-card" data-name="<?php echo esc_attr( strtolower( get_the_title() ) ); ?>" data-description="<?php echo esc_attr( strtolower( strip_tags( get_the_excerpt() ) ) ); ?>">
              <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                  <?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                </a>
              <?php else : ?>
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/hero.png' ); ?>" alt="<?php the_title_attribute(); ?> image" loading="lazy" />
                </a>
              <?php endif; ?>
              <h3><?php the_title(); ?></h3>
              <p><?php echo get_the_excerpt(); ?></p>
 


<div class="card-actions">
  <a class="btn" href="<?php the_permalink(); ?>">View Details</a>
  <?php echo do_shortcode('[add_to_cart id="'.get_the_ID().'" show_price="false" style="border:0;"]'); ?>
  <?php if ( function_exists('wc_get_product') && ($p = wc_get_product(get_the_ID())) ) {
    echo '<div class="price">'.$p->get_price_html().'</div>';
  } ?>
</div>


            <?php
          endwhile;
          wp_reset_postdata();
        else :
          echo '<p>No products found in this category.</p>';
        endif;
        ?>
      </section>
    <?php endforeach; ?>
  <?php else : ?>
    <p>No product categories defined. Please create categories and assign products in the WordPress admin.</p>
  <?php endif; ?>
</main>

<?php
get_footer();
