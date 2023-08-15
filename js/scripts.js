'use strict';

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

// Оформление заказа------------------------------------------------------------------------------------
const shopList = document.querySelector('.shop__list');
if (shopList) {

  shopList.addEventListener('click', (evt) => { // Выбор товара

    const prod = evt.path || (evt.composedPath && evt.composedPath());;

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button'); // Кнопка Отправить заказ
      const popupEnd = document.querySelector('.shop-page__popup-end'); // Окно подтверждения создания заказа

      var productId = $('.shop__item:focus').children(".product__id").text(); // id-товара
      var productPrice = $('.shop__item:focus').children(".product__price").attr('data_price'); // Стоимость товара

      buttonOrder.addEventListener('click', (evt) => { // отправка формы заказа

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

        inputs.forEach(inp => {

          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {

          evt.preventDefault(); // предотвращаем ее отправку/предотвращает открытие новой страницы

          var details = $('.custom-form').serialize(); // сериализуем данные формы заказа
          details = details + '&productId=' + productId + '&productPrice=' + productPrice; // Добавляем id-товара и Стоимость товара

          $.post('/handlers/shopOrder.php', details, function(data){ // Обработчик формы - вносим данные в БД
            // $('#test').html(data); // Вывод результата не нужен, просто отправляем данные на сервер (пока...) - Ok
          });
          toggleHidden(shopOrder, popupEnd);

          popupEnd.classList.add('fade');
          setTimeout(() => popupEnd.classList.remove('fade'), 1000);

          window.scroll(0, 0);

          const buttonEnd = popupEnd.querySelector('.button'); // Кнопка Продолжить покупки

          buttonEnd.addEventListener('click', () => {


            popupEnd.classList.add('fade-reverse');

            setTimeout(() => {

              popupEnd.classList.remove('fade-reverse');

              toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

            }, 1000);

            $('.custom-form')[0].reset(); // Сброс формы
          });

        } else {
          window.scroll(0, 0);
          evt.preventDefault();

        }
      });
    }
  });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => { // Раскрытие заказа


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => { // Вывод всех элементов заказа

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) { // Изменение статуса заказа

      const status = evt.target.previousElementSibling;

      var orderStatus = 0;

      if (status.classList && status.classList.contains('order-item__info--no')) {
        status.textContent = 'Выполнено';
        orderStatus = 1;
      } 
      // else {
      //   status.textContent = 'Не выполнено';
      //   orderStatus = 0;
      // }
      if ((status.classList && status.classList.contains('order-item__info--yes'))) {
        status.textContent = 'Не выполнено';
        orderStatus = 0;
      }

      status.classList.toggle('order-item__info--no');
      status.classList.toggle('order-item__info--yes');

      var id = 0; // id-заказа
      id = $('.order-item--active .order-item__info--id').text();

      $.ajax({
        url: '/admin/handlers/changeStatus.php',
        type: "POST",
        data: {orderStatus: orderStatus,
               id: id},
        success: function(data) {
          console.log(data);
        }
      });

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list'); // <ul class="add-list"> - содержит <li> c фото
if (addList) {

  const form = document.querySelector('.custom-form'); // <form class="custom-form"  - форма
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add'); // <li class="add-list__item add-list__item--add" >
  const addInput = addList.querySelector('#product-photo'); // <input type="file" name="product-photo" id="product-photo" 

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => { // Если было добавлено изображение

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

// Форма на добавление/изменение товара---------------------------------------------------------------------------------------------
  const button = document.querySelector('.button'); // Кнопка добавления
  const popupEnd = document.querySelector('.page-add__popup-end'); // Результат добавления

  button.addEventListener('click', (evt) => { // Нажатие кнопки Добавить

    evt.preventDefault();

    var result_data = $('#test_product_data'); // Элемент, в который выводим ответ сервера
    result_data.html(''); // Очистка содержимого "Test product_data"
    var result_photo = $('#test_product_photo');
    result_photo.html(''); // Очистка содержимого "Test product_photo"

    var productInfo = document.forms.namedItem("product-info"); // Получаем данные формы
    var formData = new FormData(productInfo); // Вносим данные формы в объект FormData

    $.ajax({ // выполняем HTTP (AJAX) запрос
      url: '/admin/handlers/changeProduct.php',
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function(data) {
        let value = JSON.parse(data); // Преобразуем JSON в объект

        if (!value.loadResult) { // Если изменение/добавление товара не прошло
          var result_title = $('.shop-page__end-title');
          result_title.text('Товар не был изменен/добавлен');
          result_photo.text(value.loadMessage); // Сообщение сервера об ошибке.
         }
      }
    });
    form.hidden = true;
    popupEnd.hidden = false;
  })
}

// Удаление товара--------------------------------------------------------------------------------------
const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', evt => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) { // Нажат знак удаления

      productsList.removeChild(target.parentElement); // Удаление товара из списка на странице

      // Деактивация товара в БД (products.deleted = 1)
      var prod_id = target.getAttribute('data_id'); // Получаем id-товара

      var delete_result = $('#delete_result'); // Результат удаления товара
      delete_result.text(''); 

      evt.preventDefault();
      $.ajax({ // выполняем HTTP (AJAX) запрос
          url: '/admin/handlers/deleteProduct.php',
          data: {'product-id' : prod_id},
          type: 'POST',
          success: function(data) {
            delete_result.append("Результат удаления товара: " + data);
          }
      });
    }
  });
}

//---------------------------------Ползунки--------------------------------------------------------------
// jquery range maxmin


if (document.querySelector('.shop-page')) {

  // let priceMin = $('.min-price').attr('data'); 
  // let priceMax = $('.max-price').attr('data');

  // alert(priceMin); // 350
  // alert(priceMax); // 32000

// var div = $(".range__line");
// var min = $(".min-price");
// var max = $(".max-price");
// alert( min.attr("slider-min"));
// alert( max.attr("slider-max"));

  $('.range__line').slider({ // C AJAX всё работает! Страница не перегружается и положение ползунков не меняется!

    min: 350, // Минимальное значение ползунка.
    // min: min.attr("slider-min"), // Минимальное значение ползунка.
    max: 32000, // Максимальное значение ползунка.
    // max: div.attr("slider-max"), // Максимальное значение ползунка.

    values: [350, 32000], // Начальные значения ползунков, если их два, например [ 10, 20 ] - используются для задания Положения ползунков (не Значения!)
    range: true, // Значение true включит второй ползунок и диапазон между ними, "min" - диапазон от минимума шкалы до ползунка, "max" - диапазон от ползунка до максимума шкалы

    stop: function(event, ui) {
      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.'); // Передача значения на страницу при остановке 1-го ползунка (0)
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.'); // Передача значения на страницу при остановке 2-го ползунка (1)

      $("#min_price").val($(".range__line").slider('values', 0)); // Передача мин. значения ползунка 1 в форму
      $("#max_price").val($(".range__line").slider('values', 1)); // Передача макс. значения ползунка 2 в форму
    },

    slide: function(event, ui) {
      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.'); // Передача значения на страницу при движении ползунка
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
    }
  });
}

// ---------------AJAX для отправки формы с фильтрами и сортировкой, а также предотвращения перезагрузки страницы и сброса положения ползунков.-----------
$('#request').on('submit', function(e){ // При отправке формы 

  let sort_column = 'default';
  sort_column = $('#sort_column').val(); // Запрос данных типа сортировки

  let order = 'default';
  order = $('select[id=order]').val(); // Запрос данных направления сортировки

  e.preventDefault(); // предотвращаем ее отправку/предотвращает открытие новой страницы
  var details = $('#request').serialize(); // и сериализуем ее данные.

  details = details + '&sort_column=' + sort_column + '&order=' + order; // Добавляем данные сортировки
  details = details + '&page_number=' + 1; // Добавляем данные для пагинации: после применения фильтра - всегда на 1-ю страницу

  $.get('/handlers/getProducts.php', details, function(data){ // Обработчик формы, который выводит только запрашиваемые товары
    $('#products').html(data); // Вывод результата запроса по метке #products
  });

  $.get('/handlers/countProducts.php', details, function(data){ // Запрос количества выбранных товаров
    $('.res-sort').text(data); // Вывод количества выбранных товаров в вёрстку

    let goods_quantity = 0; // Количество товаров выборке
    goods_quantity = data;

    let goods_on_page = 6; // Количество товаров на странице
    goods_on_page = $('input[name=goods_on_page]').val(); // Получаем текущее количество товаров на странице из PHP-константы GOODS_ON_PAGE

    var page_quantity = Math.ceil(goods_quantity / goods_on_page); // Количество страниц при условии GOODS_ON_PAGE товаров на странице

    let paginator_html = '';

    for (var i = 1; i <= page_quantity; i++) { // Формируем новый HTML для пагинации
      var page_html = '<li id=' + i + '><a class="paginator__item" '; // Ok!!!

      if (i != 1) { // Если это не 1-я страница, то нужна ссылка 
        page_html = page_html + 'href="?page_number=' + i + '">' + i + '</a></li>'; 
      } else {
        page_html = page_html + '>' + i + '</a></li>'; 
      }
      paginator_html = paginator_html + page_html;
    }

    $('.paginator').html(paginator_html); // Обновляем пагинацию.
  });

  history.pushState({}, '', '?' + details); // добавить get-запрос в url: если страница будет обновлена, данные вывода сохранятся.
});

// ---------------AJAX для сортировки---------------------
$('#order').on('click', function(e) { // Выбор напрвления сортировки

  let sort_column = 'default';
  sort_column = $('#sort_column').val(); // price/name.

  let order = 'default';
  order = $('select[id=order]').val(); // ASC/DESC

  e.preventDefault(); // предотвращаем ее отправку/предотвращает открытие новой страницы
  var details = $('#request').serialize(); // и сериализуем данные формы

  details = details + '&sort_column=' + sort_column + '&order=' + order; // Добавляем данные сортировки
  details = details + '&page_number=' + 1; // Добавляем данные для пагинации: после применения фильтра - всегда на 1-ю страницу

  $.get('/handlers/getProducts.php', details, function(data){ // Обработчик формы, который выводит только запрашиваемые товары
    $('#products').html(data); // Вывод результата запроса по метке #products
  });

  $.get('/handlers/countProducts.php', details, function(data){ // Запрос количества выбранных товаров
    $('.res-sort').text(data); // Вывод количества выбранных товаров в вёрстку
    let goods_quantity = 0; // Количество товаров выборке
    goods_quantity = data;

    let goods_on_page = 6; // Количество товаров на странице
    goods_on_page = $('input[name=goods_on_page]').val(); // Получаем текущее количество товаров на странице из PHP-константы GOODS_ON_PAGE

    var page_quantity = Math.ceil(goods_quantity / goods_on_page); // Количество страниц при условии GOODS_ON_PAGE товаров на странице

    let paginator_html = '';

      for (var i = 1; i <= page_quantity; i++) { // Формируем новый HTML для пагинации
        var page_html = '<li id=' + i + '><a class="paginator__item" '; // Ok!!!

        if (i != 1) { // Если это не 1-я страница, то нужна ссылка 
          page_html = page_html + 'href="?page_number=' + i + '">' + i + '</a></li>'; 
        } else {
          page_html = page_html + '>' + i + '</a></li>'; 
        }
        paginator_html = paginator_html + page_html;
      }

      $('.paginator').html(paginator_html); // Обновляем пагинацию.
  });
 // Формируем новый HTML для сортировки.
  var sort_html = '<option hidden="">Сортировка</option><option ';
  if (sort_column == "price") { sort_html = sort_html + 'selected'; }
  sort_html = sort_html + ' value="price">По цене</option><option ';
  if (sort_column == "name") { sort_html = sort_html + 'selected'; }
  sort_html = sort_html + ' value="name">По названию</option>';

  $('select[id=sort_column]').html(sort_html); // сохранить выбор параметра для сортировки

  var order_html = '<option hidden="">Порядок</option><option ';
  if (order == "ASC") { order_html = order_html + 'selected'; }
  order_html = order_html + ' value="ASC">По возрастанию</option><option ';
  if (order == "DESC") { order_html = order_html + 'selected'; }
  order_html = order_html + ' value="DESC">По убыванию</option>';

  $('select[id=order]').html(order_html); // сохранить выбор направления сортировки

  history.pushState({}, '', '?' + details); // добавить get-запрос в url: если страница будет обновлена, данные вывода сохранятся.
});

// ---------------AJAX для по-страничной навигации---------------------
$('.paginator').on('click', '.paginator__item[href]', function(e) { // Выбираем страницу.

  let page_number = 0;
  page_number = $('.paginator__item[href]:focus').text(); // Получаем номер страницы.

  let sort_column = 'default';
  sort_column = $('#sort_column').val(); // price/name.

  let order = 'default';
  order = $('select[id=order]').val(); // ASC/DESC

  e.preventDefault(); // предотвращаем ее отправку/предотвращает открытие новой страницы
  var details = $('#request').serialize(); // и сериализуем данные формы

  details = details + '&sort_column=' + sort_column + '&order=' + order; // Добавляем данные сортировки
  details = details  + '&page_number=' + page_number; // Добавляем номер строки

  $.get('/handlers/getProducts.php', details, function(data){ // Обработчик формы, который выводит только запрашиваемые товары
    $('#products').html(data);
  });

  let goods_quantity = 0; // Количество товаров выборке

  $.get('/handlers/countProducts.php', details, function(data){ // Запрос количества выбранных товаров
    $('.res-sort').text(data); // Вывод количества выбранных товаров в вёрстку

    let goods_quantity = 0; // Количество товаров в выборке
    goods_quantity = data;

    let goods_on_page = 6; // Количество товаров на странице
    goods_on_page = $('input[name=goods_on_page]').val(); // Получаем текущее количество товаров на странице из PHP-константы GOODS_ON_PAGE

    var page_quantity = Math.ceil(goods_quantity / goods_on_page); // Количество страниц при условии GOODS_ON_PAGE товаров на странице

    let paginator_html = '';

    for (var i = 1; i <= page_quantity; i++) { // Формируем новый HTML для пагинации

      var page_html = '<li id=' + i + '><a class="paginator__item" '; // Ok!!!

      if (i != page_number) { // Если номер тега <a> не совпадает с номером выбранной страницы, то ссылка нужна
        page_html = page_html + 'href="?page_number=' + i + '">' + i + '</a></li>'; 
      } else {
        page_html = page_html + '>' + i + '</a></li>'; 
      }
      paginator_html = paginator_html + page_html;
    }
    $('.paginator').html(paginator_html); // Обновление пагинации
  });

  history.pushState({}, '', '?' + details); // Добавляем get-запрос в url: если страница будет обновлена, данные вывода сохранятся.
});
