<?php
$menu = [
    [
        'parent_menu' => 'global_menu_settings',
        'sort' => 2000,
        'text' => 'Пример модуля',
        'title' => 'Пример модуля',
        'items_id' => 'menu_example',
        'icon' => 'util_menu_icon',
        'items' => [
            [
                'text' => 'Модуль',
                'url' => 'adminpage.php?lang=' . LANGUAGE_ID,
                'title' => 'Настройки',
            ],
        ],
    ],
];

return $menu;