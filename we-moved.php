<?php 

/*
Plugin Name: We Moved
Plugin URI: http://aramzs.me
Description: This plugin will display an alert window, informing users of the move, and then redirect them in a user specified amount of time. 
Version: 0.1
Author: Aram Zucker-Scharff
Author URI: http://aramzs.me
License: GPL2
*/

/*  Copyright 2012  Aram Zucker-Scharff  (email : azuckers@gmu.edu)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function zs_wm_place_reveal_script(){
	if (get_option('we_moved_time_setting', 0) > 0){
		//Here we say that we want WordPress to load jQuery
		wp_enqueue_script('jquery');
		//And here we tell it to load our custom javascript file as well. 
		//But the final parameter tells WordPress that our script is dependent on jQuery, 
		//so it should load that first.
		wp_enqueue_script('reveal', plugins_url('reveal/jquery.reveal.js', __FILE__), array('jquery'));
		wp_enqueue_style( 'reveal-style', plugins_url('reveal/reveal.css', __FILE__) );
		wp_enqueue_script('reveal-imp', plugins_url('reveal-imp.js', __FILE__), array('reveal','jquery'));
	}
}
add_action('wp_enqueue_scripts', 'zs_wm_place_reveal_script');

function zs_wm_forward_onto_new_site(){
	if (!is_admin()){
		$link = get_option('we_moved_link_setting', '#');
		$wait = get_option('we_moved_time_setting', 0);
		$msg = get_option('we_moved_msg_setting', 'You are being redirected to a new site.');
		if ($wait > 0){
			echo '<META HTTP-EQUIV="refresh" CONTENT="'.$wait.';URL='.$link.'">';
			?><script type="text/javascript"><?php
				echo 'var zs_wm_msg = "'.$msg.'"; ';
			?></script><?php
		}
	}
}
add_action('wp_head', 'zs_wm_forward_onto_new_site');

function zs_wm_site_option_set(){
 	add_settings_section('we_moved_setting_section',
		'Settings for redirecting to a new site',
		'zs_wm_setting_section_callback_function',
		'reading');
		
 	add_settings_field('we_moved_link_setting',
		'We Moved: Redirect link',
		'zs_wm_link_setting_callback_function',
		'reading',
		'we_moved_setting_section');
		
	register_setting('reading','we_moved_link_setting');
	
 	add_settings_field('we_moved_time_setting',
		'We Moved: Time to redirect',
		'zs_wm_time_setting_callback_function',
		'reading',
		'we_moved_setting_section');	
	
	register_setting('reading','we_moved_time_setting');
	
 	add_settings_field('we_moved_msg_setting',
		'We Moved: Message to display',
		'zs_wm_msg_setting_callback_function',
		'reading',
		'we_moved_setting_section');	
	
	register_setting('reading','we_moved_msg_setting');	
}

add_action('admin_init', 'zs_wm_site_option_set');

function zs_wm_setting_section_callback_function() {
	echo '<p>Set the options here to redirect users to your new site.</p>';
}

function zs_wm_link_setting_callback_function(){
	$default_zs_wm_link_value = get_option('we_moved_link_setting', ''); 
	echo '<input id="we_moved_link_setting" name="we_moved_link_setting" type="url" class="we_moved_link_setting_class" value="'.$default_zs_wm_link_value.'" />';
	echo '<label class="description" for="we_moved_link_setting"> ' .__('URL (must start with http://) to redirect users towards.', 'zs_wm'). ' </label>'; 
}

function zs_wm_time_setting_callback_function(){
	$default_zs_wm_time_value = get_option('we_moved_time_setting', 0); 
	echo '<input id="we_moved_time_setting" name="we_moved_time_setting" type="number" class="we_moved_time_setting_class" value="'.$default_zs_wm_time_value.'" size="100" />';
	echo '<label class="description" for="we_moved_time_setting"> ' .__('Seconds to redirect user to source. (0 means no redirect)', 'zs_wm'). ' </label>'; 
}

function zs_wm_msg_setting_callback_function(){
	$default_zs_wm_msg_value = get_option('we_moved_msg_setting', 'You are being redirected to a new site.'); 
	echo '<input id="we_moved_msg_setting" name="we_moved_msg_setting" type="text" class="we_moved_msg_setting_class" value="'.$default_zs_wm_msg_value.'" size="100" />';
	echo '<label class="description" for="we_moved_msg_setting"> ' .__('Message to display before redirect.', 'zs_wm'). ' </label>'; 
}
