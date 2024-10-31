<?php
/**
 * Display Google Analytics Data
 */
function seox_analytics_data_display(){
    $seox_analytics_data = wp_unslash( get_option( 'seox' ) );
    if( ! empty( $seox_analytics_data['analytics'] ) ):
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_html( $seox_analytics_data['analytics'] ); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?php echo esc_html( $seox_analytics_data['analytics'] ); ?>');
    </script>
    <?php
    endif;
}
add_action( 'wp_head', 'seox_analytics_data_display', 12 );

/**
 * Display Google Adsense Data
 */
function seox_adsense_data_display(){
    $seox_analytics_data = wp_unslash( get_option( 'seox' ) );
    $allow_html = array(
        'script'    =>  array(
            'src'   =>  array(),
            'async'   =>  array(),
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
    if( ! empty( $seox_analytics_data['analytics'] ) ):
        echo wp_kses( $seox_analytics_data['adsense'] , $allow_html );
    endif;
}
add_action( 'wp_footer', 'seox_adsense_data_display' );