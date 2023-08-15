<?php
/**
* Функция получения активного пункта меню из URL
*
* @param string $url - данные пункта меню array['path']
* 
* @return bool - true, если $_SERVER["REQUEST_URI"] == $url
*/
function isCurrentUrl(string $url = '/'): bool
{
    return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) == $url;
}

/**
* Функция получения активного пункта меню из GET-запроса - 
*
* @param string $request - данные из $main_menu['path'] - пункт меню
* 
* @return bool - true, если $_SERVER["REQUEST_URI"] содержит $main_menu['path'] - пункт меню
*/
function isCurrentPath(string $request = ' '): bool
{
    $result = false;
    $query = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY ); // GET-запрос
    $requests = ['/?new=on', '/?sale=on']; // Возможные варианты GET-запросов // @TODO: вынести в CONFIG

    if (in_array($request, $requests)) { // Если в меню пункт /?new=on или /?sale=on
        $request = preg_replace('~/\?~', '', $request); // Убираем '/?'
        $result = in_array($request, explode("&", $query)); // Сравнить пункт меню и строку запроса: содержит ли 'new=on' или 'sale=on'
    }

    if (!in_array($query, ['new=on', 'sale=on'])) { // Если в строке нет get-запросов ['new=on', 'sale=on'], то переходим на Главную или по др.URL (чтобы одновременно не горели "Главная", "Ноинки" и "Распродажа")
         $result = isCurrentUrl($request);
    }

    return $result;
}


/**
* Функция вывода заголовка страницы
*
* @param array $menu - массив с данными меню
* 
* @return string - заголовок страницы
*/
function showTitle(array $menu) {
    $title = '';
    foreach ($menu as $value) {
        if (isCurrentUrl($value['path'])) {
            $title =  $value['title'];
        }
    }
    return $title;
}

/**
* Функция вывода разделов меню в верстке
*
* @param array $array - массив с данными меню
* @param string $menuType - тип меню (header - верхнее покупателя, footer - нижнее общее, back - боковые..., admin - для админки)
*/
function showMenu(array $array, string $menuType = 'header') {

    if ($menuType == 'header') { // Для верхнего меню пользователя
        include $_SERVER['DOCUMENT_ROOT'] . '/templates/header_menu.php';
    }

    if ($menuType == 'footer') { // Для общего нижнего меню
        include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer_menu.php';
    }

    if ($menuType == 'categories') { // Для меню категорий
        include $_SERVER['DOCUMENT_ROOT'] . '/templates/categories_menu.php';
    }

    if ($menuType == 'admin') { // @TODO: верхнее меню админки...
       include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/admin_menu.php';
    }
}

/**
* Функция получения cat_name текущей категории товара
*
* @param array $categories - массив с данными категорий
* @return string - $category - cat_name текущей категории
*/
function getCurrentCategory($categories) {

  foreach ($categories as $value) {
    $category = '';

    if (isCurrentUrl($value['path'])) { // Получаем cat_name текущей категории 

      return $category = $value['cat_name'];
    }
  }
}

/**
* Функция перевода байтов в Mb, kB или b в зависимости от их количества
*
* @param int $bytes - количество байт
* 
* @return string $bytes - количество байт, переведенное в Mb, kB или b в зависимости от их количества
*/
function formatSize($bytes) {

    if ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' Mb';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' Kb';
    } else {
        $bytes = $bytes . ' b';
    }

    return $bytes;
}

/**
* Функция сортировки массива (? Не уверен, что это надо... сортировка будет в БД)
*
* @param array $array - входной массив для сортировки 
* @param string $key - ключ элементов этого массива, по которому будет осуществлена сортировка (sort или title)
* @param string $sort - направление сортировки по возрастанию/по убыванию  (SORT_ASC или SORT_DESC)
*
* @return array $array - отсортированный массив в формате array
*/
function arraySort(array $array, $key = 'sort', $sort = SORT_ASC): array
{
    array_multisort(array_column($array, $key), $sort, SORT_NATURAL, $array);

    return $array; // arraySorted
}
