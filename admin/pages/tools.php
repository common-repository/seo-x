<?php
function seox_tools_dashboard_callback(){
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1><?php _e('Tools - SEO X', 'seox'); ?></h1>
        <div class="seox_content_wrapper">
            <div class="seox_tools_content">
                <?php

                    // Save robots.txt Data
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
                
                ?>
                <h2><?php _e('Robots.txt', 'seox'); ?></h2>

                <div class="tools-content-wrapper">
                    <?php
                        if( isset( $_REQUEST['create_robots'] ) ){
                            $site_url = parse_url( site_url() );
                            $robots_txt_data = "User-agent: *\nAllow: /wp-content/uploads/\nAllow: /wp-content/plugins/\nDisallow: /wp-admin/\n\n";
                            $robots_txt_data .= "Sitemap: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}/sitemap.xml";

                            file_put_contents( $_SERVER['DOCUMENT_ROOT'] .'/robots.txt', $robots_txt_data, 0 );
                        }

                        if( isset( $_REQUEST['submit_robots_txt'] ) ){
                            $robots = fopen( $_SERVER['DOCUMENT_ROOT'] .'/robots.txt', "w" );
                            $robots_new_txt_data = $_REQUEST['robots_txt'];

                            fwrite( $robots, $robots_new_txt_data );
                            fclose( $robots );
                        }

                        $dir = $_SERVER['DOCUMENT_ROOT'];
                        $files = scandir($dir);
                        $counter = 0;
                        foreach( $files as $file ){
                            if( 'robots.txt' == $file ){
                                $counter += 1;
                            }
                        }   
                    ?>
                    <form action="<?php echo esc_url( admin_url( 'admin.php?page=seox-tools' ) ); ?>" method="POST">
                        <?php wp_nonce_field('update-options'); ?>
                        <?php if( 0 == $counter ): ?>
                        <p><?php echo esc_html__( 'You don\'t have a robots.txt file, create one here:','seox'); ?></p>
                        <input type="submit" class="button robots-new-btn" name="create_robots" value="<?php echo esc_html__( 'Create robots.txt file' , 'seox' ); ?>">
                        <?php else: ?>
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row"><label for="robots"><?php _e( 'Edit the content of your robots.txt:', 'seox' ); ?></label></th>
                                        <td>
                                            <?php $robots = fopen( $_SERVER['DOCUMENT_ROOT'] .'/robots.txt', "r" ); ?>
                                            <textarea name="robots_txt" class="regular-text" id="robots_txt" cols="30" rows="15"><?php while(!feof($robots)) { echo fgets($robots) ;} ?></textarea>
                                            <?php fclose( $robots ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input class="button" type="submit" name="submit_robots_txt" value="<?php echo esc_html__( 'Save changes to robots.txt', 'seox' ); ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
