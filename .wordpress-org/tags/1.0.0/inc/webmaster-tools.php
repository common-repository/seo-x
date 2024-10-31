<?php
/**
 * Display Webmaster Data
 */
function seox_webmaster_data_display(){
    $seox_webmaster_data = wp_unslash( get_option( 'seox' ) );
    if( !empty( $seox_webmaster_data['baidu'] ) ):
    ?>
<meta name="baidu-site-verification" content="<?php echo esc_html( $seox_webmaster_data['baidu'] ); ?>" />
    <?php
    endif;

    if( !empty( $seox_webmaster_data['bing'] ) ):
    ?>
<meta name="msvalidate.01" content="<?php echo esc_html( $seox_webmaster_data['bing'] ); ?>" />
    <?php
    endif;

    if( !empty( $seox_webmaster_data['google'] ) ):
    ?>
<meta name="google-site-verification" content="<?php echo esc_html( $seox_webmaster_data['google'] ); ?>" />
    <?php
    endif;

    if( !empty( $seox_webmaster_data['yandex'] ) ):
    ?>
<meta name="yandex-verification" content="<?php echo esc_html( $seox_webmaster_data['yandex'] ); ?>" />
    <?php
    endif;
}
add_action( 'wp_head', 'seox_webmaster_data_display', 11 );