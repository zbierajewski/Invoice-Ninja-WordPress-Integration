<?php
/**
 * @package ZB_TECH_GROUP_SERVICES_BILLING_MODULE
 * @version 1
 */
/*
Plugin Name: Mr. Services and Billing
Plugin URI: https://www.zbtechgroup.com/mr-support-module/
Description: Services and billing for Zbierajewski Group customers.
Author: Anthony Zbierajewski
Version: 1
Author URI: http://zbtechgroup.com
*/

define('BILLING_DB_NAME', 'your_invoiceninja_database_name');

/** MySQL database username */
define('BILLING_DB_USER', 'your_invoiceninja_database_username');

/** MySQL database password */
define('BILLING_DB_PASSWORD', 'your_invoiceninja_database_password');

/** MySQL hostname */
define('BILLING_DB_HOST', 'your_invoiceninja_database_hostname');


$directory = '/complete/path/to/text/files';
function zb_billing_func( $atts ){
    $current_user = wp_get_current_user();
    $mysqli = new mysqli( BILLING_DB_HOST, BILLING_DB_USER, BILLING_DB_PASSWORD, BILLING_DB_NAME );
    $stmt = $mysqli -> prepare('SELECT contact_key FROM contacts WHERE email = ?');
    $stmt -> bind_param('s', $current_user->user_email);
    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result($contact_key);
    $stmt -> fetch();
    return '<a href="https://billing.yourdomain.com/public/client/dashboard/' . $contact_key . '">Click here to view your bill.</a>';
}
function zb_services_func( $atts ){
    $current_user = wp_get_current_user();
    $mysqli = new mysqli( BILLING_DB_HOST, BILLING_DB_USER, BILLING_DB_PASSWORD, SERVICES_DB_NAME );
    $stmt = $mysqli -> prepare('SELECT services FROM services WHERE client_id = ?');
    $stmt -> bind_param('i', get_current_user_id());
    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result($services);
    $stmt -> fetch();
    return $services . get_current_user_id();

}
add_shortcode( 'zb_services', 'zb_services_func' );
add_shortcode( 'zb_billing', 'zb_billing_func' );