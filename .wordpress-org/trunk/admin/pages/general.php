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

                    if( 'insert-header-footer' === $tab ){
                        // Save Webmaster Data
                        if ( isset( $_REQUEST['ihf-submit'] ) ) {
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
                                $ihf_data = $_REQUEST['seox-ihf'];
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
                                $header    = wp_kses( $ihf_data['header'], $allow_html );
                                $body    = wp_kses( $ihf_data['body'], $allow_html );
                                $footer    = wp_kses( $ihf_data['footer'], $allow_html );
                                $seox_ihf_value = array(
                                    'header'    =>      $header,
                                    'body'      =>      $body,
                                    'footer'    =>      $footer,
                                );
                                
                                if( update_option( 'seox-ihf', $seox_ihf_value ) ){
                                    ?>
                                        <div id="seox-success-message" class="notice notice-success">
                                            <p><?php _e( 'Data Updated.', 'seox' ); ?></p>
                                        </div>
                                    <?php
                                }
                            }
                        }
                    }

                    if( 'module' === $tab ){
                        // Save Webmaster Data
                        if ( isset( $_REQUEST['dashboard-submit'] ) ) {
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
                                $seox_dashboard_data = $_REQUEST['seox-dashboard'];
                                $sitemap   = sanitize_text_field( $seox_dashboard_data['sitemap'] );
                                $seox_dashboard_value = array(
                                    'sitemap'                   =>      $sitemap,
                                );

                                if( update_option( 'seox-dashboard', $seox_dashboard_value ) ){
                                    $seox_get_dashboard_data = wp_unslash( get_option( 'seox-dashboard' ) );
                                    if( 1 == $seox_get_dashboard_data['sitemap'] ){
                                        seox_sitemap_init();
                                    }
                                    ?>
                                        <div id="seox-success-message" class="notice notice-success">
                                            <p><?php _e( 'Module Data Updated.', 'seox' ); ?></p>
                                        </div>
                                    <?php
                                }
                                
                            }
                        }
                    }
                
                ?>

                <h2 class="nav-tab-wrapper" id="seox-tabs">
                    <a href="<?php echo admin_url('admin.php?page=seox-dashboard&tab=dashboard') ?>" id="dashboard" class="nav-tab <?php if ((null === $tab) || ('dashboard' === $tab)) echo 'nav-tab-active'; ?>"><?php _e('Dashboard', 'seox'); ?></a>
                    <a href="<?php echo admin_url('admin.php?page=seox-dashboard&tab=module') ?>" id="module" class="nav-tab <?php if('module' === $tab) echo 'nav-tab-active'; ?>"><?php _e('Module', 'seox'); ?></a>
                    <a href="<?php echo admin_url('admin.php?page=seox-dashboard&tab=webmaster') ?>" id="webmaster" class="nav-tab <?php if ('webmaster' === $tab) echo 'nav-tab-active'; ?>"><?php _e('Webmaster Tools', 'seox'); ?></a>
                    <a href="<?php echo admin_url('admin.php?page=seox-dashboard&tab=insert-header-footer') ?>" id="insert-header-footer" class="nav-tab <?php if ('insert-header-footer' === $tab) echo 'nav-tab-active'; ?>"><?php _e('Insert Header Footer', 'seox'); ?></a>
                </h2>

                <div class="tab-content">
                    <?php if ('module' === $tab) : ?>
                        <div class="seoxtab" id="dashboard">
                            <!-- form start here -->
                            <form action="<?php  echo esc_url( admin_url( ( $tab ) ? 'admin.php?page=seox-dashboard&tab='.$tab.'' : 'admin.php?page=seox-dashboard' ) ); ?>" method="POST">
                                <?php wp_nonce_field('update-options'); ?>
                                <div class="seoxtab" id="dashboard">
                                    <div class="seoxtab_content">
                                        <h2><?php _e('Module', 'seox'); ?></h2>
                                        <?php 
                                            $seox_dashboard_data = wp_unslash( get_option( 'seox-dashboard' ) );
                                        ?>
                                        <div class="dashboard-wrapper">
                                            <div class="gird">
                                                
                                                <div class="seox-box">
                                                    <span class="dashicons dashicons-networking"></span>
                                                    <div class="seox-box-content">
                                                        <h3><?php _e( 'Sitemap', 'seox') ?></h3>
                                                        <p><?php _e( 'Enable SEO X\'s sitemap feature, which helps search engines intelligently crawl your website\'s content. It also supports hreflang tag.', 'seox' ); ?></p>
                                                    </div>
                                                    <hr>
                                                    <div class="seox-box-footer">
                                                        <div class="float-left">

                                                        </div>
                                                        <div class="float-right">
                                                            <label class="switch">
                                                                <input type="checkbox" <?php echo ( $seox_dashboard_data['sitemap'] == 1 ) ? 'checked' : ''; ?> name="seox-dashboard[sitemap]" value="1">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <p class="submit">
                                            <input type="submit" name="dashboard-submit" id="submit" class="button button-primary" value="Save Changes">
                                        </p>
                                    </div>
                                </div>
                            </form> <!-- form end here -->
                        </div>
                    <?php elseif ('webmaster' === $tab) : ?>
                        <form action="<?php echo esc_url( admin_url( 'admin.php?page=seox-dashboard&tab='.$tab.'' ) ); ?>" method="POST">
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
                    <?php elseif ('insert-header-footer' === $tab) : ?>
                        <form action="<?php echo esc_url( admin_url( 'admin.php?page=seox-dashboard&tab='.$tab.'' ) ); ?>" method="POST">
                            <?php wp_nonce_field('update-options'); ?>
                            <div class="seoxtab" id="insert-header-footer">
                                <h2><?php _e('Insert Header Footer', 'seox'); ?></h2>
                                <div class="seoxtab_content">
                                    <?php 
                                        $seox_ihf_data = wp_unslash( get_option( 'seox-ihf' ) );
                                    ?>
                                    <table class="form-table" role="presentation">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><label for="header"><?php _e( 'Enter Header code', 'seox' ); ?></label></th>
                                                <td>
                                                    <textarea name="seox-ihf[header]" class="regular-text" id="header" cols="30" rows="5"><?php echo esc_html( $seox_ihf_data['header'] ); ?></textarea><br>
                                                    <?php 
                                                        echo sprintf(
                                                        /* translators: %s: The `<head>` tag */
                                                            esc_html__( 'These scripts will be printed in the %s section.', 'seox' ),
                                                            '<code>&lt;head&gt;</code>'
                                                        ); 
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><label for="body"><?php _e( 'Enter Body code', 'seox' ); ?></label></th>
                                                <td>
                                                    <textarea name="seox-ihf[body]" class="regular-text" id="body" cols="30" rows="5"><?php echo esc_html( $seox_ihf_data['body'] ); ?></textarea><br>
                                                    <?php 
                                                        echo sprintf(
                                                        /* translators: %s: The `<head>` tag */
                                                            esc_html__( 'These scripts will be printed just below the opening %s tag.','seox' ),
                                                            '<code>&lt;body&gt;</code>'
                                                        ); 
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><label for="body"><?php _e( 'Enter Footer code', 'seox' ); ?></label></th>
                                                <td>
                                                    <textarea name="seox-ihf[footer]" class="regular-text" id="footer" cols="30" rows="5"><?php echo esc_html( $seox_ihf_data['footer'] ); ?></textarea><br>
                                                    <?php 
                                                        echo sprintf(
                                                        /* translators: %s: The `<head>` tag */
                                                            esc_html__( 'These scripts will be printed above the closing %s tag.','seox' ),
                                                            '<code>&lt;/body&gt;</code>'
                                                        ); 
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <p class="submit">
                                        <input type="submit" name="ihf-submit" id="submit" class="button button-primary" value="Save Changes">
                                    </p>
                                </div>
                            </div>
                        </form> <!-- form end here -->
                    <?php else : ?>
                        <h2><?php _e('Dashboard', 'seox'); ?></h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
