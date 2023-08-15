    <ul class="main-menu main-menu--header">
      <?php
      foreach ($array as $value) {
        if ($_SESSION['accessProducts'] != true && $value['path'] == '/admin/products/') {
          continue; // Если не Админ, то нет доступа к Товарам
        }
      ?>
          <li>
            <a class="main-menu__item 
              <?php if (isCurrentPath($value['path'])): ?>
                  active
              <?php endif; ?>
          "href="<?=$value['path']?>"><?=$value['title']?> </a>
          </li>
      <?php
        
      }
      ?>
    </ul>