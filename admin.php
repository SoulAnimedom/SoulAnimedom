<?php

function GDPlayer_enqueue_color_picker() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'GDPlayer-admin', plugins_url('admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action('load-settings_page_GDPlayer-settings', 'GDPlayer_enqueue_color_picker');

function GDPlayer_menu() {
	global $GDPlayer_admin;
	$GDPlayer_admin = add_options_page('GD Player Free Settings', 'GD Player Free Settings', 'manage_options', 'GDPlayer-settings', 'GDPlayer_settings');
}
add_action('admin_menu', 'GDPlayer_menu');

/* Contextual Help */
function GDPlayer_help($contextual_help, $screen_in, $screen) {
	global $GDPlayer_admin;
	if ($screen_in == $GDPlayer_admin) {
		$contextual_help = <<<_end_
		<strong>GD Player Help</strong>
<p><strong>For more info about GD Player, please visit this Page. <a href="https://ingolin.com/" target="_blank" rel="nofollow noopener">GD Player WordPress Plugin</a></strong></p>
<p><strong>If you need help, please visit our website <a href="https://ingolin.com/support/" target="_blank" rel="nofollow noopener">Click Here</a></strong></p>
<p><strong>For more Shortcodes please visit this page <a href="https://ingolin.com/shortcodes-for-gd-player-wordpress-plugin/" target="_blank" rel="nofollow noopener">Click Here</a></strong></p>
_end_;
	}
	return $contextual_help;
}
add_filter('contextual_help', 'GDPlayer_help', 10, 3);


function GDPlayer_settings() {
    
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
	
<div class="update-nag">
<a href="https://ingolin.com" target="_blank"><img src="<?php echo plugins_url('/GDPlayer.jpg', __FILE__ ) ?>" alt="GD Player " style="width:80px;height:80px; float:left;margin-right: 15px;"></a>
<h3 style="margin: 0 0 8px 0;"><a href="https://ingolin.com" target="_blank">You Are Using GD Player Free</a></h3>
With <strong>GD Player </strong> You Can Play Self-Hosting Videos, MP4, OGG, WebM & Google Drive Videos with <strong>Subtitles</strong>.<strong> GD Player </strong> The Best Video Player WordPres Plugin.
    <p><h2><a href="https://ingolin.com/" target="_blank"><div style="color:red !important;text-align:center;">[Get the Pro version to disable the GD Player ads]</div></a></h2></p>
</div>      

<div class="wrap">
        
<!--	<h2>GD Player Settings</h2>-->
        <h2><span class="dashicons dashicons-admin-generic" style="line-height: inherit;"></span> GD Player Free
        Settings</h2>

	
	<form method="post" action="options.php">

<!--    <form action="" method="post">-->
  <input name="action" type="hidden" value="update">

  <table class="wp-list-table widefat fixed bookmarks">
    <thead>
      <tr>
        <th>
        GD Player Free ( version: 1.2.9 ) <?php 
        
        $options = get_option('GDPlayer_options');
        if($options['GDPlayer_skins'] === 'on') { 
            echo "JW Player Style"; 
        } 
        else {
            echo "Openload Player Style"; 
        }
        ?>
          </th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>
<!--
................
        </td>
      </tr>
    </tbody>
  </table>
</form>
-->

        
	<?php
	settings_fields( 'GDPlayer_options' );
	do_settings_sections( 'GDPlayer-settings' );
	?>
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
    <hr>
<center><h2>Using GD Player Free</h2></center>
	<?php echo file_get_contents(plugin_dir_path( __FILE__ ) . 'help.html'); ?>
        
<!-- CLOSE TABLE-->
        </td>
      </tr>
    </tbody>
  </table>
            
	</form>
</div> <!--	WRAP END-->
	<?php
	
}
add_action('admin_init', 'register_GDPlayer_settings');

function register_GDPlayer_settings() {
	register_setting('GDPlayer_options', 'GDPlayer_options', 'GDPlayer_options_validate');
	add_settings_section('GDPlayer_default', 'Default Settings', 'gdplayer_default_output', 'GDPlayer-settings');
	
	add_settings_field('GDPlayer_width', 'Width', 'gdplayer_gdplayer_gdplayer_width_output', 'GDPlayer-settings', 'GDPlayer_default');
	add_settings_field('GDPlayer_height', 'Height', 'gdplayer_height_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('GDPlayer_preload', 'Preload', 'gdplayer_preload_output', 'GDPlayer-settings', 'GDPlayer_default');
	add_settings_field('GDPlayer_autoplay', 'Autoplay', 'gdplayer_autoplay_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('control_bar_icon_color', 'Control Bar/Buttons/Time & Icon Color', 'control_bar_icon_color_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('control_bar_icon_color_hover', 'Control Bar/Buttons & Icon Color Hover', 'control_bar_icon_color_hover_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('icon_background_color', 'Icon Background Color', 'icon_background_color_output', 'GDPlayer-settings', 'GDPlayer_default');

	add_settings_field('icon_background_color_hover', 'Icon Background Color Hover', 'icon_background_color_hover_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('gdplayer_progress_color', 'Progress Color', 'gdplayer_progress_color_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	
	add_settings_field('gdplayer_control_background_color', 'Control Bar (Background Color)', 'gdplayer_control_background_color_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('GDPlayer_skins', 'Check Box To Enable <h3>JW Player Style</h3> Uncheck To Enable <h3>Openload Player Style</h3> ', 'skins_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('GDPlayer_responsive', 'Check Box To Enable <h3>Responsive Video </h3> Uncheck To Disable.', 'gdplayer_responsive_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('GDPlayer_gdplayer_video_short_codes', 'Check Box To Enable <h3>[GDEmbed] shortcode </h3> Uncheck To Disable. ', 'gdplayer_video_short_codes_output', 'GDPlayer-settings', 'GDPlayer_default');
	
	add_settings_field('GDPlayer_reset', 'Restore Defaults', 'gdplayer_reset_output', 'GDPlayer-settings', 'GDPlayer_default');
}

/* Validate our inputs */

function GDPlayer_options_validate($input) {
	$newinput['GDPlayer_height'] = $input['GDPlayer_height'];
	$newinput['GDPlayer_width'] = $input['GDPlayer_width'];
	$newinput['GDPlayer_preload'] = $input['GDPlayer_preload'];
	$newinput['GDPlayer_autoplay'] = $input['GDPlayer_autoplay'];
	$newinput['GDPlayer_responsive'] = $input['GDPlayer_responsive'];
	$newinput['GDPlayer_skins'] = $input['GDPlayer_skins'];
	$newinput['control_bar_icon_color'] = $input['control_bar_icon_color'];
	$newinput['gdplayer_progress_color'] = $input['gdplayer_progress_color'];
	$newinput['gdplayer_control_background_color'] = $input['gdplayer_control_background_color'];
	
	$newinput['control_bar_icon_color_hover'] = $input['control_bar_icon_color_hover'];
	
	$newinput['icon_background_color'] = $input['icon_background_color'];
	$newinput['icon_background_color_hover'] = $input['icon_background_color_hover'];
	
	$newinput['GDPlayer_reset'] = $input['GDPlayer_reset'];
	$newinput['GDPlayer_gdplayer_video_short_codes'] = $input['GDPlayer_gdplayer_video_short_codes'];
	
	if(!preg_match("/^\d+$/", trim($newinput['GDPlayer_width']))) {
		 $newinput['GDPlayer_width'] = '';
	 }
	 
	 if(!preg_match("/^\d+$/", trim($newinput['GDPlayer_height']))) {
		 $newinput['GDPlayer_height'] = '';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['control_bar_icon_color']))) {
		 $newinput['control_bar_icon_color'] = '#ffffff';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['control_bar_icon_color_hover']))) {
		 $newinput['control_bar_icon_color_hover'] = '#cccccc';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['icon_background_color']))) {
		 $newinput['icon_background_color'] = '#000000';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['icon_background_color_hover']))) {
		 $newinput['icon_background_color_hover'] = '#00aaff';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['gdplayer_progress_color']))) {
		 $newinput['gdplayer_progress_color'] = '#00aaff';
	 }
	 
	 if(!preg_match("/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", trim($newinput['gdplayer_control_background_color']))) {
		 $newinput['gdplayer_control_background_color'] = '#000000';
	 }
	
	return $newinput;
}

