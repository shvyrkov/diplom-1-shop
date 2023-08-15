<?php
// Запуск сессии
ini_set('session.gc_maxlifetime', 60 * 60 * 24);  // Время жизни сессии
ini_set('session.cookie_lifetime', 60 * 60 * 24); // и сессионной куки должно быть установлено 1 сутки.
// session_set_cookie_params(60 * 60 * 24); // как вариант для куки
session_start(); // Запуск сессии.

include $_SERVER['DOCUMENT_ROOT'] . '/config/constants.php'; // Константы, используемые в приложении.

// Подключение используемых файлов и пр. одинаковое для всех страниц.
include $_SERVER['DOCUMENT_ROOT'] . '/include/pageFunctions.php'; // Функции для управления данными на странице

include $_SERVER['DOCUMENT_ROOT'] . '/include/dbFunctions.php'; // Функции для работы с БД
include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/dbFunctions.php'; // Функции для работы с БД

include $_SERVER['DOCUMENT_ROOT'] . '/config/main_menu.php'; // Массив с названиями страниц покупателя.
include $_SERVER['DOCUMENT_ROOT'] . '/config/admin_menu.php'; // Массив с названиями страниц администратора.
include $_SERVER['DOCUMENT_ROOT'] . '/config/categories_list.php'; // Массив с названиями категорий товаров.

include $_SERVER['DOCUMENT_ROOT'] . '/config/filters_default.php'; // Подключение начальных данных фильтров товаров
