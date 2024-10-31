<?php
/**
 * SEO X Sitemap Create
 *
 * @return void
 */
function seox_sitemap_init(){
    $postsForSitemap = get_posts(array(
        'numberposts' => -1,
        'orderby'     => 'modified',
        'post_type'   => array( 'post', 'page' ),
        'order'       => 'DESC'
    ));

    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>'. "\n";
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'. "\n";

    foreach( $postsForSitemap as $post ) {
        setup_postdata( $post );

        $postdate = explode( " ", $post->post_modified );

        $sitemap .= "\t".'<url>'. "\n".
                        "\t\t".'<loc>' . get_permalink( $post->ID ) . '</loc>' . "\n" .
                        "\t\t".'<lastmod>' . $postdate[0] . '</lastmod>' . "\n".
                        "\t\t".'<changefreq>monthly</changefreq>' . "\n".
                    "\t".'</url>'. "\n";
      }

    $sitemap .= '</urlset>'. "\n";

    $fp = fopen( ABSPATH . 'sitemap.xml', 'w' );

    fwrite( $fp, $sitemap );
    fclose( $fp );
}

/**
 * Update SEO X Sitemap on action
 *
 * @return void
 */
$seox_get_dashboard_data = wp_unslash( get_option( 'seox-dashboard' ) );
if( 1 == $seox_get_dashboard_data['sitemap'] ){
    function seox_sitemap_update(){
        if( fopen( $_SERVER['DOCUMENT_ROOT'] .'/sitemap.xml', "w" ) ){
            seox_sitemap_init();
        }
    }
    add_action( 'publish_post', 'seox_sitemap_update' );
    add_action( 'publish_page', 'seox_sitemap_update' );
    add_action( 'draft_post', 'seox_sitemap_update' );
    add_action( 'draft_page', 'seox_sitemap_update' );
    add_action( 'trash_post', 'seox_sitemap_update' );
    add_action( 'trash_page', 'seox_sitemap_update' );
}