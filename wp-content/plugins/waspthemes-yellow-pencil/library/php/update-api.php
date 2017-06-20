<?php
/*
    Yellow Pencil Auto Update API
*/

// General.
define("YP_TIMEOUT", 86400); // 1 DAY = 86400

// User information
define("YP_PURCHASE_CODE",get_option('yp_purchase_code'));

// Basic
function yp_get_plugin($plugin){

    $args = array(
        'path' => ABSPATH.'wp-content/plugins/'
    );

    $plugin = $plugin[0];

    if(!yp_plugin_download($plugin['path'], $args['path'].$plugin['name'].'.zip')){
        return false;
    }

    yp_plugin_unpack($args, $args['path'].$plugin['name'].'.zip');
    yp_plugin_activate($plugin['install']);

    return true;

}

// Response code
function yp_get_http_response_code($url){

    if( ini_get('allow_url_fopen') ) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }else{
        return null;
    }

}

// Getting version
function yp_getting_ver_from_changelog(){

    $version = 0;
    $pluginVersion = YP_PLUGIN_VERSION;

    // Changelog URL
    $url = "http://www.waspthemes.com/yellow-pencil/inc/changelog.txt";

    // If page found.
    if(yp_get_http_response_code($url) == 200){

        // Getting Changelog
        $changelog = wp_remote_get($url, array( 'sslverify' => false ));
                
        if(is_array($changelog)){
            $changelog = $changelog['body'];
        }
        
        // If have data.
        if(!empty($changelog)){

            // Get First line.
            $last_update = substr($changelog, 0, 32);

            // Part of first line.
            $array = explode('(',$last_update);

            // Only version.
            $version = yp_version($array['0']);

            if($version > $pluginVersion){
                            
                // Add to datebase, because have a new update.
                if(get_option('yp_update_status') !== false ){
                    update_option( 'yp_update_status', 'true');
                    update_option( 'yp_last_check_version', $pluginVersion);
                    update_option( 'yp_available_version', $version);
                }else{
                    add_option( 'yp_update_status', 'true');
                    add_option( 'yp_last_check_version', $pluginVersion);
                    add_option( 'yp_available_version', $version);
                }
                
                    return true;
                            
            }else{
                            
                // Update database, because not have a new update.
                if(get_option('yp_update_status') !== false ){
                    update_option( 'yp_update_status', 'false');
                }else{
                    add_option( 'yp_update_status', 'false');
                }
                
                return false;
                
            }
                
        } // If has data.
                
    } // IF URL working.

}

// Check everyday for update
function yp_update_checker(){

    // Update available just for pro users.
    if(defined('WTFV')){
    
        $timeStamp = current_time('timestamp', 1 );
        if(get_option('yp_checked_data') !== false ){

            if(($timeStamp-get_option('yp_checked_data')) > YP_TIMEOUT){ // 1 day. 86400

                yp_getting_ver_from_changelog();
                
                update_option( 'yp_checked_data', $timeStamp);
                
            }
        
        }else{
            
            // First Check
            yp_getting_ver_from_changelog();
            
            add_option( 'yp_checked_data', $timeStamp);
            
        }

    }
    
}

add_action('admin_init','yp_update_checker',9999);


// Getting plugin download uri from envato
function yp_get_plugin_patch(){

    // Checks download uri
    $download_uri = 'http://waspthemes.com/yellow-pencil/auto-update/download.php?purchase_code='.YP_PURCHASE_CODE;

    // Getting plugin download url
    $data = yp_remote_request($download_uri);

    if($data == ''){
        die('Unknown error');
    }
    
    // Data is the download URL
    return $data;

}

// File download func.
function yp_remote_request( $url ) {
    
      if ( empty( $url ) ) {
        return false;
      }

    $args = array(
        'headers'    => array( 'Accept-Encoding' => '' ), 
        'timeout'    => 300000,
        'user-agent' => 'Yellow Pencil Updater',
    );

    $request = wp_safe_remote_request( $url, $args );

    if (is_wp_error($request)){
        return json_decode($request['body'],true);
    }
      
    if ( $request['response']['code'] == 200 ) {
        return $request['body'];
    }

    return false;

}

