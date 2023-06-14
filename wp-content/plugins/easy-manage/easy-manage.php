<?php

/**
 * @package easymanage
 */

/**
 *Plugin Name: EasyManage plugin
 Plugin URI: http://...	
 Description: This is a plugin built to help mange different users of a training management system
 version: 1.0.0
 Author: Hope Murithi
 Author URI: https://hope-murithi.netlify.app/
 */

//security check
if (!defined('ABSPATH')) {
    die;
}


//check if composer is installed
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once(dirname(__FILE__) . '/vendor/autoload.php');
}


use Inc\Base;
use  Inc\Init;

//activate plugin
function activate_easymanage_plugin()
{
   Base\Activate::activate();
}

//deactivate plugin
function deactivate_easymanage_plugin()
{
    Base\Deactivate::deactivate();
}

register_activation_hook(__FILE__, 'activate_easymanage_plugin');

register_deactivation_hook(__FILE__, 'deactivate_easymanage_plugin');

// to add the plugin services

if (class_exists('Inc\\Init')) {
    Init::register_services();
}