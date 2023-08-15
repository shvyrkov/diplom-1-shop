    <section class="shop__filter filter">
      <form method="GET" action="/include/getProducts.php" id="request">
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/templates/categories.php'; // Выбор категории товаров + формирование $products
        ?>
        <div class="filter__wrapper">
          <b class="filter__title">Фильтры</b>
          <div class="filter__range range">
            <span class="range__info">Цена</span>
            <div class="range__line" aria-label="Range Line"></div>
            <div class="range__res">
              <span class="range__res-item min-price" slider-min="<?=$priceMin ?>"><?=$priceMin ?> руб.</span>
              <span class="range__res-item max-price" slider-max="<?=$priceMax ?>"><?=$priceMax ?> руб.</span>
            </div>
            <input type="text" hidden name="min_price" id="min_price">
            <input type="text" hidden name="max_price" id="max_price">
            <input type="text" hidden name="category" id="category" value="<?=$category?>">
          </div>
        </div>

        <fieldset class="custom-form__group">
          <input type="checkbox" name="new" id="new" class="custom-form__checkbox" 
          <?php
          if(isset($_GET['new']) && $_GET['new'] == 'on') {
              echo "checked";
          }
          ?>>
          <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
          <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" 
          <?php
          if(isset($_GET['sale']) && $_GET['sale'] == 'on') {
              echo "checked";
          }
          ?>>
          <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
        </fieldset>

        <input type="text" hidden name="goods_on_page" value="<?=GOODS_ON_PAGE ?>">

        <button class="button" type="submit" style="width: 100%">Применить</button>
      </form>
    </section>