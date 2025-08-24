<?php
// Only “switch” when served via a trycloudflare host.
function ktx_is_tunnel_host() {
    return ! empty($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'trycloudflare.com');
}

function ktx_tunnel_base() {
    return ktx_is_tunnel_host() ? 'https://' . $_SERVER['HTTP_HOST'] : '';
}





// Force home/siteurl options at runtime when on the tunnel.
add_filter('pre_option_home',    fn($v) => ktx_tunnel_base() ?: $v);
add_filter('pre_option_siteurl', fn($v) => ktx_tunnel_base() ?: $v);

// Make uploads (media) point to the tunnel base when on the tunnel.
add_filter('upload_dir', function($u){
    $b = ktx_tunnel_base();
    if ($b) {
        $u['baseurl'] = $b . '/wp-content/uploads';
        $u['url']     = $u['baseurl'] . $u['subdir'];
    }
    return $u;
});

// Helper to rewrite any localhost URLs found in strings.
function ktx_rewrite_to_tunnel($s) {
    if (!$s || !ktx_is_tunnel_host()) return $s;
    $b = ktx_tunnel_base(); if (!$b) return $s;
    return str_replace(
        ['https://localhost/kantech_site','http://localhost/kantech_site','https://localhost','http://localhost'],
        [$b, $b, $b, $b],
        $s
    );
}

// Content & enqueued assets
add_filter('the_content',           'ktx_rewrite_to_tunnel', 99);
add_filter('post_thumbnail_html',   'ktx_rewrite_to_tunnel', 99);
add_filter('script_loader_src',     'ktx_rewrite_to_tunnel', 99);
add_filter('style_loader_src',      'ktx_rewrite_to_tunnel', 99);
add_filter('wp_get_attachment_url', 'ktx_rewrite_to_tunnel', 99);

// Core URL helpers
add_filter('content_url',  'ktx_rewrite_to_tunnel', 99);
add_filter('plugins_url',  'ktx_rewrite_to_tunnel', 99);
add_filter('includes_url', 'ktx_rewrite_to_tunnel', 99);
add_filter('home_url',     'ktx_rewrite_to_tunnel', 99);
add_filter('site_url',     'ktx_rewrite_to_tunnel', 99);
add_filter('template_directory_uri',   'ktx_rewrite_to_tunnel', 99);
add_filter('stylesheet_directory_uri', 'ktx_rewrite_to_tunnel', 99);

// Theme paths
add_filter('template_directory_uri',   'ktx_rewrite_to_tunnel', 99);
add_filter('stylesheet_directory_uri', 'ktx_rewrite_to_tunnel', 99);
add_filter('theme_file_uri',           'ktx_rewrite_to_tunnel', 99);

