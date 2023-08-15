<?php
/**
* Функция подключения к БД
*
* @return object $connection - объект подключения к БД
*/
function dbConnect() {
    $host = HOST; // Адрес сервера БД
    $user = USER; // Имя пользователя
    $password = PASSWORD; // Пароль пользователя
    $dbname = DB_NAME; // Название БД

    static $connection = null; // Переменная подключения к БД

    if (null === $connection) {
        // Создаём подключение к серверу БД
        // $connection = mysqli_connect($host, $user, $password, $dbname) or die('DB-connection error');
        $connection = mysqli_connect($host, $user, $password, $dbname);

        // Получаем информацию о типе используемого подключения
           // echo mysqli_get_host_info($connection);

        if (mysqli_connect_errno()) { // Если есть номер ошибки подключения к БД

            echo "<br>Ошибка подключения к БД: ";
            echo mysqli_connect_error(); // Печать текста ошибки
            echo "<br><br>";
        }
    }
    return $connection;
}

/**
* Функция преобразования объекта из запроса в БД в массив.
*
* @param object $dbObject - объект, полученный из запроса типа SELECT в БД
*
* @return mixed - array - массив с полученными данными из БД 
*               - bool(false) - при ошибке
*/
function getArrayFromDBObject($dbObject) {
    if (is_object($dbObject)) {
        $array = mysqli_fetch_all($dbObject, MYSQLI_ASSOC);

        return $array;
    }

    return false;
}

/**
* Функция получения массива товаров по заданным параметрам.
*
* @param string - $category - категория товара
* @param array - $categories - список категорий товаров
* @param int - $priceMin - минимальная цена
* @param int - $priceMax - максимальная цена
* @param bool - $new - новинки, если true
* @param bool - $sale - распродажа, если true
* @param string - $sort_column - столбец для сортировка
* @param string - $order - направление сортировки
* @param int - $limit - количество товаров
* @param int - $offset - с какой позиции начинать вывод
*
* @return mixed - array - массив с полученными из БД данными
*               - bool(false) - при ошибке получения данных
*/
function getProductsFromDB(string $category = 'All',
        array $categories = [
            [
               'title' => 'Все', // Название категории по русски
               'cat_name' => 'All', // Ссылочное название категории
               'sort' => 0, // Индекс сортировки (?)
            ]
        ],
        int $priceMin = PRICE_MIN,
        int $priceMax = PRICE_MAX,
        bool $new = false,
        bool $sale = false,
        string $sort_column = '',
        string $order = 'ASC',
        int $limit = GOODS_ON_PAGE,
        int $offset = 0
    )
{
    $sqlRequestString = "SELECT p.* FROM products AS p "; // Начальная строка запроса

    if ($category != $categories[0]['cat_name']) { // Если это товары по выбранной категории, а не полный список
        $sqlRequestString = $sqlRequestString . " INNER JOIN category_product AS c_p ON p.id = c_p.product_id
                                                INNER JOIN categories AS c ON c.id = c_p.category_id
                                                WHERE c.name = '$category'
                                                AND p.price >= $priceMin AND p.price <= $priceMax ";

    } else { // если это все товары сразу
        $sqlRequestString = $sqlRequestString . " WHERE p.price >= $priceMin AND p.price <= $priceMax ";
    }

    if ($new) { // Новинки
        $sqlRequestString = $sqlRequestString .' AND p.new = 1 ';
    }

    if ($sale) { // Распродажа
        $sqlRequestString = $sqlRequestString .' AND p.sale = 1 ';
    }

    if ($sort_column) { // Столбец для сортировки
        $sqlRequestString = $sqlRequestString . ' ORDER BY p.' . $sort_column . ' ' .$order;
    }

    $sqlRequestString = $sqlRequestString . ' LIMIT ' . $limit . ' OFFSET ' .$offset;

    $products = mysqli_query(dbConnect(), "$sqlRequestString");

    return getArrayFromDBObject($products);
}

