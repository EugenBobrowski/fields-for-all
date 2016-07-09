# Fields for all

## Options

```php
add_filter('get_options_array', 'getOptionsArray' );
function getOptionsArray() {
    return array (
        //atfOptions_general
        'general' => array(
            'name' => 'General Settings',
            'desc' => __('General settings'),

            'items' => array(
                'favicon' => array(
                    'type' => 'addMedia',
                    'title' => __('Favicon', 'atf'),
                    'default' => get_template_directory_uri().'/assets/img/logo.png',
                    'desc' => 'The optimal size for an image is 16x16'
                ),
                'logo' => array(
                    'type' => 'addMedia',
                    'title' => __('Header Logotype image', 'atf'),
                    'default' => get_template_directory_uri().'/assets/img/logo.png',
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
                )

            ),

        ),
        'social' => array(
            'name' => 'Social Settings',
            'desc' => __('Social settings'),

            'items' => array(
                'fb' => array(
                    'type' => 'textField',
                    'title' => 'Facebook',
                    'default' => 'http://facebool.com',
                ),
                'vk' => array(
                    'type' => 'textField',
                    'title' => 'VK',
                    'default' => 'http://vk.com',
                ),
//                'ig' => array(
//                    'type' => 'textField',
//                    'title' => 'Instagram',
//                    'default' => 'http://instogramm.com',
//                ),
//                'gp' => array(
//                    'type' => 'textField',
//                    'title' => 'Google+',
//                    'default' => 'http://goplus.com',
//                ),
//                'yt' => array(
//                    'type' => 'textField',
//                    'title' => 'Youtube',
//                    'default' => 'http://youtrue.com',
//                ),
//                'tw' => array(
//                    'type' => 'textField',
//                    'title' => 'Twitter',
//                    'default' => 'http://twilling.com/',
//                ),

            ),

        ),
        'home' => array(
            'name' => 'Home Page Settings',
            'desc' => __('Here you can customize home page'),

            'items' => array(
                'header_slider' => array(
                    'type' => 'group',
                    'title' => 'Главный слайдер',
                    'default' => array(
                        array(
                            'img' => get_template_directory_uri().'/assets/img/header-bg.jpg',
                            'content' => '<h4>световой декор и оформление</h4>
<h3>по самым приятным ценам</h3>
лучшие креативные решения

<a href="#">подробнее</a>'
                        ),
                        array(
                            'img' => get_template_directory_uri().'/assets/img/header-bg.jpg',
                            'content' => '<h4>световой декор и оформление</h4>
<h3>по самым приятным ценам</h3>
лучшие креативные решения

<a href="#">подробнее</a>'
                        ),
                    ),
                    'items' => array(
                        'img' => array(
                            'title' => 'Фон',
                            'type' => 'media',
                        ),
                        'content' => array(
                            'title' => 'Контент',
                            'type' => 'editor',
                            'desc' => 'Доступные стили: '
                                .'Heading 3: Большой желтый '
                                .'Heading 4: Меньше чем предыдущий, белый '
                                .'Paragraph: Ширина 300, размер 24px'
                        ,
                        ),
                    ),
                ),
                'hide_empty' => array(
                    'type' => 'onOffBox',
                    'title' => __('Hide empty category', 'atf'),
                    'default' => 'true',
                ),
                'itemsInLine' => array(
                    'type' => 'textField',
                    'title' => __('Items in line', 'atf'),
                    'default' => '3', // AtfOptions_homePage[items][thumb_width][default]
                ),
                'itemsNum' => array(
                    'type' => 'textField',
                    'title' => __('How many items must be on home page', 'atf'),
                    'default' => '6', // AtfOptions_homePage[items][thumb_width][default]
                ),
                'services_img' => array(
                    'type' => 'addMedia',
                    'title' => __('Услуги', 'atf'),
                    'default' => get_template_directory_uri().'/images/uslugi-low.jpg',
                ),
                array(
                    'type' => 'title',
                    'title' => 'Thumbnail Options'
                ),
                'thumb_width' => array(
                    'type' => 'textField',
                    'title' => __('Thumbnail width on homepage', 'atf'),
                    'desc' => __('You may add any other social share buttons to this field.', 'atf'),
                    'default' => '500', // AtfOptions_homePage[items][thumb_width][default]
                ),
                'thumb_height' => array(
                    'type' => 'textField',
                    'title' => __('Thumbnail height on homepage', 'atf'),
                    'desc' => __('You may add any other social share buttons to this field.', 'atf'),
                    'default' => '360',
                ),
                'clients' => array (
                    'type'        => 'group',
                    'desc' => __( 'Изображения', 'cmb' ),
                    'title' => 'Clients',
                    'options'     => array(
                        'group_title'   => __( 'Баннер {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
                        'add_button'    => __( 'Добавить другой баннер', 'cmb' ),
                        'remove_button' => __( 'Удалить', 'cmb' ),
                        'sortable'      => true,
                        'closed'=> true,
                    ),
                    'default' => array(
                        array(
                            'image' => get_template_directory_uri().'/images/clients/santim.png',
//                            'url' => '/',
                            'text' => 'Santim',
                        ),
                        array(
                            'image' => get_template_directory_uri().'/images/clients/kopilka.png',
                            'url' => '/',
                            'text' => 'Копілка',
                        ),
                        array(
                            'image' => get_template_directory_uri().'/images/clients/silpo.png',
//                            'url' => '/',
                            'text' => 'Сільпо',
                        ),
                        array(
                            'image' => get_template_directory_uri().'/images/clients/riviera.jpg',
//                            'url' => '/',
                            'text' => 'Riviera',
                        ),
                        array(
                            'image' => get_template_directory_uri().'/images/clients/fora.jpg',
//                            'url' => '/',
                            'text' => 'Фора',
                        ),
                        array(
                            'image' => get_template_directory_uri().'/images/clients/santim.png',
//                            'url' => '/',
                            'text' => 'Santim',
                        ),

                    ),
                    'items' => array(
                        'image' => array(
                            'type' => 'addMedia',
                            'title' => __('Изображение', 'atf'),
                            'options' => array(
                                'url' => false, // Hide the text input for the url
                                'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
                            ),
                        ),
                        'text' => array(
                            'title'    => 'Альт текст',
                            'type'    => 'text'
                        ),
//                        'url' => array(
//                            'title'    => 'Ссылкка',
//                            'type'    => 'text'
//                        ),
                    ),
                ),


            )
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