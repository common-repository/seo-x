<?php
function seox_redirects_add_data(){
    /**
     * Process submit data
     */
    if( isset( $_POST['seox-redirect-add'] ) ){
        if ( isset( $_POST['_wpnonce'] ) || wp_verify_nonce( $_POST['_wpnonce'], 'seox_redirects_add' ) ){
            // process form data & sanitize
            $url_source = sanitize_text_field( $_POST['url_source'] );
            $url_to     = sanitize_text_field( $_POST['url_to'] );
            $status     = sanitize_text_field( $_POST['status'] );

            global $wpdb;
            $tablename = $wpdb->prefix.'seox_redirects';

            $sql = $wpdb->prepare( 
                "INSERT INTO $tablename ( url_source, url_to, status ) VALUES ( %s, %s, %s )",
                $url_source,
                $url_to,
                $status
            );

            $query = $wpdb->query( $sql );
        
            if ( 1 == $query ){
                wp_redirect( admin_url( '/admin.php?page=seox-redirects') , '301', 'WordPress' ); exit();
            }
        } else {
            ?>
                <div id="robotsmessage" class="notice notice-error">
                    <p><?php _e( 'Nonce verify error', 'seox' ); ?></p>
                </div>
            <?php
        }
    }
}
add_action('admin_init', 'seox_redirects_add_data');

function seox_redirects_data_update(){
    /**
     * Check if data submit, then take action
     */
    if( isset( $_POST['update'] ) ){
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'seox_redirects_update' ) ){
            ?>
                <div id="seox-error-message" class="notice notice-error">
                    <p><?php _e( 'Nonce verify error', 'seox' ); ?></p>
                </div>
            <?php
        } else {
            // process form data
            $id = sanitize_text_field( $_POST['id'] );
            $url_source = sanitize_text_field( $_POST['url_source'] );
            $url_to = sanitize_text_field( $_POST['url_to'] );
            $status = sanitize_text_field( $_POST['status'] );

            global $wpdb;
            $seox_redirects_query = $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}seox_redirects SET url_source = %s, url_to = %s, status = %s WHERE id = %d ",
                    $url_source, $url_to, $status, $id
                )
            );

            if ( 0 === $seox_redirects_query ){
                ?>
                    <div id="seox-error-message" class="notice notice-error">
                        <p><?php _e( 'Error.', 'seox' ); ?></p>
                    </div>
                <?php
            }else{
                wp_safe_redirect( admin_url( 'admin.php?page=seox-redirects') ); exit();
            }
        }
    }
}
add_action( 'admin_init', 'seox_redirects_data_update' );

function seox_redirects_dashboard_callback(){
    ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Redirects - SEO X', 'seox'); ?></h1>
            <a href="<?php echo esc_url( '?page=seox-redirects&action=seox-redirects-add' ); ?>" class="page-title-action">
                <?php _e( 'Add New', 'seox' ); ?>
            </a>
            <hr class="wp-header-end">
            <?php
                /**
                 * Display List Table
                 */
                $SEOX_List_Table = new seox_list_table();
                $SEOX_List_Table->prepare_items();

                $action = isset( $_GET['action'] ) ? sanitize_key( $_GET['action'] ) : '';

                if( 'seox-redirects-add' == $action ){
                    /**
                     * Display Redirects Insert form
                     */
                    ?>
                        <form action="<?php echo esc_url( admin_url( 'admin.php?page=seox-redirects' ) ); ?>" method="POST">
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr>
                                        <th scope="row"><label for="url_source"><?php _e( 'Source URL', 'seox' ); ?></label></th>
                                        <td>
                                            <input name="url_source" type="text" id="url_source" class="regular-text" placeholder="<?php _e( 'The relative URL you want to redirect from', 'seox' ); ?>" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row"><label for="url_to"><?php _e( 'Target URL', 'seox' ); ?></label></th>
                                        <td>
                                            <input name="url_to" type="text" id="url_to" class="regular-text ltr" placeholder="<?php _e( 'The target URL you want to redirect, or permalink.', 'seox' ); ?>" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row"><label for="status"><?php _e( 'Status', 'seox' ); ?></label></th>
                                        <td>
                                            <select name="status" id="status">
                                                <option value="active">
                                                    <?php _e( 'Active', 'seox'); ?>
                                                </option>
                                                <option value="deactive">
                                                    <?php _e( 'Deactive', 'seox'); ?>
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <?php wp_nonce_field( 'seox_redirects_add' ); ?>

                                </tbody>
                            </table>
                            <p class="submit">
                                <input type="submit" name="seox-redirect-add" id="submit" class="button button-primary" value="<?php _e( 'Submit', 'seox' ); ?>">
                            </p>
                        </form>
                    <?php
                }elseif( 'seox-redirects-edit' == $action ){
                    /**
                     * Display Redirects edit form
                     */
                    $seox_redirects_id = $_GET['id'] ? intval($_GET['id']) : '';
                    global $wpdb;
                    $data = $wpdb->get_results(
                        $wpdb->prepare( " SELECT * FROM {$wpdb->prefix}seox_redirects WHERE id='%d'", $seox_redirects_id )
                    );

                    if( isset( $data[0] ) ){
                        ?>
                        <form action="<?php echo esc_url( admin_url( 'admin.php?page=seox-redirects' ) ); ?>" method="POST">
                            <table class="form-table" role="presentation">
                                <tbody>
                                    <input type="hidden" name="id" value="<?php echo esc_html( $data[0]->id ); ?>">
                                    <tr>
                                        <th scope="row"><label for="url_source"><?php _e( 'Source URL', 'seox' ); ?></label></th>
                                        <td><input name="url_source" type="text" id="url_source" value="<?php echo esc_html( $data[0]->url_source ); ?>" class="regular-text"></td>
                                    </tr>

                                    <tr>
                                        <th scope="row"><label for="url_to"><?php _e( 'Target URL', 'seox' ); ?></label></th>
                                        <td><input name="url_to" type="text" id="url_to" value="<?php echo esc_html($data[0]->url_to); ?>" class="regular-text ltr">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row"><label for="status"><?php _e( 'Status', 'seox' ); ?></label></th>
                                        <td>
                                            <select name="status" id="status">
                                                <option value="active" <?php if ( 'active' == $data[0]->status ) echo esc_attr('selected'); ?>>
                                                    <?php _e( 'Active', 'seox'); ?>
                                                </option>
                                                <option value="deactive" <?php if ( 'deactive' == $data[0]->status ) echo esc_attr('selected'); ?>>
                                                    <?php _e( 'Deactive', 'seox'); ?>
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <?php wp_nonce_field( 'seox_redirects_update' ); ?>

                                </tbody>
                            </table>
                            <p class="submit">
                                <input type="submit" name="update" id="submit" class="button button-primary" value="<?php _e( 'Update', 'seox' ); ?>">
                            </p>
                        </form>
                        <?php
                    }else{
                        ?>
                            <div id="seox-error-message" class="notice notice-error">
                                <p><?php _e( 'You attempted to edit an item that does not exist. Perhaps it was deleted?.', 'seox' ); ?></p>
                            </div>
                        <?php
                    }
                }elseif( 'seox-redirects-delete' == $action ){
                    /**
                     * Delete Redirects item
                     */
                    $SEOX_List_Table->delete_item();
                }else{
                    $SEOX_List_Table->display();
                }
            ?>
        </div>
    <?php
}