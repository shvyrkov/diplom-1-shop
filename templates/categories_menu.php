<ul class="filter__list">
<?php
foreach ($array as $value) {
?>
    <li>
      <a class="filter__list-item 
        <?php if (isCurrentUrl($value['path'])): ?>
            active
        <?php endif; ?>
    "href="<?=$value['path']?>"><?=$value['title']?></a>
    </li>

<?php
}
?>
</ul>