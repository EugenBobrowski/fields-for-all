<?php

/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 16.09.17
 * Time: 19:03
 */
class Atf_Metabox_CMB2_Legacy extends Atf_Metabox
{
    public $prefix = '';
    public $prefix_len = 0;

    public function add_field($args)
    {
        $id = $this->remove_prefix($args['id']);

        $args['title'] = $args['name'];
        unset($args['name']);

        switch ($args['type']) {
            case 'radio_inline':
                $args['type'] = 'radio';
                $args['vertical'] = false;
                $args['buttons'] = true;
                break;
            case 'multicheck_inline':
                $args['type'] = 'checkbox';
                $args['vertical'] = false;
                $args['buttons'] = true;
                break;
            case 'tax_dropdown':
                $args['type'] = 'select';
                break;

        }

        if (!empty($args['show_option_none'])) {
            $args['options'] = array('' => __('None')) + $args['options'];
        }


        $this->fields[$id] = $args;
    }

    public function set_prefix($prefix)
    {
        $this->prefix = $prefix;
        $this->prefix_len = strlen($prefix);

    }

    private function remove_prefix($id)
    {
        if (empty($this->prefix)) return $id;

        if (strpos($id, $this->prefix) !== 0) return $id;

        $id = substr($id, $this->prefix_len);

        return $id;
    }
}

function new_atf_box_from_cmb2($args)
{
    $args = wp_parse_args($args, array());

    $metabox = new Atf_Metabox_CMB2_Legacy($args['id'], $args['title'], $args['object_types'], array());

    if (!empty($args['prefix'])) $metabox->set_prefix($args['prefix']);

    return $metabox;
}