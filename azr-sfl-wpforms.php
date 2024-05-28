<?php
/*
 * Plugin Name:       Save for later
 * Description:       An extension of WPForms for Save for later functionality
 * Version:           1.1.0
 * Author:            AZRUL
 * License:           GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**********
INCLUDE IMPORTANT FILES - AZR
**********/
require_once plugin_dir_path(__FILE__) . 'admin/admin-functions.php';
require_once plugin_dir_path(__FILE__) . 'frontend/frontend-functions.php';


/**********
ON PLUGIN ACTIVATION - AZR
/**********/
function sfl_activate() { 
	add_option( 'sfl_function_active', '0' );
	flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'sfl_activate' );


/**********
ON PLUGIN DEACTIVATION - AZR
/**********/
function sfl_deactivate() { 
	delete_option( 'sfl_function_active' );
	flush_rewrite_rules(); 
}
register_deactivation_hook( __FILE__, 'sfl_deactivate' );



function SFL_admin_notice__warning() {
    if(! in_array('wpforms/wpforms.php', apply_filters('active_plugins', get_option('active_plugins')))){
?>
        <div class="notice notice-warning">
               <p><?php _e( 'You need to activate WPForms Plugin in order to use Save for later plugin !', 'sample-text-domain' ); ?></p>
        </div>
<?php
    }
}

add_action( 'admin_notices', 'SFL_admin_notice__warning' );
    


