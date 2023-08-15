
<ul class="main-menu main-menu--footer">
<?php
foreach ($array as $value) {
?>
    <li>
      <a class="main-menu__item "href="<?=$value['path']?>"><?=$value['title']?></a>
    </li>
<?php
}
?>
</ul>
