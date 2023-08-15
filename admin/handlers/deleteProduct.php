<?php
include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/dbFunctions.php'; // Функции для работы с БД
include $_SERVER['DOCUMENT_ROOT'] . '/include/dbFunctions.php'; // Функции для работы с БД
include $_SERVER['DOCUMENT_ROOT'] . '/include/pageFunctions.php'; // Функции для работы на странице

// echo "<pre>";
// print_r($_POST);
// echo "POST: <br>";
// var_dump($_POST); // ["product-id"] => string(1) "2"
// echo "</pre>";

if (isset($_POST['product-id'])) {

    $result = false;

    $id = is_numeric($_POST['product-id']) ? htmlentities($_POST['product-id']) : 0; // Проверяем является ли id целым числом

    if ($id) { // Если число, то удаляем товар

        $result = deleteProduct($id);

        if ($result) {
            echo "Ok";
        } else {
            echo "Товар не был удален.";
        }

    } else {
        echo "Произошел сбой. Товар не был удален.";
    }
    

} else {
    echo "Повторите операцию удаления";
}
