<?php
// Данные для верхнего меню покупателя.
$categories = [
    [
       'title' => 'Все', // Название категории по русски
       'cat_name' => 'All', // Ссылочное название категории ?@TO DELETE ?
       'path' => '/', // Ссылка на страницу, куда ведет этот пункт меню
       'sort' => 0, // Индекс сортировки (?)
    ],
    [
       'title' => 'Женщины',
       'cat_name' => 'women',
       'path' => CATEGORY .'women/',
       'sort' => 1,
    ],
    [
       'title' => 'Мужчины',
       'cat_name' => 'men',
       'path' => CATEGORY .'men/',
       'sort' => 2,
    ],
    [
       'title' => 'Дети',
       'cat_name' => 'children',
       'path' => CATEGORY .'children/',
       'sort' => 3,
    ],
    [
       'title' => 'Аксессуары',
       'cat_name' => 'accessories',
       'path' => CATEGORY .'accessories/',
       'sort' => 4,
    ]
];

