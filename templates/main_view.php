<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/templates/head.php'; // <head>...</head> <body>
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; // Верхнее меню для всех страниц.
?>
<main class="shop-page">
  <?php
  include $_SERVER['DOCUMENT_ROOT'] . '/templates/header_picture.php'; // Заставка
  ?>
  <section class="shop container">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/filters.php'; // Фильтры отбора товаров + Категории + массив $products - <form>
    ?>
    <div class="shop__wrapper">
      <?php
      include $_SERVER['DOCUMENT_ROOT'] . '/templates/sorting.php'; // Сортировка
      include $_SERVER['DOCUMENT_ROOT'] . '/templates/products.php'; // Загрузка товаров на страницу.
      include $_SERVER['DOCUMENT_ROOT'] . '/templates/paginator.php'; // По-страничная навигация.
      ?>
    </div> <!--class="shop__wrapper"-->
  </section> <!--class="shop container"-->
  <?php
  include $_SERVER['DOCUMENT_ROOT'] . '/templates/order.php'; // Старница заказа
  ?>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; // Нижнее меню
?>