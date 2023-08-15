<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/include/includeFiles.php'; // Подключение используемых файлов, запуск сессии и пр.
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Авторизация</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">

  <script src="/js/scripts.js" defer=""></script>
</head>
<body>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; // Верхнее меню для всех страниц 
include $_SERVER['DOCUMENT_ROOT'] . '/admin/handlers/signOut.php'; // Обработчик выхода из авторизации
?>
<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <?php
  if (isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == false) {
    echo "<h3>Логин или пароль неверны</h3>";
  }
  ?>
  <form class="custom-form" action="/admin/handlers/authorization.php" method="post">
    <!-- После авторизации идет переход на страницу с заказами с меню Админа/Опера в зависимости от Статуса -->
    <input type="email" class="custom-form__input" required="" name="login">
    <input type="password" class="custom-form__input" required="" name="password">
    <button class="button" type="submit" name="auth_submit" value="enter">Войти в личный кабинет</button>
  </form>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; // Нижнее меню
