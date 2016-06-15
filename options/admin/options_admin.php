<?php

class AtfOptionsAdmin {
	protected $plugin_screen_hook_suffix = null;
	protected $optionsSlug = 'atf-options';
	protected static $instance = null;
	public $optionsArray;

	private function __construct() {

		if (isset($_POST[AFT_OPTIONS_PREFIX])) {
			add_action('admin_init', array($this, 'save_options'));
		}
		// Add the options page and menu item.
		add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

		// Load admin style sheet and JavaScript.
		add_action('admin_enqueue_scripts', array($this, 'assets'));


	}

	public static function get_instance() {



		// If the single instance hasn't been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function assets() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		$atfOptionsIs = strpos($screen->id, str_replace('toplevel', '', $this->plugin_screen_hook_suffix));
		if ($atfOptionsIs !== false) {
			include_once ATF_PATH . 'options/atf-fields/htmlhelper.php';
			AtfHtmlHelper::assets(get_template_directory_uri() . '/atf/options/atf-fields/');
		}
	}

	public function add_plugin_admin_menu() {
		$this->optionsArray = get_options_array();
		$this->plugin_screen_hook_suffix = add_menu_page(
			__('Theme Options', 'atf'),
			__('Theme Options', 'atf'),
			'edit_theme_options',
			'atf-options',
			array($this, 'display_plugin_admin_page'),
			get_template_directory_uri().'/atf/options/admin/assets/atf-options.png'//$icon_url,
		//$position
		);
		foreach (get_options_array() as $sectID=>$section) {
			//add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
			add_submenu_page('atf-options', __('Theme Options', 'atf'), $section['name'], 'edit_theme_options', 'atf-options-' .$sectID, array($this, 'display_plugin_admin_page'));
		}
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
//		$this->optionsArray = getOptionsArray();

		include 'views/admin.php';
		add_action('admin_footer_text', array($this, 'admin_footer_text'));
	}
	public function save_options() {

		// Check if our nonce is set.
		if ( ! isset( $_POST['update-atfOptions'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['update-atfOptions'], 'update-atfOptions' ) ) {
			return;
		}

		// Make sure that it is set.
		if ( ! isset( $_POST[AFT_OPTIONS_PREFIX] ) ) {
			return;
		}

		$new_options_values = apply_filters('new_options_values', $_POST[AFT_OPTIONS_PREFIX]);


		foreach($new_options_values as $key=>$value) {

			update_option(AFT_OPTIONS_PREFIX.$key, $value);
		}
	}
	public function admin_footer_text($footer = '') {
		echo '<span id="footer-thankyou"><img src="'.get_template_directory_uri().'/atf/options/admin/assets/atfdev-logo.png'.'" style="height: 50px;vertical-align: middle;" > Created by <a href="http://atf.li" >ATF</a>. Version '.ATF_VERSION.' </span>';
	}
}