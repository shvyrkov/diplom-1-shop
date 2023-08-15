<ul class="shop__paginator paginator">
<?php
for ($i=1; $i <= ceil($countProducts / GOODS_ON_PAGE); $i++) { 
?>
        <li id="<?=$i ?>">
          <a class="paginator__item" 
    <?php
    if (!isset($_GET['page_number'])) { // При первом заходе - если это не первая страница, то нужна ссылка.
        if ($i != 1) {
    ?>
            href="?page_number=<?=$i ?>"
    <?php
        }
    // После выбора страницы - берётся из URL при обновлении страницы.
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
