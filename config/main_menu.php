<?php
// Данные для верхнего меню покупателя.
$main_menu = [
    [
       'title' => 'Главная', // Название пункта меню
       'path' => '/', // Ссылка на страницу, куда ведет этот пункт меню
       'sort' => 0, // Индекс сортировки (?)
    ],
    [
       'title' => 'Новинки',
       // 'path' => PAGE . 'new_products/',
       'path' => '/?new=on',
       'sort' => 1,
    ],
    [
       'title' => 'Sale',
       // 'path' => PAGE . 'sale/',
       'path' => '/?sale=on',
       'sort' => 2,
    ],
    [
       'title' => 'Доставка',
       'path' => PAGE . 'delivery/',
       'sort' => 3,
    ]
];