// Downloading plugin zip file.
function yp_plugin_download($url, $path){

    $data = yp_remote_request($url);

    if(file_put_contents($path, $data)){
        return true;
    }else{
        return false;
    }

}

// Unpack zip file.
function yp_plugin_unpack($args, $target){

    if($zip = zip_open($target)){

        while($entry = zip_read($zip)){

            $is_file = substr(zip_entry_name($entry), -1) == '/' ? false : true;
            $file_path = $args['path'].zip_entry_name($entry);
            if($is_file){

                if(zip_entry_open($zip,$entry,"r")){
                    $fstream = zip_entry_read($entry, zip_entry_filesize($entry));
                    file_put_contents($file_path, $fstream );
                    chmod($file_path, 0644);
                }

                zip_entry_close($entry);
        
            }else{

                if(zip_entry_name($entry)){
                    if (!file_exists($file_path)){
                        mkdir($file_path, 0755);
                    }
                }

            }

        }

        zip_close($zip);

    }

    // delete zip file.
    unlink($target);

}

// Active new version.
function yp_plugin_activate($installer){

    $current = get_option('active_plugins');
    $plugin = plugin_basename(trim($installer));

    if(!in_array($plugin, $current)){
        $current[] = $plugin;
        sort($current);
        do_action('activate_plugin', trim($plugin));
        update_option('active_plugins', $current);
        do_action('activate_'.trim($plugin));
        do_action('activated_plugin', trim($plugin));
        return true;
    }else{
        return false;
    }

}

// show update message.
function yp_update_message(){

    // Update available just for pro users.
    if(defined('WTFV')){

        // get screen
        $screen = get_current_screen();
        $base = $screen->base;

        $lastCheckVer = get_option('yp_last_check_version');
        $isUpdate = get_option('yp_update_status');
        $available = get_option('yp_available_version');

        if($isUpdate != 'true' && current_user_can("update_plugins") == true && YP_PURCHASE_CODE == '' && strstr($base,"yellow-pencil") == false){
            ?>
            <div class="updated yp-update-info-bar">
                <p><?php _e("Hola! Would you like to receive automatic updates? Please <a style='box-shadow:none !important;-webkit-box-shadow:none !important;-moz-box-shadow:none !important;' href='".admin_url('admin.php?page=yellow-pencil-license')."'>activate your copy</a> of Yellow Pencil.","yp"); ?></p>
            </div>
        <?php
        }
        
        if($isUpdate == 'true' && $lastCheckVer == YP_PLUGIN_VERSION && $available > YP_PLUGIN_VERSION && current_user_can("update_plugins") == true && YP_PURCHASE_CODE != ''){
            
            ?>
            <div class="updated yp-update-info-bar">
                <p><strong><?php _e("A new update available for Yellow Pencil,","yp"); ?> <a style="box-shadow:none !important;-webkit-box-shadow:none !important;-moz-box-shadow:none !important;" href="#" class="yp_update_link"><?php _e("Update now!","yp"); ?></a></strong></p>
            </div>
            <?php
                
        }elseif($isUpdate == 'true' && $lastCheckVer == YP_PLUGIN_VERSION && $available > YP_PLUGIN_VERSION && current_user_can("update_plugins") == true && strstr($base,"yellow-pencil") == false){

            ?>
            <div class="updated yp-update-info-bar">
                <p><strong><?php _e("New updates are available for Yellow Pencil! Please activate your copy to receive automatic updates.","yp"); ?> <a style="box-shadow:none !important;-webkit-box-shadow:none !important;-moz-box-shadow:none !important;" href="<?php echo admin_url('admin.php?page=yellow-pencil-license'); ?>"><?php _e("Activate now!","yp"); ?></a></strong></p>
            </div>
            <?php

        }

    }

}

