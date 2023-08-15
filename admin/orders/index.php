<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/admin_head.php'; // <head> для администартора

if (isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == true) { // Если вход авторизован

  include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/admin_header.php'; // Меню администартора

  $offset = 0;

  if(isset($_GET['page_number']) && is_numeric($_GET['page_number'])) { // Номер страницы
      $offset = ($_GET['page_number'] - 1) * GOODS_ON_PAGE; 
  }

  $orders = getOrders(GOODS_ON_PAGE, $offset); // Массив с заказами на выбранной странице
  $countItems = countItems('orders'); // Количество всех заказов
?>
<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <?php
  include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/paginator.php'; // По-страничная навигация.
  ?>
  <ul class="page-order__list">
    <?php
    if ($orders) {

      foreach ($orders as $order) : ?>
      <li class="order-item page-order__item">
        <div class="order-item__wrapper">
          <div class="order-item__group order-item__group--id">
            <span class="order-item__title">Номер заказа</span>
            <span class="order-item__info order-item__info--id"><?=$order['id'] ?></span>
          </div>
          <div class="order-item__group">
            <span class="order-item__title">Сумма заказа</span>
            <?=$order['productPrice'] ?> руб.
          </div>
          <button class="order-item__toggle"></button>
        </div>
        <div class="order-item__wrapper">
          <div class="order-item__group order-item__group--margin">
            <span class="order-item__title">Заказчик</span>
            <span class="order-item__info"><?=$order['surname'] ?> <?=$order['firstName'] ?> <?=$order['thirdName'] ?></span>
          </div>
          <div class="order-item__group">
            <span class="order-item__title">Номер телефона</span>
            <span class="order-item__info"><?=$order['phone'] ?></span>
          </div>
          <div class="order-item__group">
            <span class="order-item__title">Способ доставки</span>
            <span class="order-item__info">
              <?php if ($order['delivery'] == 'dev-no') { ?> Самовывоз <?php } 
                    if ($order['delivery'] == 'dev-yes') { ?>Доставка на дом<?php } 
              ?>
            </span>
          </div>
          <div class="order-item__group">
            <span class="order-item__title">Способ оплаты</span>
            <span class="order-item__info">
              <?php if ($order['pay'] == 'card') { ?>Банковской картой<?php } ?>
              <?php if ($order['pay'] == 'cash') { ?>Наличными<?php } ?>
            </span>
          </div>
          <div class="order-item__group order-item__group--status">
            <span class="order-item__title">Статус заказа</span>

            <?php if ($order['status'] == 0) { ?>
            <span class="order-item__info order-item__info--no">Не выполнено 
            <?php }
            if ($order['status'] == 1) { ?>
            <span class="order-item__info order-item__info--yes">Выполнено 
            <?php } ?>
            </span>

            <button class="order-item__btn">Изменить</button>
            <p class="testStatus" ></p>
          </div>
        </div>
        <?php if ($order['delivery'] == 'dev-yes') { ?> 
        <div class="order-item__wrapper">
          <div class="order-item__group">
            <span class="order-item__title">Адрес доставки</span>
            <span class="order-item__info">г. <?=$order['city'] ?>, ул. <?=$order['street'] ?>, д.<?=$order['home'] ?>, кв. <?=$order['aprt'] ?></span>
          </div>
        </div>
        <?php } ?>
        <div class="order-item__wrapper">
          <div class="order-item__group">
            <span class="order-item__title">Комментарий к заказу</span>
            <span class="order-item__info"><?=$order['comment'] ?></span>
          </div>
        </div>
      </li>
    <?php endforeach; 
    } else { ?>
      <li>
        Заказов нет или произошел сбой на сервере
      </li>
  <?php } ?>
  </ul>
</main>
<?php
} else { // Если вход не авторизован ?>
  <h4>Вы не авторизованы, для входа пройдите по ссылке <button><a href="/admin/">Авторизация</a></button></h4>
<?php 
}
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; // Нижнее меню
