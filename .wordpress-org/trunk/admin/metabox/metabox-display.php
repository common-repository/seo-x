<?php
/**
 * SEO X Meta Title Display
 *
 * @return string
 */
function seox_meta_title(){
    $meta = get_post_meta( get_the_ID(), 'seox_metabox', true );
    $meta_tax = get_term_meta( get_queried_object_id(), 'seox_metabox_tax', true );

    if( ! empty ( $meta['meta-title'] ) ) {
        return esc_html( $meta['meta-title'] );
    }elseif( ! empty ( $meta_tax['meta-title'] ) ) {
        return esc_html( $meta_tax['meta-title'] );
    }else{
        return;
    }
}
add_filter( 'pre_get_document_title', 'seox_meta_title', 10 );
add_filter( 'wp_title', 'seox_meta_title', 10 );

/**
 * SEO X Meta Description Display
 *
 * @return string
 */
function seox_metabox_display(){
    ?>
    <!-- Search Engine Optimization by SEO X -->
    <?php
    $meta = get_post_meta( get_the_ID(), 'seox_metabox', true );

    if( ! empty ( $meta['meta-description'] ) ) {
        echo '<meta name="description" content="'. esc_html( $meta['meta-description'] ) . '" />';
    }
   
    $meta_tax = get_term_meta( get_queried_object_id(), 'seox_metabox_tax', true );
    if( ( ! empty ( $meta_tax ) && is_category() ) || ( ! empty ( $meta_tax ) && is_tag() ) ){
        echo '<meta name="description" content="'. esc_html( $meta_tax['meta-description'] ) . '" />';
    }
}
add_action( 'wp_head', 'seox_metabox_display', 2);