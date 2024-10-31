<?php

// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class seox_list_table extends WP_List_Table{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items(){

        $columns    = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable   = $this->get_sortable_columns();

        $data = $this->table_data();
        usort( $data, array( $this, 'sort_data' ) );

        $item_per_page = 20;
        $current_page = $this->get_pagenum();
        $total_items = count( $data );

        $this->set_pagination_args( array(
            'total_items'   =>  $total_items,
            'per_page'      =>  $item_per_page
        ) );

        $data = array_slice( $data, ( ( $current_page - 1 ) *  $item_per_page ), $item_per_page);
        
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns(){
        $columns = array( 
            'cb'                =>  '<input type="checkbox">',
            'url_source'        =>  __('Source URL','seox'),
            'url_to'            =>  __('Destination URL','seox'),
            'status'            =>  __('Status','seox'),
        );

        return $columns;
    }

    /**
     * Column callback
     */
    public function column_cb( $item ) {
		return "<input type='checkbox' value='{$item['id']}'>";
	}

    /**
     * Column action
     */
    function column_url_source( $item ) {
		global $wpdb;

		$seox_id = isset( $item['id'] ) ? (int) $item['id'] : 0;

        $page = isset( $_REQUEST['page'] ) ? sanitize_key( $_REQUEST['page'] ) : 0;

		$actions = array(
            'edit' => sprintf('<a href="?page=%s&action=seox-redirects-edit&id=%d" class="seox-column-edit">%s</a>', $page, $seox_id, __( 'Edit', 'seox' )),
            'delete' => sprintf('<a href="?page=%s&id=%s&action=seox-redirects-delete" class="seox-column-delete">%s</a>', $page, $seox_id, __( 'Delete', 'seox' ) )
        );
            
        return sprintf('%1$s %2$s', $item['url_source'], $this->row_actions($actions) );
	}

    /**
     * Bulk Delete Item
     */
    public function get_bulk_actions(){
        $actions = array(
            'delete'    =>  'Delete'
        );

        return $actions;
    }

    /**
     * Delete item
     */
    public function delete_item( ){
        global $wpdb;
        $id = isset( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0 ;
        
        $seox_redirects_query = $wpdb->query(
            $wpdb->prepare( "DELETE FROM {$wpdb->prefix}seox_redirects WHERE id = %d", $id )
        );

        if( $seox_redirects_query ){
            ?>
                <div id="seox-error-message" class="notice notice-success">
                    <p><?php _e( 'Deleted.', 'seox' ); ?></p>
                </div>
            <?php
        }else{
            ?>
                <div id="seox-error-message" class="notice notice-error">
                    <p><?php _e( 'The link you followed has expired.', 'seox' ); ?></p>
                </div>
            <?php
        }
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name ){
        return $item[ $column_name ];
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns(){
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns(){
        return array('status' => array('status', false));
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    public function table_data(){
        global $wpdb;
        $seox_table_data = $wpdb->get_results( "SELECT url_source, url_to, status, id FROM {$wpdb->prefix}seox_redirects", ARRAY_A );
        return $seox_table_data;
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b ){
        // Set defaults
        $orderby = 'status';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        ( !empty($_GET['orderby']) ) ?? $orderby = sanitize_sql_orderby( $_GET['orderby'] );

        // If order is set use this as the order
        ( !empty($_GET['order']) ) ?? $order = sanitize_sql_orderby( $_GET['order'] );

        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc') return $result;

        return -$result;
    }
}