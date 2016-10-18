# Fields for all

## Options Page

```php
add_filter('get_options_array', 'getOptionsArray' );
function getOptionsArray() {
    return array (
        //atfOptions_general
        'section1' => array(
            'name' => 'General Settings',
            'desc' => __('General settings'),

            'items' => array(
                'logo' => array(
                    'type' => 'addMedia',
                    'title' => __('Header Logotype image', 'atf'),
                    'default' => get_template_directory_uri().'/assets/img/logo.png',
                ),
                'itemsInLine' => array(
                    'type' => 'textField',
                    'title' => __('Items in line', 'atf'),
                    'default' => '3', // AtfOptions_homePage[items][thumb_width][default]
                ),
                'hide_empty' => array(
                    'type' => 'onOffBox',
                    'title' => __('Hide empty category', 'atf'),
                    'default' => 'true',
                ),
                                
                array(
                    'type' => 'title',
                    'title' => 'Phones Group Title'
                ),
                                
                'phones' => array(
                    'type' => 'group',
                    'title' => 'Список телефонов',
                    'default' => array(
                        array(
                            'phone' => '044 575 11 33',
                            'address' => 'Ул. Гмыри, 1а/4, кв. 43',
                        ),
                        array(
                            'phone' => '048 234 13 83',
                            'address' => 'Ул. Фонтанская Дорога, 135',
                        ),
                    ),
                    'items' => array(
                        'phone' => array(
                            'title' => __('Phone', 'robotstxt-rewrite'),
                            'type' => 'text',
                            'desc' => __('Relative path of WordPress installation directory', 'robotstxt-rewrite'),
                        ),
                        'address' => array(
                            'title' => __('Address', 'robotstxt-rewrite'),
                            'type' => 'text',
                            'desc' => __('Relative path of WordPress installation directory', 'robotstxt-rewrite'),
                        ),
                    ),

                ),
                'copyright' => array(
                    'type' => 'editor',
                    'title' => __('Copyright'),
                    'default' => '© 2016 KCK illumination  |  Все права защищены'
                ),
            ),
        ),
    );
}
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