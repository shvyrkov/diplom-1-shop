<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/includeFiles.php'; // Подключение используемых файлов, запуск сессии и пр.

if(isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
    $priceMin = $_GET['min_price'];
}

if(isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $priceMax = $_GET['max_price'];
}

if(isset($_GET['new']) && $_GET['new'] == 'on') {
    $new = true;
}

if(isset($_GET['sale']) && $_GET['sale'] == 'on') {
    $sale = true;
}

if(isset($_GET['category']) && in_array($_GET['category'], array_column($categories, 'cat_name') )) { // проверка на присутствие в БД
    $category = htmlentities($_GET['category']);
}

$countProducts = countProducts($category, $categories, $priceMin, $priceMax, $new, $sale); // Количество товаров по выбранной категории

echo "$countProducts";