      <section class="shop__sorting">
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="sort_category" id="sort_column">
            <option hidden="">Сортировка</option>
            <option 
              <?php
              if (isset($_GET['sort_column']) && $_GET['sort_column'] == 'price') {
                echo "selected";
              } ?> value="price">По цене</option>
            <option 
              <?php
              if (isset($_GET['sort_column']) && $_GET['sort_column'] == 'name') {
                echo "selected";
              } ?> value="name">По названию</option>
          </select>
        </div>

        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="sort_direction" id="order">
            <option hidden="">Порядок</option>
            <option 
              <?php
              if (isset($_GET['order']) && $_GET['order'] == 'ASC') {
                echo "selected";
              } ?>  value="ASC">По возрастанию</option>
            <option 
              <?php
              if (isset($_GET['order']) && $_GET['order'] == 'DESC') {
                echo "selected";
              } ?> value="DESC">По убыванию</option>
          </select>
        </div>
        <p class="shop__sorting-res">Найдено <span class="res-sort"><?=$countProducts ?></span> моделей</p>
      </section>