/**
* Функция получения количества товаров в выборке
*
* @param string - $category - категория товара
* @param array - $categories - список категорий товаров
* @param int - $priceMin - минимальная цена
* @param int - $priceMax - максимальная цена
* @param bool - $new - новинки, если true
* @param bool - $sale - распродажа, если true
*
* @return mixed - array - массив с количеством товаров в выборке
*               - bool(false) - при ошибке получения данных
*/
function countProducts(string $category = 'All',  // @TODO: заменить название на getProductsFromDB
        array $categories = [
            [
               'title' => 'Все', // Название категории по русски
               'cat_name' => 'All', // Ссылочное название категории
               'sort' => 0, // Индекс сортировки (?)
            ]
        ],
        int $priceMin = PRICE_MIN,
        int $priceMax = PRICE_MAX,
        bool $new = false,
        bool $sale = false
    )
{
    $sqlRequestString = "SELECT COUNT(*) AS productsQuantity FROM products AS p "; // Начальная строка запроса

    if ($category != $categories[0]['cat_name']) { // Если это товары по выбранной категории, а не полный список
        $sqlRequestString = $sqlRequestString . " INNER JOIN category_product AS c_p ON p.id = c_p.product_id
                                                INNER JOIN categories AS c ON c.id = c_p.category_id
                                                WHERE c.name = '$category'
                                                AND p.price >= $priceMin AND p.price <= $priceMax ";

    } else { // если это все товары сразу
        $sqlRequestString = $sqlRequestString . " WHERE p.price >= $priceMin AND p.price <= $priceMax ";
    }

    if ($new) { // Новинки
        $sqlRequestString = $sqlRequestString .' AND p.new = 1 ';
    }

    if ($sale) { // Распродажа
        $sqlRequestString = $sqlRequestString .' AND p.sale = 1 ';
    }

    $countProducts = getArrayFromDBObject(mysqli_query(dbConnect(), "$sqlRequestString")); // Это массив!

    return $countProducts[0]['productsQuantity'];
}

/**
* Функция добавления заказа в БД
*
* @param string $surname - фамилия
* @param string $firstName - имя
* @param string $thirdName - отчество
* @param string $phone - телефон
* @param string $email - электронная почта
* @param string $delivery - тип доставки
* @param string $city - город доставки
* @param string $street - улица
* @param string $home - номер дома
* @param string $aprt - номер квартиры
* @param string $pay - тип оплаты
* @param string $comment - комментарий к заказу
* @param string $productId - id-товара
* @param string $productPrice - стоимость товара
* @param string $deliveryPrice - стоимость доставки
*
* @return mixed $orderSent - bool (true) - в случае удачного добавления заказа в БД, 
*                            - string - сообщения об ошибке при подключении или записи
*/
function addOrder($surname, $firstName, $thirdName, $phone, $email, $delivery, $city, $street, $home, $aprt, $pay, $comment, $productId, $productPrice, $deliveryPrice = 0) {
    $orderSent = false;

    if (dbConnect()) { // Если соединение с БД установлено

        $surname = mysqli_real_escape_string(dbConnect(), $surname);
        $firstName = mysqli_real_escape_string(dbConnect(), $firstName);
        $thirdName = mysqli_real_escape_string(dbConnect(), $thirdName);
        $phone = mysqli_real_escape_string(dbConnect(), $phone);
        $email = mysqli_real_escape_string(dbConnect(), $email);
        $delivery = mysqli_real_escape_string(dbConnect(), $delivery);
        $city = mysqli_real_escape_string(dbConnect(), $city);
        $street = mysqli_real_escape_string(dbConnect(), $street);
        $home = mysqli_real_escape_string(dbConnect(), $home);
        $aprt = mysqli_real_escape_string(dbConnect(), $aprt);
        $pay = mysqli_real_escape_string(dbConnect(), $pay);
        $comment = mysqli_real_escape_string(dbConnect(), $comment);
        $productId = mysqli_real_escape_string(dbConnect(), $productId);
        $productPrice = mysqli_real_escape_string(dbConnect(), $productPrice);
        $deliveryPrice = mysqli_real_escape_string(dbConnect(), $deliveryPrice);

        $result = mysqli_query(dbConnect(),
            "INSERT INTO orders (surname, firstName, thirdName, phone, email, delivery, city, street, home, aprt, pay, comment, productId, productPrice, deliveryPrice)
            VALUES ('$surname', '$firstName', '$thirdName', '$phone', '$email', '$delivery', '$city', '$street', '$home', '$aprt', '$pay', '$comment', '$productId', '$productPrice', '$deliveryPrice')
            ");

        if ($result) { // Если сообщение внесено в БД
            $orderSent = true;
        } else {
            // Получить ошибку записи
            $orderSent = mysqli_error(dbConnect()); // ???
        }

    } else {
        // Получить ошибку подключения к БД
        $orderSent = mysqli_connect_error();
    }

    return $orderSent;
}

/**
* Функция получения данных пользователя по логину
*
* @param string $login - login пользователя
*
*@return mixed - object - если пользователь существует
*              - bool(false) - если нет
*/
function getUserByLogin(string $login) {

    return mysqli_fetch_assoc(mysqli_query(dbConnect(), "SELECT * FROM users WHERE login = '$login'")); // Получение данных пользователя, если он есть. Значение поля "login" уникально.
}
