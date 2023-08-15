<!-- Pagination---------------------------------------------------------------------------------->
  <ul class="pagination"> 
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Страницы: </a>
    </li>
    <?php
    for ($i = 1; $i <= ceil($countItems / GOODS_ON_PAGE); $i++) { 
    ?>
    <li class="page-item 
      <?php
      if (!isset($_GET['page_number'])) { // При первом заходе и 
        if($i == 1) { // если это первая страница, то её надо выделить
          echo "active";
        }
      } elseif ($_GET['page_number'] == $i) { // Выбранная страница выделяется
          echo "active";
      }
      ?>
    " id="<?=$i ?>">

      <a class="paginator__item_admin page-link" 
      <?php
      if (!isset($_GET['page_number'])) { // При первом заходе и 
        if ($i != 1) { // если это не первая страница, то нужна ссылка.
      ?>
          href="?page_number=<?=$i ?>"
      <?php
        }
      // При выборе страницы её номер берётся из URL.
      } elseif ($_GET['page_number'] != $i) { // Если это не текущая страница, то нужна ссылка.
      ?>
              href="?page_number=<?=$i ?>"
      <?php
      }
      ?>
      ><?=$i ?></a>

    </li>
    <?php
    }
    ?>
  </ul>
  <br>
<!--------------------------------------------------------------------->