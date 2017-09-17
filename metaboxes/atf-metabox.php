<?php

/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 23.06.16
 * Time: 13:51
 */
class Atf_Metabox
{
    public $id;
    public $title;
    public $screen;
    /**
     * @var string advanced | normal | side. The context within the screen where the boxes should display. Available contexts vary from screen to screen. Post edit screen contexts include 'normal', 'side', and 'advanced'. Comments screen contexts include 'normal' and 'side'. Menus meta boxes (accordion sections) all use the 'side' context. Global
     * @default value: 'advanced'
     */
    public $context = 'advanced';
    /**
     * @var string (Optional) The priority within the context where the boxes should show ('high', 'low').
     * @default value: 'default'
     */
    public $priority = 'default';

    public $fields;

    public function __construct($id, $title, $screen, $fields)
    {
        $this->id = $id;
        $this->title = $title;
        $this->screen = $screen;
        $this->fields = $fields;

        add_action('load-post.php', array($this, 'init'));
        add_action('load-post-new.php', array($this, 'init'));

    }

    public function init()
    {

        add_action('admin_enqueue_scripts', array($this, 'assets'));
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'metabox_save'));
    }

    public function assets($prefix)
    {
        include_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';
        AtfHtmlHelper::assets($prefix . '__f4a-metabox');
    }

    public function add_metabox()
    {
        add_meta_box($this->id, $this->title, array($this, 'metabox_callback'), $this->screen, 'normal', 'high');
    }

    public function metabox_callback($post)
    {

        wp_nonce_field(plugin_basename(__FILE__), $this->id . '_nonce');

        $data = get_post_meta($post->ID, $this->id, true);

        AtfHtmlHelper::table($this->fields, $data, array('name_prefix' => $this->id));

    }

    public function metabox_save($post_id)
    {
        include_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';

        if (!isset($_POST[$this->id . '_nonce']))
            return $post_id;

        if (!wp_verify_nonce($_POST[$this->id . '_nonce'], plugin_basename(__FILE__)))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        if (!current_user_can('edit_post', $post_id) || !current_user_can('edit_page', $post_id))
            return $post_id;
        if (!($this->screen == $_POST['post_type'] || (is_array($this->screen) && in_array($_POST['post_type'], $this->screen))))
            return $post_id;


        $data2save = array();

        foreach ($this->fields as $key => $field) {
            $field = wp_parse_args($field, array(
                'mata_key' => false,
                'save' => true,
                'sanitize' => 'sanitize_atf_fields',
            ));

            $data = call_user_func($field['sanitize'], $_POST[$this->id][$key], $field);

            if ($field['mata_key']) {
                update_post_meta($post_id, $field['meta_key'], $data);
            }

            if ($field['save']) $data2save[$key] = $data;
        }
        update_post_meta($post_id, $this->id, $data2save);

        return true;
    }

}