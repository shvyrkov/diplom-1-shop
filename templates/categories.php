<?php
$category = getCurrentCategory($categories); // Получаем cat_name текущей категории товара.

// Проверка наличия GET-параметров, если была фильтрация, сортировка или пагинация.
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

if(isset($_GET['sort_column']) && in_array($_GET['sort_column'], $sort_columns)) { // проверка на присутствие в БД
    $sort_column = $_GET['sort_column'];
}

if(isset($_GET['order']) && in_array($_GET['order'], $orderTypes)) { //проверка на наличие в массиве ['ASC', 'DESC']
    $order = $_GET['order']; 
}

if(isset($_GET['page_number'])) {
    $offset = ($_GET['page_number'] - 1) * GOODS_ON_PAGE; 
}

$products = getProductsFromDB($category, $categories, $priceMin, $priceMax, $new, $sale, $sort_column, $order, GOODS_ON_PAGE, $offset); // Получаем массив товаров по заданным параметрам

$countProducts = countProducts($category, $categories, $priceMin, $priceMax, $new, $sale); // Количество товаров по заданным параметрам
?>
<div class="filter__wrapper">
    <b class="filter__title">Категории товаров</b>

    <?php
    showMenu($categories, 'categories'); // Меню категорий.
    ?>

</div>
