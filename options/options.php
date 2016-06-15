<?php
define( 'AFT_OPTIONS_POST_INDEX', 'atfOptions');
define( 'AFT_OPTIONS_PREFIX', 'atfOptions_');
// here will be the geting options class


class AtfOptions {
	public $defaults;
	function __construct($optionsArray){
		$this->defaults = $optionsArray;
	}
	function get($sectionName) {
		$options = get_option(AFT_OPTIONS_PREFIX.$sectionName);
		foreach ($this->defaults[$sectionName]['items'] as $itemId => $item ) {
			if(!isset($options[$itemId])) {
				$options[$itemId] = $item['default'];
			}
		}
	}
}

function get_atf_options($section_name) {
	global $atf_options;

	$options_array = get_options_array();

	if (isset($atf_options[$section_name])) return $atf_options[$section_name];

	$section_options = get_option(AFT_OPTIONS_PREFIX . $section_name);

	if (!is_array($section_options)) $section_options = array();

	foreach ($options_array[$section_name]['items'] as $itemId => $item ) {
		if(!isset($section_options[$itemId]) && isset($item['default'])) {
			$section_options[$itemId] = $item['default'];
		}
	}

	$section_options = apply_filters('before_return_options_from_'.$section_name, $section_options);

	return $section_options;
}

/**
 * @param $sectionName
 *
 * @return array|mixed|void
 * @deprecated
 */
function getAtfOptions($sectionName) {
	return get_atf_options($sectionName);
}

function get_options_array() {
	global $atf_options_array;

	if (empty($atf_options_array)) $atf_options_array = apply_filters('get_options_array', array());

	return $atf_options_array;
}

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX )) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/options_admin.php' );
	AtfOptionsAdmin::get_instance();
}

?>