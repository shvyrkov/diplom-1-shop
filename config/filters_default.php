<?php
// Filters
$new = false; // Новинка
$sale = false; // Распродажа
$priceMin = PRICE_MIN; // Минимальная цена
$priceMax = PRICE_MAX; // Максимальная цена

// $priceRange = json_encode(['priceMin' => $priceMin, 'priceMax' => $priceMax]);
// echo "$priceRange";

// Sorting
$sort_column = ''; // Столбец для сортировки
$order = ''; // Направление сортировки

$sort_columns = ['name', 'price'];
$orderTypes = ['ASC', 'DESC'];

// Paginator
$offset = 0;
