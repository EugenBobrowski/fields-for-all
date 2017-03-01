<?php

class Atf_Options
{

    protected $plugin_screen_hook_suffix = null;
    public $slug;
    public $page_title;
    public $menu_title;
    public $capability;
    public $optionsArray;
    public $menu_icon;

    public function __construct($id, $title, $options_array)
    {

        $this->slug = $id;
        $this->page_title = $title;
        $this->menu_title = $title;
        $this->capability = 'edit_theme_options';
        $this->menu_icon = 'dashicons-admin-generic';
        $this->optionsArray = $options_array;

        if (isset($_POST[$this->slug])) {
            add_action('admin_init', array($this, 'save_options'));
        }
        // Add the options page and menu item.
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

        // Load admin style sheet and JavaScript.
        add_action('admin_enqueue_scripts', array($this, 'assets'));

        add_filter('get_atf_options', array($this, 'get_options'), 10, 3);

    }

    /**
     * Register and enqueue admin-specific JavaScript.
     *
     * @since     1.0.0
     *
     * @return    null    Return early if no settings page is registered.
     */
    public function assets()
    {

        if (!isset($this->plugin_screen_hook_suffix)) {
            return;
        }

        $screen = get_current_screen();
        $atfOptionsIs = strpos($screen->id, str_replace('toplevel', '', $this->plugin_screen_hook_suffix));
        if ($atfOptionsIs !== false) {
            include_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';
            AtfHtmlHelper::assets();
        }
    }

    public function add_plugin_admin_menu()
    {

        $this->plugin_screen_hook_suffix = add_menu_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->slug,
            array($this, 'display_plugin_admin_page'),
            $this->menu_icon//$icon_url,
        //$position
        );
        foreach ($this->optionsArray as $sectID => $section) {
            //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
            add_submenu_page($this->slug, $this->page_title, $section['name'], $this->capability, $this->slug . '-' . $sectID, array($this, 'display_plugin_admin_page'));
        }
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page()
    {
//		$this->optionsArray = getOptionsArray();

        include 'admin/views/admin.php';
        add_action('admin_footer_text', array($this, 'admin_footer_text'));
    }

    public function save_options()
    {

        // Check if our nonce is set.
        if (!isset($_POST['update-atfOptions'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['update-atfOptions'], 'update-atfOptions')) {
            return;
        }

        // Make sure that it is set.
        if (!isset($_POST[$this->slug])) {
            return;
        }

        $new_options_values = apply_filters('new_options_values', $_POST[$this->slug]);


        foreach ($new_options_values as $key => $value) {
            update_option($this->slug . '_' . $key, $value);
        }
    }

    public function get_options($atf_options, $slug, $section)
    {

        if ($slug == $this->slug) {

            $section_options = get_option($this->slug . '_' . $section);

            if (!is_array($section_options)) $section_options = array();

            foreach ($this->optionsArray[$section]['items'] as $itemId => $item) {

                if (!isset($section_options[$itemId]) && isset($item['default'])) {
                    $section_options[$itemId] = $item['default'];
                }
            }

            $atf_options[$this->slug][$section] = $section_options;
        }

        return $atf_options;
    }

    public function admin_footer_text($footer = '')
    {
        echo '<span id="footer-thankyou"><img src="' . plugin_dir_url(__FILE__) . 'assets/atfdev-logo.png' . '" style="height: 50px;vertical-align: middle;" > Created by <a href="http://atf.li" >ATF</a>.</span>';
    }


}

function get_atf_options($slug, $section_name = null, $item_key = null)
{
    global $atf_options;

    if (!is_array($atf_options)) $atf_options = array();

    if (!isset($atf_options[$slug][$section_name])) {

        $atf_options = apply_filters('get_atf_options', $atf_options, $slug, $section_name);
        $atf_options[$slug][$section_name] = apply_filters('before_return_options_from_' . $section_name, $atf_options[$slug][$section_name]);

    }

    if ($item_key === null) return $atf_options[$slug][$section_name];

    return $atf_options[$slug][$section_name][$item_key];
}

include_once 'depricated.php';