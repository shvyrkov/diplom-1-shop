<?php

/**
* Функция получения массива Заказов по заданным параметрам.
*
* @param int - $limit - количество товаров
* @param int - $offset - с какой позиции начинать вывод
*
* @return mixed - array - массив с полученными из БД данными
*               - bool(false) - при ошибке получения данных
*/
function getOrders(
        int $limit = GOODS_ON_PAGE,
        int $offset = 0
    )
{
    $sqlRequestString = "SELECT o.* FROM orders AS o "; // Строка запроса

    $sqlRequestString = $sqlRequestString . ' ORDER BY o.status ASC, o.created DESC'; // сначала выводятся все необработанные заказы (status = 0),  а затем обработанные (status = 1), далее по убыванию даты создания.

    $sqlRequestString = $sqlRequestString . ' LIMIT ' . $limit . ' OFFSET ' .$offset;

    return getArrayFromDBObject(mysqli_query(dbConnect(), "$sqlRequestString"));
}

/**
* Функция изменения статуса заказа в БД
*
* @param string $id - id-заказа
* @param string $orderStatus - новый статус
*
* @return mixed $newOrderStatus - bool (true) - в случае удачного изменения статуса заказа в БД, 
*                            - string - сообщения об ошибке при подключении или записи
*/
function changeStatus($id, $orderStatus) {
    $newOrderStatus = false;

    if (dbConnect()) { // Если соединение с БД установлено

        $id = mysqli_real_escape_string(dbConnect(), $id);
        $orderStatus = mysqli_real_escape_string(dbConnect(), $orderStatus);
        $sqlRequestString = "UPDATE orders SET status = $orderStatus WHERE id = $id";

        if (mysqli_query(dbConnect(),$sqlRequestString)) { // Если сообщение внесено в БД
            $newOrderStatus = true;
        } else {
            // Получить ошибку записи
            $newOrderStatus = mysqli_error(dbConnect()); // ???
        }

    } else {
        // Получить ошибку подключения к БД
        $newOrderStatus = mysqli_connect_error();
    }

    return $newOrderStatus;
}

/**
* Функция получения массива Товаров по заданным параметрам.
*
* @param int - $limit - количество товаров
* @param int - $offset - с какой позиции начинать вывод
*
* @return mixed - array - массив с полученными из БД данными
*               - bool(false) - при ошибке получения данных
*/
function getProducts(
        int $limit = GOODS_ON_PAGE,
        int $offset = 0
    )
{
    $sqlRequestString = "SELECT * FROM products ";

    $sqlRequestString = $sqlRequestString . ' LIMIT ' . $limit . ' OFFSET ' .$offset; // Не работает, т.к. массив с дублированием товаров по категориям

    $products = getArrayFromDBObject(mysqli_query(dbConnect(), "$sqlRequestString"));

// Запрос категорий товара по id
    foreach ($products as $key => &$product) { // 

        $id =$product['id'];

        $sqlRequestString = "SELECT c.russian_name AS category FROM products AS p
          INNER JOIN category_product AS cp ON cp.product_id = p.id
          INNER JOIN categories AS c ON c.id = cp.category_id
          WHERE p.id = $id";

        // $categories = getArrayFromDBObject(mysqli_query(dbConnect(), "$sqlRequestString")); // Данные о категориях товара
        // $categories_column = array_column($categories, 'category'); // Данные о категориях товара
        // $product['categories'] = $categories_column;
        $product['categories'] = array_column(getArrayFromDBObject(mysqli_query(dbConnect(), "$sqlRequestString")), 'category'); // Добавляем данные о категориях товара
    }

    return $products;
}

/**
* Функция получения данных товара по id.
*
* @param int - $id - id-товара
*
* @return mixed - array - массив с полученными из БД данными
*               - bool(false) - при ошибке получения данных
*/
function getProduct(int $id = 0)
{
    $sqlRequestStringProd = "SELECT p.* FROM products AS p
                            WHERE p.id = $id"; // Строка запроса для товара

    $sqlRequestStringCat = "SELECT c.name AS category FROM products AS p
                            INNER JOIN category_product AS cp ON cp.product_id = p.id
                            INNER JOIN categories AS c ON cp.category_id = c.id 
                            WHERE p.id = $id"; // Строка запроса для категорий

    $product = mysqli_fetch_assoc(mysqli_query(dbConnect(), "$sqlRequestStringProd")); // Данные о товаре

    $result = mysqli_query(dbConnect(), "$sqlRequestStringCat");
    /* получение массива с категориями товара */
    while ($row = mysqli_fetch_row($result)) {
        $product['categories'][] = $row[0];
    }

    return $product;
}

