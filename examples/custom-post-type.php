<?php
/**
 * Created by PhpStorm.
 * User: eugen
 * Date: 13.06.18
 * Time: 17:12
 */


class Ambassadors
{

	protected static $instance;
	private $post_type;

	private function __construct()
	{
		$this->post_type = 'ambassadors';
		add_action('init', array($this, 'product_register'));
		add_action('init', array($this, 'fields'));

		add_action('admin_print_styles', array($this, 'column_styles'));
		add_filter('manage_'.$this->post_type.'_posts_columns', array($this, 'add_columns'));
		add_filter('manage_'.$this->post_type.'_posts_custom_column', array($this, 'column_content'), 10, 2);

	}

	public function product_register()
	{

		$args = array(
			'labels' => array(
				'name' => __('Ambassadors'),
				'singular_name' => __('Ambassadors'),
			),
			'public' => true,
			'supports' => array('title', 'thumbnail', 'editor', 'page-attributes'),
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-lightbulb',
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'ambassadors'),
			'capability_type' => 'page',
		);
		register_post_type($this->post_type, $args);
	}

	public function fields () {

		if (!class_exists('Atf_Metabox')) {
			echo 'Please activate Fields For All Plugin';
			return;
		}
		new Atf_Metabox('ambassador_details', 'Ambassadors details', $this->post_type, array(
			'Instagram' => array(
				'title' => 'Instagram',
				'type' => 'text',
			),

		));
	}



	public function add_columns($columns)
	{
		$end = array_splice($columns, 1);
		$columns = array_merge($columns, array('thumb' => '<span class="dashicons dashicons-format-image"></span>'), $end);
		return $columns;
	}

	public function column_content($column, $post_id)
	{
		switch ($column) {
			case 'thumb':
				if (has_post_thumbnail($post_id)) the_post_thumbnail();
				break;

		}
	}

	public function column_styles()
	{
		?>

		<style>
			.manage-column.column-thumb {
				text-align: center;
			}

			.column-thumb {
				width: 60px;
			}

			.column-thumb img {
				width: 60px;
				height: 60px;
			}

		</style>

		<?php
	}



	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

Ambassadors::get_instance();