/* Display the input fields */

function gdplayer_default_output() { //Layout
	//echo '';
}

function gdplayer_height_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='GDPlayer_height' name='GDPlayer_options[GDPlayer_height]' size='40' type='text' value='{$options['GDPlayer_height']}' />";
}

function gdplayer_gdplayer_gdplayer_width_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='GDPlayer_width' name='GDPlayer_options[GDPlayer_width]' size='40' type='text' value='{$options['GDPlayer_width']}' />";
}

function gdplayer_preload_output() {
	$options = get_option('GDPlayer_options');
	if($options['GDPlayer_preload']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='GDPlayer_preload' name='GDPlayer_options[GDPlayer_preload]' type='checkbox' />";
}

function gdplayer_autoplay_output() {
	$options = get_option('GDPlayer_options');
	if($options['GDPlayer_autoplay']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='GDPlayer_autoplay' name='GDPlayer_options[GDPlayer_autoplay]' type='checkbox' />";
}

function gdplayer_responsive_output() {
	$options = get_option('GDPlayer_options');
	if($options['GDPlayer_responsive']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='GDPlayer_responsive' name='GDPlayer_options[GDPlayer_responsive]' type='checkbox' />";
}

function skins_output() {
	$options = get_option('GDPlayer_options');
	if($options['GDPlayer_skins']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='GDPlayer_skins' name='GDPlayer_options[GDPlayer_skins]' type='checkbox' />";
}

function control_bar_icon_color_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='control_bar_icon_color' name='GDPlayer_options[control_bar_icon_color]' size='40' type='text' value='{$options['control_bar_icon_color']}' data-default-color='#ffffff' class='set_gdplayer_colors' />";
}

function control_bar_icon_color_hover_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='control_bar_icon_color_hover' name='GDPlayer_options[control_bar_icon_color_hover]' size='40' type='text' value='{$options['control_bar_icon_color_hover']}' data-default-color='#cccccc' class='set_gdplayer_colors' />";
}

function icon_background_color_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='icon_background_color' name='GDPlayer_options[icon_background_color]' size='40' type='text' value='{$options['icon_background_color']}' data-default-color='#000000' class='set_gdplayer_colors' />";
}

function icon_background_color_hover_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='icon_background_color_hover' name='GDPlayer_options[icon_background_color_hover]' size='40' type='text' value='{$options['icon_background_color_hover']}' data-default-color='#00aaff' class='set_gdplayer_colors' />";
}

