<?php

if ( ! class_exists( 'SFLazr_Plugin_Admin' ) ) {
    class SFLazr_Plugin_Admin {
        public static function init() {
            
            /***** CREATE MENU IN DASHBOARD - azr *****/
            add_action( 'admin_menu', 'SFLazr_options_page' );
             if ( ! function_exists( 'SFLazr_options_page' ) ) {
                function SFLazr_options_page() {
                    add_menu_page(
                        'Save for later',
                        'Save for later Options',
                        'manage_options',
                        'sfl-azr',
                        'SFLazr_options_page_html',
                        '',
                        20
                        
                    );
                }
             }
            
            /***** INCLUDE HTML FORM - azr *****/
            if ( ! function_exists( 'SFLazr_options_page_html' ) ) {
                function SFLazr_options_page_html() {
                    
                    if(in_array('wpforms/wpforms.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
                    	//plugin is activated
                    	include plugin_dir_path(__FILE__) . 'admin-form.php';
                    }


                    
                }
            }
            
            /***** INCLUDE CSS FILES - azr *****/
            if ( ! function_exists( 'SFLadminStyle' ) ) {
                function SFLadminStyle() {
                    wp_enqueue_style('sfl-admin-style', plugin_dir_url( __DIR__ ).'/admin/assets/css/sfl-admin-style.css');
                }
            }
            add_action('admin_head', 'SFLadminStyle');
            
            /***** INCLUDE JS FILES - azr *****/
            if ( ! function_exists( 'SFLadminScripts' ) ) {
                function SFLadminScripts() {
                    wp_enqueue_script('sfl-admin-script', plugin_dir_url( __DIR__ ).'/admin/assets/js/sfl-admin-script.js','','',true);
                }
            }
            add_action('admin_footer', 'SFLadminScripts');
            
            
            
            /***** ACTION FOR TOGGLE BUTTON - azr *****/
            function sflSwitchSettingPost() {
            
            	$checked = $_POST['checked'];
            	update_option('sfl_function_active', $checked);
                echo $checked;
            
            	wp_die(); // this is required to terminate immediately and return a proper response
            }
            add_action( 'wp_ajax_sflSwitchSettingPost', 'sflSwitchSettingPost' );
            
            
            
            
        }

       
    }

    SFLazr_Plugin_Admin::init();
}