/**
* Функция добавления товара.
*
* @param int - $id - id-товара
* @param string - $name - название товара
* @param float - $price - цена товара
* @param bool - $image - наличие файла с изображением товара (есть - true, нет - false)
* @param int - $new - новинка
* @param int - $sale - распродажа
* @param array - $categories - категории, к которым принадлежит товар
*
* @return array - ['fileName' => имя файла с фото товара, 'result' => true- если удачно, false - если нет]
*/
function addProduct(int $id = 0, 
                    string $name = '',
                    float $price = 0, 
                    // string $image = 'noPhoto.jpg', 
                    bool $image = false,
                    int $new = 0, 
                    int $sale = 0, 
                    array $categories = [0 => 1])
{
    $fileName = 'product-0.jpg'; // Имя файла по умолчанию

    $sqlRequestString = "INSERT INTO products (name, price, image, new, sale) 
                                    VALUES ('$name', $price, '$fileName', $new, $sale)"; // Строка запроса для добавления товара

    $result = mysqli_query(dbConnect(), "$sqlRequestString"); // Вносим данные о товаре в products

    if ($result) { // Данные в БД были загружены нормально
        $resultId = mysqli_query(dbConnect(), "SELECT LAST_INSERT_ID()"); // Получаем новый id
        $idArr = mysqli_fetch_assoc($resultId);

        if ($idArr) { // Если новый id получен
            $id = (int) $idArr["LAST_INSERT_ID()"];

            if ($categories) { // Добавляем категории, если они есть
                $sqlRequestString = "INSERT INTO category_product (category_id, product_id) VALUES ";

                for ($i = 0; $i < count($categories); $i++) { 

                    $sqlRequestString = $sqlRequestString . '(' . $categories[$i] . ', ' . $id . ')'; // Добавляем новую пару товар-категория

                    if ($i != (count($categories) - 1)) {
                        $sqlRequestString = $sqlRequestString . ', '; // После последней пары запятая не нужна
                    }
                }

                $resultCatProd = mysqli_query(dbConnect(), "$sqlRequestString"); // Вносим данные о категориях товара в category_product
            }

// Если есть файл для загрузки, то создаем имя файла с изображением product-$id и возвращаем его в обработчик, чтобы сохранить файл с тем же id.
// Если нет изображения для загрузки, то запрос не нужен
            if ($image) { // Если есть файл для загрузки
                $fileName = 'product-' . $id . '.jpg'; // Формируем имя файла

                $sqlRequestString = "UPDATE products SET image = '$fileName' WHERE id = $id";

                $resultFile = mysqli_query(dbConnect(), "$sqlRequestString"); // Меняем имя файла с изображением на product-$id

                return ['fileName' => $fileName, 'loadResult' => $resultFile]; // Изменение имени файла

            } else {

                return ['fileName' => $fileName, 'loadResult' => $result]; // Загрузка в БД с именем файла по умолчанию
            }

        } else{ // ! $resultId)

            return ['loadMessage' => $resultId, 'loadResult' => false]; // Сообщение ошибке
        }

    } else { // ! $result)

        return ['loadMessage' => $result, 'loadResult' => false]; // Сообщение ошибке
    }
}

/**
* Функция редактирования товара.
*
* @param int - $id - id-товара
* @param string - $name - название товара
* @param float - $price - цена товара
* @param bool - $image - наличие файла с изображением товара (есть - true, нет - false)
* @param int - $new - новинка
* @param int - $sale - распродажа
* @param array - $categories - категории, к которым принадлежит товар
*
* @return array - ['fileName' => имя файла с фото товара, 'result' => true- если удачно, false - если нет]
*/
function editProduct(int $id = 0, 
                    string $name = '',
                    float $price = 0, 
                    bool $image = false,
                    int $new = 0, 
                    int $sale = 0, 
                    array $categories = [])
                    // array $categories = [0 => 1])
{
    // Если есть файл для загрузки, то создаем имя файла с изображением product-$id и возвращаем его в обработчик, чтобы сохранить файл с тем же именем.

// Если нет изображения для загрузки, поле image передавать в БД не надо.
    $sqlRequestString = "UPDATE products 
                            SET name = '$name', 
                                price = $price, 
                                new = $new, 
                                sale = $sale 
                        "; // Строка запроса для изменения товара

    $fileName = 'product-0.jpg'; // Имя файла по умолчанию

    if ($image) { // Если есть файл для загрузки
        $fileName = 'product-' . $id . '.jpg'; // Формируем имя файла
        $sqlRequestString = $sqlRequestString . ", image = '$fileName'"; // Добавляем поле с именем файла изображения
    }

    $sqlRequestString = $sqlRequestString . "WHERE id = $id";


    $result = mysqli_query(dbConnect(), "$sqlRequestString"); // Вносим данные о товаре в products

    if ($result) { // Данные в БД были загружены нормально

        if ($categories) {
            $sqlRequestString = "DELETE FROM category_product WHERE product_id = $id ";

            $result = mysqli_query(dbConnect(), "$sqlRequestString"); // Удаляем старые пары category-product

            if ($result) {
                $sqlRequestString = "INSERT INTO category_product (category_id, product_id) VALUES ";

                for ($i = 0; $i < count($categories); $i++) { 

                    $sqlRequestString = $sqlRequestString . '(' . $categories[$i] . ', ' . $id . ')'; // Добавляем новую пару товар-категория

                    if ($i != (count($categories) - 1)) {
                        $sqlRequestString = $sqlRequestString . ', '; // После последней пары запятая не нужна
                    }
                }

                $result = mysqli_query(dbConnect(), "$sqlRequestString"); // Вносим данные о категориях товара в category_product
            }
        }

        return ['fileName' => $fileName, 'loadResult' => $result];

    } else { // ! $result)

        return ['loadMessage' => $result, 'loadResult' => false]; // Сообщение ошибке
    }
}

/**
* Функция удаления (деактивации) товара.
*
* @param int - $id - id-товара
*
* @return bool - true- если удачно, false - если нет
*/
function deleteProduct(int $id = 0)
{
    $sqlRequestString = "UPDATE products SET deleted = 1 WHERE id = $id"; // Строка запроса для деактивации товара

    $result = mysqli_query(dbConnect(), "$sqlRequestString");

    return $result;
}

/**
* Функция получения количества строк в таблице
*
* @param string $table - имя таблицы в БД
*
* @return mixed - int - количество строк в таблице
                - bool false - в случае ошибки
*/
function countItems(string $table)
{
    $sqlRequestString = "SELECT COUNT(*) AS itemsQuantity FROM $table "; // Начальная строка запроса

    $itemsQuantity = mysqli_fetch_assoc(mysqli_query(dbConnect(), "$sqlRequestString")); // Это массив!

    return $itemsQuantity['itemsQuantity'];
}
