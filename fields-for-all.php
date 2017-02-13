<?php
/**
 * @package Fields_For_All
 * @version 1.0
 */
/*
Plugin Name: Fields For All
Plugin URI: http://wordpress.org/plugins/fields-for-all/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Eugen Bobrowski
Version: 1.0
Author URI: http://atf.li
*/

/**
 * ATF Options
 */
include_once 'options/options.php';

/**
 * Woocommerce tabs
 */

if (is_admin() && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && (!defined('DOING_AJAX') || !DOING_AJAX)) {
    include_once 'woo-tabs/woo-tabs.php';
    add_action('plugins_loaded', array('Woo_Product_Data_Fields', 'get_instance'));
}

/**
 * Termsmeta
 */
include_once 'termmeta/terms-meta.php';
add_action('plugins_loaded', array('Fields_For_Terms', 'get_instance'));
//Fields_For_Terms::get_instance();

/**
 * Atf Metaboxes
 */
include_once 'metaboxes/atf-metabox.php';