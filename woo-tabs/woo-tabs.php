<?php
/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 6/16/16
 * Time: 6:23 PM
 */


if (!defined('ABSPATH')) exit;


class Woo_Product_Data_Fields
{
    protected static $instance = null;

    protected $plugin_screen_hook_suffix = null;
    public $wc_fields = null;
    public $metaboxes;


    /**
     * Constructor
     */
    public function __construct()
    {

        $this->wc_fields = apply_filters('wc_fields', $this->wc_fields);

        if (isset($_POST)) {
            add_action('save_post_product', array($this, 'product_save_data'));
        }
        add_action('add_meta_boxes_product', array($this, 'wc_tabs_n_fields'));

    }


    public static function get_instance()
    {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    public function wc_tabs_n_fields () {
        add_action('woocommerce_product_write_panel_tabs', array($this, 'product_write_panel_tab'));
        add_action('woocommerce_product_write_panels', array($this, 'product_write_panel'));

        include_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';
        add_action('admin_enqueue_scripts', array('AtfHtmlHelper', 'assets'));
    }

    /**
     * Adds a new tab to the Product Data postbox in the admin product interface
     *
     * @return string
     */
    public function product_write_panel_tab()
    {

        $fields = $this->wc_fields;

        if ($fields == null) {
            return;
        }


        foreach ($fields as $key => $fields_array) {
            if (isset($fields_array['tab_name']) && $fields_array['tab_name'] != '') {
                $href = "#" . $key;
                echo "<li class=" . $key . "><a href=" . $href . ">" . $fields_array['tab_name'] . "</a></li>";
            }
        }


    }


    /**
     * Adds the panel to the Product Data postbox in the product interface
     *
     * @return string
     */
    public function product_write_panel()
    {

        global $post;

        // Pull the field data out of the database
        $available_fields = array();
        $available_fields[] = maybe_unserialize(get_post_meta($post->ID, 'wc_productdata_options', true));

        if ($available_fields) {

            // Display fields panel
            foreach ($available_fields as $available_field) {

                $fields = $this->wc_fields;

                if ($fields == null) {
                    return;
                }


                foreach ($fields as $key => $tab) {

                    echo '<div id="' . $key . '" class="panel woocommerce_options_panel wc_cpdf_tab atf-fields"><div class="options_group">';

                    foreach ($tab['items'] as $field) {
                        self::wc_product_data_field($field);
                    }

                    echo '</div>';
                    echo '</div>';

                }


            }

        }


    }


    /**
     * Create Fields
     *
     * @param $field array
     * @return string
     */

    public function wc_product_data_field($field)
    {
        if ('divider' == $field['type']) {
            echo '</div><div class="options_group">' ;
            return;
        }

        global $post;

        $field['name'] = $field['id'];
        $val = get_post_meta($post->ID, $field['id'], true);
        if (empty($val) && isset($field['default'])) {
            $field['value'] = $field['default'];
        } else {
            $field['value'] = $val;
        }
        echo '<p class="form-field _weight_field ">';
        echo '<label for="' . esc_attr($field['id']) . '">' . $field['label'] . '</label>';
        AtfHtmlHelper::$field['type']($field) ;

        if (!empty($field['description'])) {

            if (isset($field['desc_tip']) && false !== $field['desc_tip']) {
                echo '<span class="woocommerce-help-tip" data-tip="' . esc_attr($field['description']) . '" ></span>';
            } else {
                echo '<span class="description">' . wp_kses_post($field['description']) . '</span>';
            }

        }

        echo '</p>';


    }

    public function wc_product_data_field_old($field)
    {
        global $thepostid, $post, $woocommerce;

        $fieldtype = isset($field['type']) ? $field['type'] : '';
        $field_id = isset($field['id']) ? $field['id'] : '';

        $thepostid = empty($thepostid) ? $post->ID : $thepostid;


        $options_data = maybe_unserialize(get_post_meta($thepostid, 'wc_productdata_options', true));

        switch ($fieldtype) {

            case 'multiselect':

                global $wc_cpdf;

                if (!$thepostid) $thepostid = $post->ID;
                if (!isset($field['placeholder'])) $field['placeholder'] = '';
                if (!isset($field['class'])) $field['class'] = 'short';
                if (!isset($field['value'])) $field['value'] = get_post_meta($thepostid, $field['id'], true);

                $inputval = isset($options_data[0][$field_id]) ? $options_data[0][$field_id] : '';

                $html = '<p class="form-field ' . $field['id'] . '_field"><label for="' . $field['id'] . '">' . $field['label'] . '</label>';

                $html .= '';

                $html .= '<select multiple="multiple" class="multiselect wc-enhanced-select ' . $field['class'] . '" name="' . esc_attr($field['id']) . '[]" style="width: 90%;"  data-placeholder="' . $field['placeholder'] . '">';

                $saved_val = $wc_cpdf->get_value($thepostid, $field['id']) ? $wc_cpdf->get_value($thepostid, $field['id']) : array();

                foreach ($field['options'] as $key => $value) {

                    $html .= '<option value="' . esc_attr($key) . '" ' . selected(in_array($key, $saved_val), true, false) . '>' . esc_html($value) . '</option>';

                }

                $html .= '</select>';

                if (!empty($field['description'])) {

                    if (isset($field['desc_tip']) && false !== $field['desc_tip']) {
                        $html .= '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />';
                    } else {
                        $html .= '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                    }

                }

                $html .= '</p>';

                echo $html;

                break;

            case 'gallery':

                global $wc_cpdf;

                $saved_gallery = $wc_cpdf->get_value($thepostid, $field['id']);

                ?>

                <div class="image-field-wrapper gallery form-field">

                    <div class="image-field-label">

                        <?php echo '<span>' . $field['label'] . '</span>'; ?>

                    </div>

                    <div id="image-uploader-meta-box" class="image-field-upload">

                        <div class="preview-image-wrapper">

                            <?php

                            if (is_array($saved_gallery)): foreach ($saved_gallery as $img_id) {
                                $saved_image_url = wp_get_attachment_image_src($img_id);
                                $saved_image_url_thumb = wp_get_attachment_image_src($img_id, 'thumbnail', true);

                                ?>

                                <div class="gal-item">
                                    <img class="wcpdf_saved_image"
                                         src="<?php echo esc_url($saved_image_url_thumb[0]); ?>" alt=""/>
                                    <a href="#"
                                       class="remove_image wcpdf-remove-image"><em><?php echo __('Remove', 'wc_cpdf'); ?></em></a>
                                    <input type="hidden" name="<?php echo esc_attr($field['id']); ?>[]"
                                           value="<?php echo esc_attr($img_id); ?>"/>
                                </div>

                            <?php } endif; ?>

                        </div>

                        <input class="wcpdf_image_id" type="hidden"
                               data-name="<?php echo esc_attr($field['id']); ?>" name="name-needle" value=""/>
                        <input class="wcpdf_image_url" type="hidden"
                               name="wcpdf_image_url_<?php echo $field['id']; ?>"
                               value="<?php echo ($saved_image) ? $saved_image_url[0] : ''; ?>"/>
                        <a class="wcpdf-uppload-image-gallery button" href="#"
                           data-uploader-title="<?php echo __('Choose images', 'wc_cpdf') ?>"
                           data-uploader-button-text="<?php echo __('Choose images', 'wc_cpdf') ?>"><?php echo __('Choose images', 'wc_cpdf') ?></a>

                        <?php
                        if (!empty($field['description'])) {

                            if (isset($field['desc_tip']) && false !== $field['desc_tip']) {
                                echo '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />';
                            } else {
                                echo '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                            }

                        }
                        ?>

                    </div>

                </div><!-- /.image-field-wrapper -->

                <?php
                break;


            case 'datepicker':

                $thepostid = empty($thepostid) ? $post->ID : $thepostid;
                $field['placeholder'] = isset($field['placeholder']) ? $field['placeholder'] : '';
                $field['class'] = isset($field['class']) ? $field['class'] : 'short';
                $field['wrapper_class'] = isset($field['wrapper_class']) ? $field['wrapper_class'] : '';
                $field['value'] = isset($field['value']) ? $field['value'] : get_post_meta($thepostid, $field['id'], true);
                $field['name'] = isset($field['name']) ? $field['name'] : $field['id'];
                $field['type'] = isset($field['type']) ? $field['type'] : 'text';

                $inputval = isset($options_data[0][$field_id]) ? $options_data[0][$field_id] : '';

                echo '<p class="form-field ' . esc_attr($field['id']) . '_field ' . esc_attr($field['wrapper_class']) . '"><label for="' . esc_attr($field['id']) . '">' . wp_kses_post($field['label']) . '</label><input type="text" class="' . esc_attr($field['class']) . ' wc_cpdf_datepicker" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($inputval) . '" placeholder="' . esc_attr($field['placeholder']) . '"' . (isset($field['style']) ? ' style="' . $field['style'] . '"' : '') . ' /> ';

                if (!empty($field['description'])) {

                    if (isset($field['desc_tip']) && false !== $field['desc_tip']) {
                        echo '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />';
                    } else {
                        echo '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                    }

                }

                echo '</p>';

                break;


        }


    }


    /**
     * Saves the data inputed into the product boxes, as post meta data
     * identified by the name 'wc_productdata_options'
     *
     * @param int $post_id the post (product) identifier
     * @param stdClass $post the post (product)
     * @return void
     */
    public function product_save_data($post_id)
    {
        /** field name in pairs array **/
        $tabs = $this->wc_fields;

        if ($tabs == null) {
            return;
        }

        foreach ($tabs as $key => $tab_opts) {
            foreach ($tab_opts['items'] as $data) {
                if (!isset($data['id'])) continue;
                if (!isset($_POST[$data['id']])) continue;
                update_post_meta($post_id, $data['id'], $_POST[$data['id']]);
            }
        }
    }


}