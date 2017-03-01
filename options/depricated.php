<?php
/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 14.02.17
 * Time: 14:35
 */

define( 'AFT_OPTIONS_PREFIX', 'atfOptions_');


/**
 * @param $sectionName
 *
 * @return array|mixed|void
 * @deprecated
 */
function getAtfOptions($sectionName) {
    return get_atf_options('atfOptions', $sectionName);
}

function get_options_array() {
    global $atf_options_array;

    if (empty($atf_options_array)) $atf_options_array = apply_filters('get_options_array', array());

    return $atf_options_array;
}
