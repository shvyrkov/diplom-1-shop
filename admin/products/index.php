<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/admin_head.php'; // <head> для администартора

if (isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == true) { // Если вход авторизован

  include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/admin_header.php'; // Меню администартора

  $offset = 0;

  if(isset($_GET['page_number']) && is_numeric($_GET['page_number'])) { // Номер страницы
      $offset = ($_GET['page_number'] - 1) * GOODS_ON_PAGE; 
  }

  $products = getProducts(GOODS_ON_PAGE, $offset); // Массив с товарами на выбранной странице
  $countItems = countItems('products'); // Количество всех товаров - для пагинации
  ?>
  <main class="page-products">
    <h1 class="h h--1">Товары</h1>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/paginator.php'; // По-страничная навигация.
    ?>
  <a class="page-products__button button" href="/admin/add/">Добавить товар</a>
<p id="delete_result"></p>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
  </div>
  <ul class="page-products__list">
    <?php
    if ($products) {

      foreach ($products as $product) : ?>
      <li class="product-item page-products__item">
        <b class="product-item__name"><?=$product['name'] ?></b>
        <span class="product-item__field"><?=$product['id'] ?></span>
        <span class="product-item__field"><?=$product['price'] ?> руб.</span>
        <ul>
        <?php
        foreach ($product['categories'] as $value) {
        ?>
        <li class="product-item__field"><?=$value ?></li>
        <?php
        }
        ?>
        </ul>
        <span class="product-item__field">
          <?php 
            $new = $product['new'] ? "Да" : "Нет";
            echo $new;
          ?>
        </span>
        <a href="/admin/add/?id=<?=$product['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
        <button class="product-item__delete" data_id="<?=$product['id'] ?>"></button>
      </li>
      <?php endforeach; 
    } else { ?> 
      <li class="product-item page-products__item">Товары не найдены</li>
    <?php } ?>

  </ul>
</main>
<?php
} else { // Если вход не авторизован ?>
  <h4>Вы не авторизованы, для входа пройдите по ссылке <button><a href="/admin/">Авторизация</a></button></h4>
<?php
}

include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; // Нижнее меню
