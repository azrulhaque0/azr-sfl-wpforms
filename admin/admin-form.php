<!--------
TOGGLE SWITCH FORM - AZR
---------->

<div class="wrap">
        <h1 style="margin-bottom:50px"><?php echo esc_html( get_admin_page_title() ); ?> Settings</h1>
        <form action="" method="post">
            <label><b>ON / OFF :</b></label>
            <label class="switch">
              <input type="checkbox" id="sfl_setting_checkbox">
              <span class="slider"></span>
            </label>
            <span style="display:none" id="successmsg">Setting Changed Successfully !</span>
        </form>
        <?php
            $opt = get_option('sfl_function_active');
            if($opt == 1){
                echo "<script>jQuery('#sfl_setting_checkbox').prop('checked', true);</script>";
            }
        ?>
        
</div>