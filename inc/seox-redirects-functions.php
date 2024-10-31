<?php
/**
 * seox redirects link
 */
function seox_url_redirects() {
	/* in this array: old URLs=>new URLs  */
    global $wpdb;
    $redirect_rules = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM {$wpdb->prefix}seox_redirects WHERE status = '%s' ", 'active' )
    );

	foreach( $redirect_rules as $rule ) :
        // wp_die();
		// if URL of request matches with the one from the array, then redirect
		if( urldecode( $_SERVER['REQUEST_URI'] ) == $rule->{'url_source'} ) :
			wp_redirect( $rule->{'url_to'} , 301 );
			exit();
		endif;
	endforeach;
}
add_action('init', 'seox_url_redirects');