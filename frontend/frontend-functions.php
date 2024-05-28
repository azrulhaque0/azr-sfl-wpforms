<?php

if ( ! class_exists( 'SFLintnxt_Plugin_Frontend' ) ) {
    class SFLazr_Plugin_Frontend {
        public static function init() {
            
            if(in_array('wpforms/wpforms.php', apply_filters('active_plugins', get_option('active_plugins')))){
               // return;
            }
            
            /***** ADD CSS, JS, AND BUTTON HTML - azr *****/
          
            add_action('wp_footer', function(){
                $opt_active = get_option('sfl_function_active');
          
                if(is_user_logged_in() && $opt_active){
                        
                	$old_data = get_user_meta(get_current_user_id(), 'wpform_saved_data', true);
                	$old_data = unserialize($old_data); 
                ?>
                	<style>
                	.btn-full{
                		width: 100%;
                		max-width: 250px;
                	}
                	.btn-ring{
                		display: inline-block !important;
                	} 
                	.btn-ring.disable{
                		display: none !important;
                	} 
                	.btn-ring:after {
                	  content: "";
                	  display: block;
                	  width: 15px;
                	  height: 15px;
                	  margin: 0px;
                	  border-radius: 50%;
                	  border: 2px solid #000;
                	  border-color: #000 transparent #000 transparent;
                	  animation: ring 1.2s linear infinite;
                	}
                	@keyframes ring {
                	  0% {
                		transform: rotate(0deg);
                	  }
                	  100% {
                		transform: rotate(360deg);
                	  }
                	}
                	</style>
                	<script>
                		jQuery(document).ready(function( ){
                			let pages = jQuery('.wpforms-field-pagebreak .wpforms-pagebreak-left'); 
                			var total_pages = 0;
                			jQuery.each(pages, function(index, item){ 
                				jQuery(item).append('<button class="wpforms-page-button wpforms-save btn-full" data-action="save" data-page="'+ (index+1) + '" onclick="sfl_savetheform(this);">Save for Later <span class="btn-ring disable"></span></button>');
                				total_pages++;
                			});
                			const singlePercent = 100/total_pages;
                		
                			<?php 
                			    if(isset($old_data) && !empty($old_data)){
                    				foreach($old_data as $data){
                    					if($data['name'] != 'page_number'){
                    						echo 'jQuery(\'[name="'. $data['name'] .'"]\').val(`'.$data['value'].'`);';
                    					}
                    					else{
                    						echo 'activePage = '. $data['value'] .';';
                    					}
                    				}
                			    }else{
                			        echo ' activePage = 1; ';
                			    }
                			?>
                			jQuery('.wpforms-page-indicator-page-progress').css('width', singlePercent * parseInt(activePage)+'%');
                			jQuery('.wpforms-page-indicator-steps-current').html( activePage );
                			jQuery('.wpforms-page').css( 'display','none');
                			jQuery('.wpforms-page[data-page="'+activePage+'"]').css( 'display','block' );
                		});
                		
                		function sfl_savetheform(elem){
                			jQuery(elem).prop('disabled', true);
                			jQuery('.btn-ring').removeClass('disable');
                			let form = jQuery(elem).closest('form');
                			let page = jQuery(elem).data('page');
                			let formData = form.serializeArray(); 
                			formData.push({name:'page_number', value: page});
                			jQuery.ajax({
                				type: "post",
                				dataType: "json",
                				url: wpforms_settings.ajaxurl, //this is wordpress ajax file which is already avaiable in wordpress
                				data: {
                					action:'sfl_save_wpforms_for_later', //this value is first parameter of add_action
                					form_data: formData
                				},
                				success: function(msg){
                					jQuery(elem).prop('disabled', false);
                					jQuery('.btn-ring').addClass('disable');
                					jQuery(elem).html('Form saved successfully!');
                					
                					setTimeout(function(){
                					    jQuery(elem).html('Save for Later');
                					}, 3000);
                					
                					
                					console.log(msg);
                				}
                			});
                		}
                	</script>
                	<?php
                    }
            });
            

            /***** HANDLE SAVE ACTION - azr *****/
            
            add_action('wp_ajax_sfl_save_wpforms_for_later', 'sfl_save_wpforms_for_later'); 

            function sfl_save_wpforms_for_later() {
            	if(!empty($_POST['form_data'])){ 
            		update_usermeta(get_current_user_id(), 'wpform_saved_data', serialize($_POST['form_data'] ));
            		echo json_encode(['status' => true]);
            	} 
            	
            	wp_die();
            } 
            
            
            /**
             * Action that fires when an entry is saved to the database.
             *
             * @link  https://wpforms.com/developers/wpforms_process_entry_save/
             *
             * @param array  $fields    Sanitized entry field. values/properties.
             * @param array  $entry     Original $_POST global.
             * @param int    $form_id   Form ID. 
             * @param array  $form_data Form data and settings.
             */
             
            function delete_saved_data( $fields, $entry, $form_id, $form_data ) {
            	update_usermeta(get_current_user_id(), 'wpform_saved_data', json_encode([])); 
            }
            add_action( 'wpforms_process_entry_save', 'delete_saved_data', 10, 4 );
            
            
            
        }

       
    }

    SFLazr_Plugin_Frontend::init();
}




