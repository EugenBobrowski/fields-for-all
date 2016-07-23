<?php

/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 22.06.16
 * Time: 14:03
 */
class Fields_For_Terms
{

    protected static $instance;

    public $fields;

    private function __construct()
    {
        $this->fields = apply_filters('meta_fields_for_terms', array());

        foreach ($this->fields as $taxonomy => $fields) {
            $priority = (isset($fields['priority'])) ? $fields['priority'] : 10;
            add_action($taxonomy . '_add_form_fields', array($this, 'add_term_fields'), $priority, 2);
            add_action($taxonomy . '_edit_form_fields', array($this, 'edit_term_fields'), $priority, 2);
        }
        add_action('created_term', array($this, 'save_term_meta'), 10, 3);
        add_action('edited_terms', array($this, 'update_term_meta'), 10, 2);
    }

    public function add_term_fields($taxonomy)
    {
        require_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';
        AtfHtmlHelper::assets('f4a-' . $taxonomy);
        foreach ($this->fields[$taxonomy] as $id => $field) {
            switch ($field['type']) {
                case 'title':
                    echo '<h4>' . $field['title'] . '</h4>';
                    break;
                default:
                    $field['id'] = $id;
                    $field['name'] = $id;
                    ?>
                    <div class="form-field term-group atf-fields">
                        <label for="<?php echo $field['id']; ?>"><?php echo $field['title'] ?></label>

                        <?php AtfHtmlHelper::$field['type']($field); ?>
                    </div>
                    <?php
                    break;
            }


        }
    }

    public function edit_term_fields($term, $taxonomy)
    {
        require_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';
        AtfHtmlHelper::assets('f4a-' . $taxonomy);

        foreach ($this->fields[$taxonomy] as $id => $field) {
            switch ($field['type']) {
                case 'title':
                    ?>
                    <tr class="form-field term-group-wrap atf-fields">
                        <th scope="row" colspan="2">
                            <h3><?php echo $field['title'];?></h3>
                        </th>


                    </tr>
                    <?php
                    echo '<h4>' . $field['title'] . '</h4>';
                    break;
                default:
                    $field['id'] = $id;
                    $field['name'] = $id;
                    $field['value'] = get_term_meta($term->term_id, $id, true);

                    ?>
                    <tr class="form-field term-group-wrap atf-fields">
                        <th scope="row"><label for="<?php echo $field['id']; ?>"><?php echo $field['title'] ?></label>
                        </th>
                        <td><?php AtfHtmlHelper::$field['type']($field); ?></td>


                    </tr>
                    <?php
                    break;
            }


        }
    }

    public function save_term_meta($term_id, $tt_id, $taxonomy)
    {
        require_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';
        AtfHtmlHelper::assets('f4a-' . $taxonomy);

        if (!isset($this->fields[$taxonomy])) return;

        foreach ($this->fields[$taxonomy] as $id => $field) {
            if (isset($_POST[$id])) {
                $value = sanitize_atf_fields($_POST[$id], $field['type']);
                update_option('test_f4a', array($term_id, $id, $value));
                add_term_meta($term_id, $id, $value, true);
            }
        }

    }

    public function update_term_meta($term_id, $taxonomy)
    {
        require_once plugin_dir_path(__FILE__) . '../atf-fields/htmlhelper.php';
        AtfHtmlHelper::assets('f4a-' . $taxonomy);

        if (!isset($this->fields[$taxonomy])) return;

        foreach ($this->fields[$taxonomy] as $id => $field) {

            if (isset($_POST[$id])) {
                $value = sanitize_atf_fields($_POST[$id], $field['type']);

                update_term_meta($term_id, $id, $value);

            }
        }

    }


    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}