// Begin to update.
function yp_update_now(){

    $lastCheckVer = get_option('yp_last_check_version');
    $isUpdate = get_option('yp_update_status');
    $available = get_option('yp_available_version');
    
    if($isUpdate == 'true' && $lastCheckVer == YP_PLUGIN_VERSION && $available > YP_PLUGIN_VERSION && current_user_can("update_plugins") == true && YP_PURCHASE_CODE != ''){
        
        // Getting the path.
        $path = yp_get_plugin_patch();

        // Update.
        $re = yp_get_plugin(array(
            array('name' => 'yellow_pencil_update_pack', 'path' => $path, 'install' => 'waspthemes-yellow-pencil/yellow-pencil.php'),
        ));

        if(!$re){
            die('Server doesn\'t support automatic updates. Please update manually.');
        }
        
    }

    die("The Plugin Updated.");

}


// Begin to upgrade!
function yp_upgrade_now(){

    // Upgrade to Pro Version if is lite version.
    if(defined('WTFV') == false){

        // Getting the path.
        $path = yp_get_plugin_patch();

        // Update to PRO
        $re = yp_get_plugin(array(
            array('name' => 'yellow_pencil_update_pack', 'path' => $path, 'install' => 'waspthemes-yellow-pencil/yellow-pencil.php'),
        ));

        if(!$re){
            die('Server doesn\'t support automatic updates. Please update manually.');
        }

        // Delete lite plugin
        delete_plugins(array('/yellow-pencil-visual-theme-customizer/yellow-pencil.php'));

    }

    die("Yellow Pencil Activated");

}

// Ajax action.
add_action( 'wp_ajax_yp_upgrade_now', 'yp_upgrade_now' );


// Update javascript
function yp_update_javascript() { ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {

        jQuery(".yp_update_link").click(function(){

            // Only one click.
            if(!jQuery(this).hasClass("yp_update_link_disable")){

                // Updating.
                jQuery(this).text("Updating..").css("color","inherit").addClass("yp_update_link_disable");

                jQuery(this).append("<img src='<?php echo esc_url(plugins_url( '/images/wpspin_light.gif' , dirname(dirname(__FILE__)) )); ?>' style='position: relative;left: 7px;top: 2px;width: 12px;height: 12px;' />");

                var data = {
                    'action': 'yp_update_now'
                };

                jQuery.post(ajaxurl,data, function(response) {
                    jQuery(".yp-update-info-bar").html("<p>"+response+"</p>");
                });

            }

        });


        // Disable activation btn
        jQuery(".yp-product-activation").on("click",function(){
            jQuery(this).addClass("disabled");
        });


        // Trigger and send upgrade ajax if the current page is in upgrading.
        if(jQuery(".yp-upgrade-pro-action").length > 0){

            var data = {
                'action': 'yp_upgrade_now'
            };

            jQuery.post(ajaxurl,data, function(response) {

                // Resualt: Yellow Pencil Activated or error.
                jQuery(".yp-upgrade-pro-action").html(response);

                // Remove upgrade loading icon
                jQuery(".yp-upgrading-loading").remove();

                // remove .yp-upgrade-pro-action
                jQuery(".yp-upgrade-pro-action").removeClass("yp-upgrade-pro-action");

                // update desc
                jQuery(".yp-activation-section .description").html("Yellow Pencil Pro Successfully installed. <a href='<?php echo admin_url('admin.php?page=yp-welcome-screen'); ?>'>Let's Start</a>");

            });



        }


    });
    </script><?php
}

// Admin update script
add_action( 'admin_footer', 'yp_update_javascript' );

// Alert update
add_action( 'admin_notices', 'yp_update_message' );

// Ajax action.
add_action( 'wp_ajax_yp_update_now', 'yp_update_now' );