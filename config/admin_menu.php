<?php
$admin_menu = [
    [
       'title' => 'Главная', // Название пункта меню
       'path' => '/', // Ссылка на страницу, куда ведет этот пункт меню
       'sort' => 0, // Индекс сортировки (?)
    ],
    [
       'title' => 'Товары',
       'path' => '/admin/products/',
       'sort' => 1,
    ],
    [
       'title' => 'Заказы',
       'path' => '/admin/orders/',
       'sort' => 2,
    ],
    [
       'title' => 'Выйти', // Это не страница, а кнопка в меню
       'path' => '/out/',
       'path' => '/admin/?signOut=yes',
       'sort' => 3,
    ]
];

