<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/admin_head.php'; // <head> для администартора

if (isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == true) { // Если вход авторизован

  include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/admin_header.php'; // Меню администартора

// Считываем id из GET-запроса и выводим данные по товару из БД
  if (isset($_GET['id'])) {
    $id = htmlentities($_GET['id']);
    $product = getProduct($id); // Данные по выбранному товару
  } else {
    $product = 0;
  }
?>
<main class="page-add">
  <h1 class="h h--1">Добавление/Изменение товара</h1>
  <form class="custom-form" action="/admin/handlers/changeProduct.php" method="post" id="addProd" enctype="multipart/form-data" name="product-info">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>

      <input type="text" class="custom-form__input" name="product-id" id="product-id" hidden=""
      value="<?php if ($product) { echo $product['id']; }?>" >

      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" 
            value="<?php if ($product) { echo $product['name']; }?>" required>
        <p class="custom-form__input-label">
          <?php
          if ($product) {
            echo $product['name'];
          } else { ?> Название товара <?php } ?>
        </p>
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price"
        value="<?php if ($product) { echo $product['price']; }?>" required>
        <p class="custom-form__input-label">
          <?php
          if ($product) {
            echo $product['price'] . " руб.";
          } else { ?> Цена товара <?php } ?>
        </p>
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
        <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
        
        <ul class="add-list">
            <li class="add-list__item add-list__item--add" >
                <input type="file" name="product-photo" id="product-photo" hidden="" >
                <?php if ($product) { ?>
                  <img src="/img/products/<?=$product['image']?>">
                  <label for="product-photo"></label>
                <?php } else { ?>
                <label for="product-photo">Добавить фотографию</label>
                <?php } ?>
            </li>
        </ul>
    </fieldset>

    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="categories[]" class="custom-form__select" multiple="multiple" required>
          <option hidden="">Название раздела</option>
          <option value="female" <?php if (isset($product['categories']) && in_array('women', $product['categories'])) 
          { echo "selected"; } ?>>Женщины</option>
          <option value="male" <?php if (isset($product['categories']) && in_array('men', $product['categories'])) { echo "selected"; } ?>>Мужчины</option>
          <option value="children" <?php if (isset($product['categories']) && in_array('children', $product['categories'])) { echo "selected"; } ?>>Дети</option>
          <option value="accessories" <?php if (isset($product['categories']) && in_array('accessories', $product['categories'])) { echo "selected"; } ?>>Аксессуары</option>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?php if ($product && $product['new']) { echo "checked"; } ?>>
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?php if ($product && $product['sale']) { echo "checked"; } ?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
      <br>
      <br>
      <br>
      <input type="checkbox" name="active" id="active" class="custom-form__checkbox" <?php if ($product && !$product['active']) { echo "checked"; } ?>>
      <label for="active" class="custom-form__checkbox-label">Активность товара</label>
    </fieldset>

    <button class="button" type="submit" name="product-change" value="1">
    <?php if ($product) { ?> Сохранить изменения
    <?php } else { ?> Добавить товар <?php } ?>
    </button>
  </form>

  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
      <h4 id="test_product_data">Test product_data</h4>
      <h4 id="test_product_photo">Test product_photo</h4>
    </div>
  </section>

</main>
<?php
} else { // Если вход не авторизован ?>
  <h4>Вы не авторизованы, для входа пройдите по ссылке <button><a href="/admin/">Авторизация</a></button></h4>
<?php
}
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; // Нижнее меню
