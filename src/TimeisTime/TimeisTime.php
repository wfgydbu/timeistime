<?php
   /*
   Plugin Name: Time is Time
   Plugin URI: 
   Description:  Time is time itself, not anything else. Each second is unique and will never come back after it passed, so please take care of each second. By the way, this plugin can be used for action tracking.
   Version: 1.0
   Author: Ethan Huang
   Author URI: http://journal.ethanshub.com
   License: GPL2
   */


//DEFINE

//CSS
wp_register_style( 'TimeStyle', plugins_url('css/TimeStyle.css', __FILE__ ));
wp_enqueue_style('TimeStyle');

wp_register_style( 'gavern-font-awesome', plugins_url('font-awesome/css/font-awesome.min.css', __FILE__ ));
wp_enqueue_style('gavern-font-awesome'); 

// INCLUDES
include('tt_login_form.php');  
include('tt_function_pages.php');
include('tt_report.php');
include('tt_setting.php');

//HOOKS
include_once dirname( __FILE__ ).'/tt_activation.php';
register_activation_hook( __FILE__, array( 'tt_init', 'tt_activate'));
register_deactivation_hook( __FILE__, array( 'tt_init', 'tt_deactivate'));
register_uninstall_hook(__FILE__, array( 'tt_init', 'tt_uninstall'));
?>