<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/includeFiles.php'; // Подключение используемых файлов, запуск сессии и пр.
// Валидация полей
    $surname = isset($_POST['surname']) ? htmlentities($_POST['surname']) : ''; // Фамилия
    $firstName = isset($_POST['firstName']) ? htmlentities($_POST['firstName']) : ''; // Имя
    $thirdName = isset($_POST['thirdName']) ? htmlentities($_POST['thirdName']) : ''; // Отчество
    $phone = isset($_POST['phone']) ? htmlentities($_POST['phone']) : ''; // Телефон
    $email = isset($_POST['email']) ? htmlentities($_POST['email']) : ''; // E-mail

    $delivery = isset($_POST['delivery']) ? htmlentities($_POST['delivery']) : ''; // Способ доставки
    // $deliveryCost = isset($_POST['deliveryCost']) ? htmlentities($_POST['deliveryCost']) : ''; // Стоимость доставки

    $city = isset($_POST['city']) ? htmlentities($_POST['city']) : ''; // Город
    $street = isset($_POST['street']) ? htmlentities($_POST['street']) : ''; // Улица
    $home = isset($_POST['home']) ? htmlentities($_POST['home']) : ''; // Дом
    $aprt = isset($_POST['aprt']) ? htmlentities($_POST['aprt']) : ''; // Квартира

    $pay = isset($_POST['pay']) ? htmlentities($_POST['pay']) : ''; // Способ оплаты
    $comment = isset($_POST['comment']) ? htmlentities($_POST['comment']) : ''; // Комментарии к заказу

    $productId = isset($_POST['productId']) ? htmlentities($_POST['productId']) : ''; // Id-товара
    $productPrice = isset($_POST['productPrice']) ? htmlentities($_POST['productPrice']) : ''; // Стоимость товара
    $deliveryPrice = 0; // Стоимость доставки

    if ($productPrice < COURIER_FREE_MIN_PRICE && $delivery == 'dev-yes') { // Если выбран способ доставки “Курьерская доставка” и сумма заказа менее COURIER_FREE_MIN_PRICE рублей, 
        $deliveryPrice = COURIER_PRICE; // то в стоимость заказа включается стоимость доставки – COURIER_PRICE руб. 
    }

$order = addOrder($surname, $firstName, $thirdName, $phone, $email, $delivery, $city, $street, $home, $aprt, $pay, $comment, $productId, $productPrice, $deliveryPrice); // bool/string
