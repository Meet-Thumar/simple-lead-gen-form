<?php
/*
Plugin Name: Simple Lead Gen Form
Description: Simple User managment System
Version: 1.0
Text Domain: simple-lead-gen-form
Domain Path: /languages
*/

if( !defined( 'SIMPLE_LEAD_DIR_NAME') ){
    define('SIMPLE_LEAD_DIR_NAME', dirname(plugin_basename(__FILE__)));
}
if( !defined( 'SIMPLE_LEAD_GEN_FORM_DIR' ) ){
    define('SIMPLE_LEAD_GEN_FORM_DIR',WP_PLUGIN_DIR.'/'.SIMPLE_LEAD_DIR_NAME);
}
if( !defined( 'SIMPLE_LEAD_GEN_FORM_URL' ) ){
    define('SIMPLE_LEAD_GEN_FORM_URL',WP_PLUGIN_URL.'/'.SIMPLE_LEAD_DIR_NAME);
}
if( !defined( 'SIMPLE_LEAD_GEN_FORM_CORE' ) ){
    define('SIMPLE_LEAD_GEN_FORM_CORE',SIMPLE_LEAD_GEN_FORM_DIR.'/core');
}
if( !defined( 'SIMPLE_LEAD_GEN_CSS' ) ){
    define('SIMPLE_LEAD_GEN_CSS',SIMPLE_LEAD_GEN_FORM_URL.'/css');
}
if( !defined( 'SIMPLE_LEAD_GEN_JS' ) ){
    define('SIMPLE_LEAD_GEN_JS',SIMPLE_LEAD_GEN_FORM_URL.'/js');
}

global $simple_lead_gen_form_version;
$simple_lead_gen_form_version = '1.0';

if ( file_exists( SIMPLE_LEAD_GEN_FORM_CORE . '/class.simple-lead-gen-form.php' ) ) { 
    require_once SIMPLE_LEAD_GEN_FORM_CORE . '/class.simple-lead-gen-form.php';
}

add_action('plugins_loaded', 'simple_lead_gen_load_textdomain');
/**
 * Loading plugin text domain
 */
function simple_lead_gen_load_textdomain()
{
    load_plugin_textdomain('simple-lead-gen-form', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}