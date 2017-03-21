# Fields for all

## Options Page

```php
new Atf_Options('atfOptions', __('Theme Options'), array(
    //atfOptions_general
    'general' => array(
        'name' => 'Настройки сайта',
        'desc' => __('General settings'),

        'items' => array(
            'favicon' => array(
                'type' => 'addMedia',
                'title' => __('Favicon', 'atf'),
                'default' => get_template_directory_uri() . '/assets/img/logo.png',
                'desc' => 'The optimal size for an image is 16x16'
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
		'title' => 'Имя',
		'type' => 'text',
	),
	'position' => array(
		'title' => 'Должность',
		'type' => 'text',
	),
	'logo' => array(
		'title' => 'Лого',
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