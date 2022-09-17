<?php
/**
Plugin Name: GD Player For Google Drive Videos By: Video JS 
Plugin URI: https://ingolin.com/gd-player-self-hosting-mp4-google-drive-videos-wordpress-plugin/
Description: GD Player Allows You To Play And Embed Videos With Subtitles, Google Drive Videos, Self-Hosted, MP4, OGG, WebM And YouTube. In Your Post Or Page Using Shortcodes. Skins-Two Types Of Player Style You Can Choose Openload Player Style Or JWPlayer Style (Skin) With GD Player You Can Set All Players Colors. GD Player By: inGolin.com
Version: 1.2.9
Author: inGolin.com
Author URI: https://ingolin.com
Text Domain: gd-player
Domain Path: languages
*/
if (!defined('ABSPATH')) {
    exit;
}

$plugin_dir = plugin_dir_path( __FILE__ );

/* The options page */
include_once($plugin_dir . 'admin.php');

/* Useful Functions */
include_once($plugin_dir . 'lib.php');

/* Google Drive */
include_once($plugin_dir . 'google-drive-api.php');

/* Register the scripts and enqueue css files */
function register_GDPlayer(){
	$options = get_option('GDPlayer_options');
	
	if($options['GDPlayer_skins'] == 'on') { //use the JW Player version
		wp_register_script( 'GDPlayer', plugins_url( 'GDPlayer/video.min.js' , __FILE__ ) );
		wp_register_script( 'GDPlayer-ie8', plugins_url( 'GDPlayer/ie8/videojs-ie8.min.js' , __FILE__ ) );		
		wp_register_style( 'GDPlayer', plugins_url( 'GDPlayer/video-js.css' , __FILE__ ) );
		wp_enqueue_style( 'GDPlayer' );
		wp_register_style( 'GDPlayer-jwplayer', plugins_url( 'skins/jwplayer.css' , __FILE__ ) );
		wp_enqueue_style( 'GDPlayer-jwplayer' );
	} else { //use the Openload version
		wp_register_script( 'GDPlayer', plugins_url( 'GDPlayer/video.min.js' , __FILE__ ) );
		wp_register_script( 'GDPlayer-ie8', plugins_url( 'GDPlayer/ie8/videojs-ie8.min.js' , __FILE__ ) );		
		wp_register_style( 'GDPlayer', plugins_url( 'GDPlayer/video-js.css' , __FILE__ ) );
		wp_enqueue_style( 'GDPlayer' );
		wp_register_style( 'GDPlayer-openload', plugins_url( 'skins/openload.css' , __FILE__ ) );
		wp_enqueue_style( 'GDPlayer-openload' );
		
	}
	
wp_register_script( 'GDPlayer-youtube', plugins_url( 'GDPlayer/vjs.youtube.min.js' , __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'register_GDPlayer' );

/* Include the scripts before </body> */
function add_GDPlayer_header(){
	wp_enqueue_script( 'GDPlayer' );
	wp_enqueue_script( 'GDPlayer-youtube' );
}

/* Include custom color styles in the site header */
function GDPlayer_custom_colors() {
	$options = get_option('GDPlayer_options');
	
	if($options['control_bar_icon_color'] != "#ffffff" || $options['control_bar_icon_color_hover'] != "#cccccc" || $options['icon_background_color'] != "#000000" || $options['icon_background_color_hover'] != "#00aaff" || $options['gdplayer_progress_color'] != "#00aaff" || $options['gdplayer_control_background_color'] != "#000000") { //If custom colors are used
		$color3 = vjs_GDplayerRGB($options['gdplayer_control_background_color'], true); //Background color is rgba
		$color4 = vjs_GDplayerRGB($options['icon_background_color'], true); //Background color is rgba
		echo "
	<style type='text/css'>
  .video-js .vjs-control-bar,
  .video-js .vjs-progress-holder .vjs-play-progress,
  .video-js .vjs-big-play-button,
  .video-js .vjs-menu-button-popup,
  .video-js .vjs-progress-holder .vjs-load-progress div,
  .video-js .vjs-fullscreen-control .vjs-icon-placeholder,
  .video-js .vjs-subs-caps-button .vjs-icon-placeholder,
  .video-js .vjs-mute-control .vjs-icon-placeholder,
  .video-js .vjs-play-control .vjs-icon-placeholder { color: " . $options['control_bar_icon_color'] . " }
    .video-js .vjs-volume-panel .vjs-volume-control.vjs-volume-horizontal { color: " . $options['control_bar_icon_color'] . "!important }
  .video-js .vjs-big-play-button  { box-shadow:0 0 10px " . $options['control_bar_icon_color'] . " }
  
  .video-js .vjs-progress-holder .vjs-play-progress:hover,
  .video-js .vjs-big-play-button:hover,
  .video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-item.vjs-selected,
  .video-js .vjs-progress-holder .vjs-load-progress div:hover,
  .video-js .vjs-fullscreen-control .vjs-icon-placeholder:hover,
  .video-js .vjs-subs-caps-button .vjs-icon-placeholder:hover,
  .video-js .vjs-mute-control .vjs-icon-placeholder:hover,
  .video-js .vjs-play-control .vjs-icon-placeholder:hover { color: " . $options['control_bar_icon_color_hover'] . " }
  .video-js .vjs-volume-panel:hover .vjs-volume-control.vjs-volume-horizontal { color: " . $options['control_bar_icon_color_hover'] . "!important }
  .video-js .vjs-big-play-button:hover { box-shadow:0 0 10px " . $options['control_bar_icon_color_hover'] . " }
  
  .video-js .vjs-big-play-button { background: rgba(" . $color4 . ",0.7) }
.video-js:hover .vjs-big-play-button, .video-js .vjs-big-play-button:focus, .video-js .vjs-big-play-button:active { background-color: " . $options['icon_background_color_hover'] . " }
		
  .video-js .vjs-play-progress, .video-js .vjs-volume-level { background-color: " . $options['gdplayer_progress_color'] . " }
  .video-js .vjs-progress-holder .vjs-play-progress,
  .video-js .vjs-progress-holder .vjs-load-progress,
  .video-js .vjs-progress-holder .vjs-tooltip-progress-bar,
  .vjs-volume-bar.vjs-slider-horizontal .vjs-volume-level
  { background-color: " . $options['gdplayer_progress_color'] . " }
  .video-js .vjs-volume-panel .vjs-volume-control.vjs-volume-horizontal { color: " . $options['gdplayer_progress_color'] . " }
		
  .video-js .vjs-control-bar { background: rgba(" . $color3 . ",0.5) }
  .video-js .vjs-slider { background: rgba(" . $color3 . ",0.2333333333333333) }
	</style>
		";
	}
}
add_action( 'wp_head', 'GDPlayer_custom_colors' );


/* Prevent mixed content warnings for the self-hosted version */
function add_GDPlayer_swf(){
	$options = get_option('GDPlayer_options');
	if($options['GDPlayer_skins'] != 'on') {
		echo '
		<script type="text/javascript">
			if(typeof GDPlayer != "undefined") {
				GDPlayer.options.flash.swf = "'. plugins_url( 'GDPlayer/video-js.swf' , __FILE__ ) .'";
			}
			document.createElement("video");document.createElement("audio");document.createElement("track");
		</script>
		';
	} else {
		echo '
		<script type="text/javascript"> document.createElement("video");document.createElement("audio");document.createElement("track"); </script>
		';
	}
}
add_action('wp_head','add_GDPlayer_swf');

/* The [GDEmbed] or [GDPlayer] shortcode */
function gdplayer_video_short_codes($atts, $content=null){
	add_GDPlayer_header();
	
	$options = get_option('GDPlayer_options'); //load the defaults
	
	extract(shortcode_atts(array(
		'gdrive' => '',
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
        'flv' => '',
		'youtube' => '',
		'poster' => '',
		'width' => $options['GDPlayer_width'],
		'height' => $options['GDPlayer_height'],
		'preload' => $options['GDPlayer_preload'],
		'autoplay' => $options['GDPlayer_autoplay'],
		'loop' => '',
		'controls' => '',
		'id' => '',
		'class' => '',
		'muted' => ''
	), $atts));

	$dataSetup = array();
	
	// ID is required for multiple videos to work
	if ($id == '')
		$id = 'GDPlayer_id_'.rand();

	// Google Drive Source Supplied
	if ($gdrive) 
	$url = $gdrive;
	$gid = get_drive_id($url);
	$backup = 'https://drive.google.com/file/d/'.$gid.'/preview';
	$linkdown = Drive($url);
	$file = '[{"type": "video/mp4", "label": "HD", "file": "'.$linkdown.'"}]';
	
    $gdrive_source = '<source src="'.$linkdown.'" type=\'video/mp4\' />';
    
	// MP4 Source Supplied
	if ($mp4)
		$mp4_source = '<source src="'.$mp4.'" type=\'video/mp4\' />';
	else
		$mp4_source = '';

	// WebM Source Supplied
	if ($webm)
		$webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';
	else
		$webm_source = '';

	// Ogg source supplied
	if ($ogg)
		$ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';
	else
		$ogg_source = '';
  
	if ($flv)
		$flv_source = '<source src="'.$flv.'" type=\'video/flv\' />';
	else
		$flv_source = '';
		
	if ($youtube) {
		//$dataSetup['forceSSL'] = 'true';
		$dataSetup['techOrder'] = array("youtube");
		$dataSetup['sources'] = array(array(
        "type" => "video/youtube",
        "src" => $youtube
        ));
        $dataSetup['youtube'] = array(
        "iv_load_policy" => 3
        );
	}
	// Poster image supplied
	if ($poster)
		$poster_attribute = ' poster="'.$poster.'"';
	else
		$poster_attribute = '';
	
	// Preload the video?
	if ($preload == "auto" || $preload == "true" || $preload == "on")
		$preload_attribute = ' preload="auto"';
	elseif ($preload == "metadata")
		$preload_attribute = ' preload="metadata"';
	else 
		$preload_attribute = ' preload="none"';

	// Autoplay the video?
	if ($autoplay == "true" || $autoplay == "on")
		$autoplay_attribute = " autoplay";
	else
		$autoplay_attribute = "";
	
	// Loop the video?
	if ($loop == "true")
		$loop_attribute = " loop";
	else
		$loop_attribute = "";
	
	// Controls?
	if ($controls == "false")
		$controls_attribute = "";
	else
		$controls_attribute = " controls";
	
	// Is there a custom class?
	if ($class)
		$class = ' ' . $class;
	
	// Muted?
	if ($muted == "true")
		$muted_attribute = " muted";
	else
		$muted_attribute = "";
	
	// Tracks
	if(!is_null( $content ))
		$track = do_shortcode($content);
	else
		$track = "";
    
    // Responsive Fluid
    if($options['GDPlayer_responsive'] == 'on')  //add the responsive css	
		$fluid = " vjs-fluid";
    	else
		$fluid = "";


	$jsonDataSetup = str_replace('\\/', '/', json_encode($dataSetup));

	//Output the <video> tag
	$GDPlayer = <<<_end_

	<!-- Begin Video.js -->
	<video id="{$id}" class="video-js vjs-default-skin vjs-16-9 vjs-big-play-centered{$class}{$fluid}" width="{$width}" height="{$height}"{$poster_attribute}{$controls_attribute}{$preload_attribute}{$autoplay_attribute}{$loop_attribute}{$muted_attribute} data-setup='{$jsonDataSetup}'>
		{$gdrive_source}
		{$mp4_source}
		{$webm_source}
        {$flv_source}
		{$ogg_source}
		{$track}
		
<script> jQuery(document).ready(function(){
    jQuery('video').bind('contextmenu',function() { return false; });
});
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-102047419-8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-102047419-8');
</script>

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//ingolin.com/gd-player/rekla-wp-plugin.js"></script>

<style>.video-js.vjs-default-skin.vjs-paused .vjs-big-play-button {display:block !important;</style>

	</video>
	<!-- End Video.js -->
_end_;
	
	return $GDPlayer;

}
add_shortcode('GDPlayer', 'gdplayer_video_short_codes');
//Only use the [GDEmbed] shortcode if the correct option is set
$options = get_option('GDPlayer_options');
if( !array_key_exists('GDPlayer_gdplayer_video_short_codes', $options) || $options['GDPlayer_gdplayer_video_short_codes'] ){
	add_shortcode('GDEmbed', 'gdplayer_video_short_codes');
}


/* The [track] shortcode */
function gdplayer_track_shortcodes($atts, $content=null){
	extract(shortcode_atts(array(
		'kind' => '',
		'src' => '',
		'srclang' => '',
		'label' => '',
		'default' => ''
	), $atts));
	
	if($kind)
		$kind = " kind='" . $kind . "'";
	
	if($src)
		$src = " src='" . $src . "'";
	
	if($srclang)
		$srclang = " srclang='" . $srclang . "'";
	
	if($label)
		$label = " label='" . $label . "'";
	
	if($default == "true" || $default == "default")
		$default = " default";
	else
		$default = "";
	
	$track = "
		<track" . $kind . $src . $srclang . $label . $default . " />
	";
	
	return $track;
}
add_shortcode('track', 'gdplayer_track_shortcodes');


/* TinyMCE Shortcode Generator */
function gdplayer_video_js_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter('mce_external_plugins', 'gdplayer_video_js_mce_plugin');
		add_filter('mce_buttons', 'register_gdplayer_video_js_button');
	}
}
add_action('init', 'gdplayer_video_js_button');

function register_gdplayer_video_js_button($buttons) {
	array_push($buttons, "|", "GDPlayer");
	$options = get_option('GDPlayer_options');
	echo('<div style="display:none"><input type="hidden" id="GDPlayer-autoplay-default" value="' . $options['GDPlayer_autoplay'] . '"><input type="hidden" id="GDPlayer-preload-default" value="' . $options['GDPlayer_preload'] . '"></div>'); //the default values from the admin screen, to be used by our javascript
	return $buttons;
}

function gdplayer_video_js_mce_plugin($plugin_array) {
	$plugin_array['GDPlayer'] = plugins_url( 'mce-button.js' , __FILE__ );
	return $plugin_array;
}
?>