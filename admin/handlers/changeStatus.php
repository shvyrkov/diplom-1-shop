<?php
include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/dbFunctions.php'; // Функции для работы с БД
include $_SERVER['DOCUMENT_ROOT'] . '/include/dbFunctions.php'; // Функции для работы с БД

$orderStatus = isset($_POST['orderStatus']) ? htmlentities($_POST['orderStatus']) : 0;
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : 0;

$result = changeStatus($id, $orderStatus); // Меняем статус заказа в БД
