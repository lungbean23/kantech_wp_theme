<?php
/**
 * Swap Woo "coming soon" phrases with Kantex text (update-proof).
 */

function kantex_swap_strings( $translated, $text, $domain ) {
    if ( $domain !== 'woocommerce' ) return $translated;

    // Include both hyphen and en-dash variants from Woo’s patterns
    $map = [
        'Great things are on the horizon'
            => 'Welcome to Kantex',
        'Something big is brewing! Our store is in the works and will be launching soon!'
            => 'Explore the Kantex store — products below.',
        'Something big is brewing! Our store is in the works – Launching shortly!'
            => 'Explore the Kantex store — products below.',
    ];

    return $map[ $text ] ?? $translated;
}
add_filter( 'gettext', 'kantex_swap_strings', 10, 3 );

function kantex_swap_strings_ctx( $translated, $text, $context, $domain ) {
    return kantex_swap_strings( $translated, $text, $domain );
}
add_filter( 'gettext_with_context', 'kantex_swap_strings_ctx', 10, 4 );
