<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/includeFiles.php'; // Подключение используемых файлов, запуск сессии и пр.

$passwordVerification = false;

if (! empty($_POST['auth_submit'])) {
// Валидация полей
    $login = isset($_POST['login']) ? htmlentities($_POST['login']) : ''; //
    $password = isset($_POST['password']) ? htmlentities($_POST['password']) : ''; //
    $_SESSION['isAuth'] = false; // $_SESSION['isAuth'] - если все удачно авторизовано, то = true, если нет то = false
    $_SESSION['accessProducts'] = false;

    $userExists = getUserByLogin($login); // Получение данных пользователя, если он есть.

    if ($userExists) { // Если пользователь существует
        $passwordVerification = password_verify ($password , $userExists['password']); // Проверка пароля

        if ($passwordVerification) { // Если пароль правильный
            $_SESSION['isAuth'] = true;

            if ($userExists["status"] == 'adm') { // Если это Admin, то даём доступ к изменению товаров
                $_SESSION['accessProducts'] = true;
            }
        }
    }

    if ($_SESSION['isAuth']) {
       // После авторизации идет переход на страницу с заказами с меню Админа/Опера в зависимости от Статуса
        header("Location: /admin/orders/"); // Ok
    } else { // Если логин или пароль НЕправильные
        header("Location: /admin/");
    }
}
