# Fields for all

## Options Page

```php
new Atf_Options('atfOptions', __('Theme Options'), array(
    //atfOptions_general
    'general' => array(
        'name' => __('General settings', 'your_extension'),
        'desc' => __('General settings description', 'your_extension'),

        'items' => array(
            'favicon' => array(
                'type' => 'addMedia',
                'title' => __('Favicon', 'your_extension'),
                'default' => get_template_directory_uri() . '/assets/img/logo.png',
                'desc' => __('The optimal size for an image is 16x16', 'your_extension'),
            ),
            //another fields
        ),
    ),
    //another sections
    ));
        
```


## Metaboxes

```php
new Atf_Metabox('reviews_meta', 'Отзыв от...', 'kck_reviews', array(
	'name' => array(
		'title' => __('Name', 'your_extension'),
		'type' => 'text',
	),
	'position' => array(
		'title' => __('Position', 'your_extension'),
		'type' => 'text',
	),
	'logo' => array(
		'title' => __('Photo', 'your_extension'),
		'type' => 'media'
	),
));
```
### Metabox fields args

`mata_key`<br/> 
 Default: `false`

`save` <br/> 
 Value of this field will not add to metabox data if false. <br />
 Default: `true`
 
`sanitize` <br />
 Default: `sanitize_atf_fields`
 
 
 
## Woocommerce metabox tabs


## Term meta fields

```php
add_filter('meta_fields_for_terms', 'add_product_cat_terms_meta');

function add_product_cat_terms_meta($terms_meta)
{
    // adding meta fields for taxonomy "product_cat"
        
    if (!isset($terms_meta['product_cat']) || !is_array($terms_meta['product_cat'])) $terms_meta['product_cat'] = array();
    $terms_meta['product_cat'] = array_merge(array(
        array(
            'title' => __('Additional data', 'your_extension'),
            'type' => 'title',
        ),
        'front_img' => array(
            'title' => __('Term image', 'your_extension'),
            'type' => 'media',
            'desc' => '568x418'
        ),
        //another fields

    ), $terms_meta['product_cat']);

    return $terms_meta;
}

```


## Users meta fields

