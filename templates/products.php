<section class="shop__list" id="products">
<?php 
if (isset($products)) {
    foreach ($products as $key => $product) { // Вывод товаров из БД.
?>
        <article class="shop__item product" tabindex="0">
          <div class="product__image">
            <img src="/img/products/<?=$product['image'] ?>" alt="<?=$product['name'] ?>">
          </div>
          <p class="product__id" hidden="" id="<?=$product['id'] ?>"><?=$product['id'] ?></p>
          <p class="product__name"><?=$product['name'] ?></p>
          <span class="product__price" data_price="<?=$product['price'] ?>"><?=$product['price'] ?> руб.</span>
        </article>
<?php 
    }
} else {
    echo "<h2>Товаров нет</h2>";
}
?>
</section>