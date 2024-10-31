<?php
/**
 * Header Code
 */
function seox_header_code_display(){
    $seox_header_data = wp_unslash( get_option( 'seox-ihf' ) );
    if( ! empty( $seox_header_data['header'] ) ):
        $allow_html = array(
            'h1'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h2'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h3'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h4'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h5'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h6'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'div'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
                'style'   =>  array(),
            ),
            'p'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'span'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'meta'    =>  array(
                'name'   =>  array(),
                'content'   =>  array(),
            ),
            'script'    =>  array(
                'src'   =>  array(),
                'async'   =>  array(),
                'type'   =>  array(),
            ),
            'ins'       =>   array(
                'class'             =>  array(),
                'style'             =>  array(),
                'data-ad-format'    =>  array(),
                'data-ad-layout'    =>  array(),
                'data-ad-client'    =>  array(),
                'data-ad-slot'      =>  array(),
            )
        );
        if( ! empty( $seox_header_data['header'] ) ):
            echo wp_kses( $seox_header_data['header'] , $allow_html );
        endif;
    endif;
}
add_action( 'wp_head', 'seox_header_code_display', 12 );

/**
 * Body Code
 */
function seox_body_code_display(){
    $seox_body_data = wp_unslash( get_option( 'seox-ihf' ) );
    if( ! empty( $seox_body_data['body'] ) ):
        $allow_html = array(
            'h1'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h2'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h3'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h4'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h5'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h6'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'div'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
                'style'   =>  array(),
            ),
            'p'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'span'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'meta'    =>  array(
                'name'   =>  array(),
                'content'   =>  array(),
            ),
            'script'    =>  array(
                'src'   =>  array(),
                'async'   =>  array(),
                'type'   =>  array(),
            ),
            'ins'       =>   array(
                'class'             =>  array(),
                'style'             =>  array(),
                'data-ad-format'    =>  array(),
                'data-ad-layout'    =>  array(),
                'data-ad-client'    =>  array(),
                'data-ad-slot'      =>  array(),
            )
        );
        if( ! empty( $seox_body_data['body'] ) ):
            echo esc_html("\n");
            echo wp_kses( $seox_body_data['body'] , $allow_html );
        endif;
    endif;
}
add_action( 'wp_body_open', 'seox_body_code_display', 12 );

/**
 * Footer Code
 */
function seox_footer_code_display(){
    $seox_footer_data = wp_unslash( get_option( 'seox-ihf' ) );
    if( ! empty( $seox_footer_data['footer'] ) ):
        $allow_html = array(
            'h1'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h2'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h3'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h4'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h5'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'h6'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'div'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
                'style'   =>  array(),
            ),
            'p'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'span'    =>  array(
                'class'   =>  array(),
                'id'   =>  array(),
            ),
            'meta'    =>  array(
                'name'   =>  array(),
                'content'   =>  array(),
            ),
            'script'    =>  array(
                'src'   =>  array(),
                'async'   =>  array(),
                'type'   =>  array(),
            ),
            'ins'       =>   array(
                'class'             =>  array(),
                'style'             =>  array(),
                'data-ad-format'    =>  array(),
                'data-ad-layout'    =>  array(),
                'data-ad-client'    =>  array(),
                'data-ad-slot'      =>  array(),
            )
        );
        if( ! empty( $seox_footer_data['footer'] ) ):
            echo esc_html("\n");
            echo wp_kses( $seox_footer_data['footer'] , $allow_html );
        endif;
    endif;
}
add_action( 'wp_footer', 'seox_footer_code_display', 20 );