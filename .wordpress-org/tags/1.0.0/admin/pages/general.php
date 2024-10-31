<?php
function seox_dashboard_callback()
{
}

function seox_general_dashboard_callback()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? sanitize_key( $_GET['tab'] ) : $default_tab;
?>
    <div class="wrap">
        <h1><?php _e('General - SEO X', 'seox'); ?></h1>
        <div class="seox_content_wrapper">
            <div class="seox_main_content">
                <?php
                    if( 'webmaster' === $tab ){
                        // Save Webmaster Data
                        if ( isset( $_REQUEST['webmaster-submit'] ) ) {
                            // Check nonce
                            if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-options' ) ){
                                ?>
                                    <div id="seox-error-message" class="notice notice-error">
                                        <p><?php _e( 'Nonce verify error', 'seox' ); ?></p>
                                    </div>
                                <?php
                            }else {
                                // Save
                                // so do nothing before saving
                                $webmasterData = $_REQUEST['seox'];
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
                                $baidu  = sanitize_text_field( $webmasterData['baidu'] );
                                $bing   = sanitize_text_field( $webmasterData['bing'] );
                                $google = sanitize_text_field( $webmasterData['google'] );
                                $yandex = sanitize_text_field( $webmasterData['yandex'] );
                                $analytics  = sanitize_text_field( $webmasterData['analytics'] );
                                $adsense    = wp_kses( $webmasterData['adsense'], $allow_html );
                                $seox_webmaster_value = array(
                                    'baidu'     =>      $baidu,
                                    'bing'      =>      $bing,
                                    'google'    =>      $google,
                                    'yandex'    =>      $yandex,
                                    'analytics' =>      $analytics,
                                    'adsense'   =>      $adsense,
                                );
                                
                                if( update_option( 'seox', $seox_webmaster_value ) ){
                                    ?>
                                        <div id="seox-success-message" class="notice notice-success">
                                            <p><?php _e( 'Data Updated.', 'seox' ); ?></p>
                                        </div>
                                    <?php
                                }
                            }
                        }
                    }
                
                ?>

                <h2 class="nav-tab-wrapper" id="seox-tabs">
                    <a href="<?php echo admin_url('admin.php?page=seox-dashboard&tab=dashboard') ?>" id="dashboard" class="nav-tab <?php if ((null === $tab) || ('dashboard' === $tab)) echo 'nav-tab-active'; ?>"><?php _e('Dashboard', 'seox'); ?></a>
                    <a href="<?php echo admin_url('admin.php?page=seox-dashboard&tab=webmaster') ?>" id="webmaster" class="nav-tab <?php if ('webmaster' === $tab) echo 'nav-tab-active'; ?>"><?php _e('Webmaster Tools', 'seox'); ?></a>
                </h2>

                <div class="tab-content">
                    <?php if ('webmaster' === $tab) : ?>
                        <!-- form start here -->
                        <form action="<?php echo esc_url( admin_url( 'admin.php?page=seox-dashboard&tab=webmaster' ) ); ?>" method="POST">
                            <?php wp_nonce_field('update-options'); ?>
                            <div class="seoxtab" id="webmaster">
                                <h2><?php _e('Webmaster Tools Verification', 'seox'); ?></h2>
                                <div class="seoxtab_content">
                                    <?php 
                                        $seox_webmaster_data = wp_unslash( get_option( 'seox' ) );
                                    ?>
                                    <table class="form-table" role="presentation">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><label for="baidu"><?php _e( 'Baidu verification code', 'seox' ); ?></label></th>
                                                <td><input name="seox[baidu]" type="text" id="baidu" value="<?php echo esc_html( $seox_webmaster_data['baidu'] ); ?>" class="regular-text"></td>
                                            </tr>

                                            <tr>
                                                <th scope="row"><label for="bing"><?php _e('Bing verification code', 'seox' ); ?></label></th>
                                                <td><input name="seox[bing]" type="text" id="bing" value="<?php echo esc_html( $seox_webmaster_data['bing'] ); ?>" class="regular-text">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row"><label for="google"><?php _e('Google verification code', 'seox' ); ?></label></th>
                                                <td><input name="seox[google]" type="text" id="google" value="<?php echo esc_html( $seox_webmaster_data['google'] ); ?>" class="regular-text">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row"><label for="yandex"><?php _e('Yandex verification code', 'seox' ); ?></label></th>
                                                <td><input name="seox[yandex]" type="text" id="yandex" value="<?php echo esc_html( $seox_webmaster_data['yandex'] ); ?>" class="regular-text">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h3 class=""><?php _e('Google Analytics', 'seox'); ?></h3>
                                    <table class="form-table" role="presentation">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><label for="analytics"><?php _e('Enter Your UA Code', 'seox' ); ?></label></th>
                                                <td><input name="seox[analytics]" type="text" id="analytics" value="<?php echo esc_html( $seox_webmaster_data['analytics'] ); ?>" class="regular-text" placeholder="UA-XXXXXX-XX">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h3 class=""><?php _e('Google Adsense', 'seox'); ?></h3>
                                    <table class="form-table" role="presentation">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><label for="adsense"><?php _e( 'Enter Google Adsense code', 'seox' ); ?></label></th>
                                                <td>
                                                    <textarea name="seox[adsense]" class="regular-text" id="adsense" cols="30" rows="5"><?php echo esc_html( $seox_webmaster_data['adsense'] ); ?></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <p class="submit">
                                        <input type="submit" name="webmaster-submit" id="submit" class="button button-primary" value="Save Changes">
                                    </p>
                                </div>
                            </div>
                        </form> <!-- form end here -->
                    <?php else : ?>
                        <div class="seoxtab" id="dashboard">
                            <h2><?php _e('Dashboard', 'seox'); ?></h2>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