function gdplayer_progress_color_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='gdplayer_progress_color' name='GDPlayer_options[gdplayer_progress_color]' size='40' type='text' value='{$options['gdplayer_progress_color']}' data-default-color='#00aaff' class='set_gdplayer_colors' />";
}

function gdplayer_control_background_color_output() {
	$options = get_option('GDPlayer_options');
	echo "<input id='gdplayer_control_background_color' name='GDPlayer_options[gdplayer_control_background_color]' size='40' type='text' value='{$options['gdplayer_control_background_color']}' data-default-color='#000000' class='set_gdplayer_colors' />";
}

function gdplayer_video_short_codes_output() {
	$options = get_option('GDPlayer_options');
	if(array_key_exists('GDPlayer_gdplayer_video_short_codes', $options)){
		if($options['GDPlayer_gdplayer_video_short_codes']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	} else { $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='GDPlayer_gdplayer_video_short_codes' name='GDPlayer_options[GDPlayer_gdplayer_video_short_codes]' type='checkbox' />";
}

function gdplayer_reset_output() {
	$options = get_option('GDPlayer_options');
	if($options['GDPlayer_reset']) { $checked = ' checked="checked" '; } else { $checked = ''; }
	echo "<input ".$checked." id='GDPlayer_reset' name='GDPlayer_options[GDPlayer_reset]' type='checkbox' />";
}


/* Set Defaults */
register_activation_hook(plugin_dir_path( __FILE__ ) . 'GDPlayer.php', 'add_gdplayer_default_fun');

function add_gdplayer_default_fun() {
	$tmp = get_option('GDPlayer_options');
    if(($tmp['GDPlayer_reset']=='on')||(!is_array($tmp))) {
		$arr = array("GDPlayer_height"=>"420","GDPlayer_width"=>"720","GDPlayer_preload"=>"","GDPlayer_autoplay"=>"","GDPlayer_responsive"=>"on","GDPlayer_skins"=>"on","control_bar_icon_color"=>"","control_bar_icon_color_hover"=>"","icon_background_color"=>"","icon_background_color_hover"=>"","gdplayer_progress_color"=>"","gdplayer_control_background_color"=>"","GDPlayer_gdplayer_video_short_codes"=>"on","GDPlayer_reset"=>"");
		update_option('GDPlayer_options', $arr);
		update_option("GDPlayer_db_version", "1.0");
	}
}


/* Plugin Updater */
function updaters_GDPlayer() {
	$GDPlayer_db_version = "1.0";
	
	if( get_option("GDPlayer_db_version") != $GDPlayer_db_version ) { //We need to update our database options
		$options = get_option('GDPlayer_options');
		
		//Set the new options to their defaults
		$options['control_bar_icon_color'] = "#ffffff";
		$options['control_bar_icon_color_hover'] = "#cccccc";
		$options['icon_background_color'] = "#000000";
		$options['icon_background_color_hover'] = "#00aaff";	
		$options['gdplayer_progress_color'] = "#00aaff";
		$options['gdplayer_control_background_color'] = "#000000";
		$options['GDPlayer_gdplayer_video_short_codes'] = "on";
		
		update_option('GDPlayer_options', $options);
		
		update_option("GDPlayer_db_version", $GDPlayer_db_version); //Update the database version setting
	}
}
add_action('admin_init', 'updaters_GDPlayer');
?>