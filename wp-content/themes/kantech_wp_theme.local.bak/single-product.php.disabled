<?php
/**
 * Single Product template
 *
 * Displays detailed information for a single product, including a gallery
 * of images and pricing metadata.  Products are custom post types with
 * optional meta fields for price and extra images.  Clicking a thumbnail
 * in the gallery will swap the main image.
 */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
    $post_id = get_the_ID();
    // Retrieve price meta
    $price = get_post_meta( $post_id, '_kantech_price', true );
    // Retrieve extra images meta (comma-separated attachment IDs)
    $extra_images = get_post_meta( $post_id, '_kantech_extra_images', true );
    $extra_ids    = array_filter( array_map( 'trim', explode( ',', $extra_images ) ) );
    $gallery_sources = array();
    // Main image: featured image if exists
    if ( has_post_thumbnail() ) {
      $main_id  = get_post_thumbnail_id( $post_id );
      $main_url = wp_get_attachment_image_url( $main_id, 'large' );
      if ( $main_url ) {
        $gallery_sources[] = $main_url;
      }
    }
    // Append extra images
    if ( ! empty( $extra_ids ) ) {
      foreach ( $extra_ids as $img_id ) {
        $url = wp_get_attachment_image_url( $img_id, 'large' );
        if ( $url ) {
          $gallery_sources[] = $url;
        }
      }
    }
    // Fallback: use theme hero image if no images available
    if ( empty( $gallery_sources ) ) {
      $gallery_sources[] = get_template_directory_uri() . '/images/hero.png';
    }
    ?>
    <main class="product-detail">
      <div class="detail-container">
        <!-- Left column: image and gallery -->
        <div class="detail-left">
          <img id="mainImage" class="detail-image" src="<?php echo esc_url( $gallery_sources[0] ); ?>" alt="<?php the_title_attribute(); ?> image" loading="lazy" />
          <?php if ( count( $gallery_sources ) > 1 ) : ?>
            <div id="imageGallery" class="image-gallery">
              <?php foreach ( $gallery_sources as $index => $src ) : ?>
                <img src="<?php echo esc_url( $src ); ?>" alt="<?php the_title_attribute(); ?> image <?php echo $index + 1; ?>" loading="lazy" class="<?php echo $index === 0 ? 'active' : ''; ?>" />
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <p><?php echo wp_kses_post( get_the_content() ); ?></p>
        </div>
        <!-- Right column: product details -->
        <div class="detail-right">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-link">&larr; Back to products</a>
          <h2><?php the_title(); ?></h2>
          <p class="price">
            <?php if ( $price ) : ?>
              <?php echo esc_html__( 'Price:', 'kantech' ); ?> <?php echo esc_html( $price ); ?>
            <?php else : ?>
              <?php echo esc_html__( 'Price: Contact us for pricing', 'kantech' ); ?>
            <?php endif; ?>
          </p>
          <div class="card-actions">
            <input type="number" min="1" max="100" value="1" class="quantity-input" aria-label="Select quantity" />
            <!-- For real e-commerce functionality use a plugin like WooCommerce -->
            <a href="mailto:sales@realworldtechnologies.us?subject=<?php echo rawurlencode( 'Product Inquiry: ' . get_the_title() ); ?>" class="add-to-cart-btn">Request Invoice</a>
          </div>
        </div>
      </div>
    </main>
    <!-- Inline script to handle gallery thumbnail clicks -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mainImg = document.getElementById('mainImage');
      const gallery = document.getElementById('imageGallery');
      if (gallery) {
        gallery.querySelectorAll('img').forEach(function(thumb) {
          thumb.addEventListener('click', function() {
            const src = this.getAttribute('src');
            mainImg.setAttribute('src', src);
            // Update active class
            gallery.querySelectorAll('img').forEach(function(img) { img.classList.remove('active'); });
            this.classList.add('active');
          });
        });
      }
    });
    </script>
    <?php
  endwhile;
endif;

get_footer();