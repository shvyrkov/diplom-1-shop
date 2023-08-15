<?php
include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/dbFunctions.php'; // Функции для работы с БД
include $_SERVER['DOCUMENT_ROOT'] . '/include/dbFunctions.php'; // Функции для работы с БД
include $_SERVER['DOCUMENT_ROOT'] . '/include/pageFunctions.php'; // Функции для работы на странице

$loadMessage = 'Данные о товаре не отправлены'; // Сообщение об ошибке
$loadResult = false; //  Результат загрузки данных в БД
$validName = false; // Результат валидации названия
$validPrice = false; // Результат валидации цены
$validFile = true; // Результат валидации файла: если файла нет, то должно быть TRUE

if (isset($_POST['product-id'])) { // Форма отправлена

    $resultDB = []; // Результат загрузки в БД: ['fileName' => $fileName, 'result' => $result];

    $id = is_numeric($_POST['product-id']) ? $_POST['product-id'] : 0; // id - число

// Валидация :-------------------------------------------------------------------------------------------

// name: string, от 3 до 250 символов, обязательное поле
    if (empty($_POST['product-name'])) {
        $loadMessage = 'Название товара не задано'; // Сообщение об ошибке
    } else {
        $name = htmlentities($_POST['product-name']);

        if (mb_strlen($name) < 3) {
            $loadMessage = 'Название товара менее 3 символов';
        } elseif (mb_strlen($name ) > 250) {
            $loadMessage = 'Название товара более 250 символов';
        } else {
            $validName = true;
        }
    }

    if ($validName) { // Если валидация имени успешна, начинаем валидацию цены.
    // price: float, обязательное поле, < $priceMin = 350; // Минимальная цена, > $priceMax = 32000; // Максимальная цена
        if (empty($_POST['product-price']) || !is_numeric($_POST['product-price'])) {
            $loadMessage = 'Цена товара не задана или её значение не является числом'; // Сообщение об ошибке
        } else {
            $price = htmlentities($_POST['product-price']);

            if ($price < $priceMin) {
                $loadMessage = 'Цена товара меньше минимальной по умолчанию';
            } elseif ($price > $priceMax) {
                $loadMessage = 'Цена товара больше максимальной по умолчанию';
            } else {
                $validPrice = true;
            }
        }
    } // if ($validName...

    $img = $_FILES['product-photo']['size'] ? true : false; // Наличие файла с изображением 

    if ($validName && $validPrice && $img) { // Если валидация имени и цены успешна и есть файл, начинаем валидацию файла.
        $loadMessage = 'Временный файл не был загружен на сервер';

        if ($_FILES['product-photo']['error'] == UPLOAD_ERR_OK) { // если файл был успешно загружен на сервер, то

            $tmpName = $_FILES['product-photo']['tmp_name']; // Получаем данные для временного файла
            // Получаем расширение исходного файла
            $extension_file = mime_content_type($tmpName);// Проверяет тип файла   
            $fileSize = $_FILES['product-photo']['size']; // Получаем размер исходного файла

            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/img/products/'; // Путь к папке, куда будут загружаться файлы.
            // $fileTypes = ['image/jpeg', 'image/jpg', 'image/png']; // Допустимые типы файлов.
            $fileTypes = ['image/jpeg', 'image/jpg']; // Допустимые типы файлов - TEST
            $maxFileSize = 102400; // Максимальный допустимый размер загружаемого файла 100kB

        // Проверяем тип загружаемых файлов, это должны быть только картинки (jpeg, png, jpg).
            if (!in_array($extension_file, $fileTypes)) { 
                $loadMessage = 'Неправильный тип ' . $extension_file . ' загружаемого файла ';
                $validFile = false;
            }
        // Проверяем размер загружаемого файла (файл не должен превышать 5 Мб).
            if ($fileSize > $maxFileSize) { 
                $loadMessage = 'Файл не может быть загружен на сервер, так как его размер составляет ' . formatSize($fileSize) . ', что больше допустимых ' . formatSize($maxFileSize);
                $validFile = false;
            }

            if ($validFile) {
                $loadMessage = 'Временный файл удачно загружен на сервер';
            }
        } else {
            $validFile = false; // $loadMessage = 'Временный файл не был загружен на сервер';
        } // if ($_FILES...
    } // if ($validName && $validPrice && $img) ...

    $new = (isset($_POST['new']) && $_POST['new'] == 'on') ? 1 : 0;
    $sale = (isset($_POST['sale']) && $_POST['sale'] == 'on') ? 1 : 0;

    $categories = [];

    if (isset($_POST['categories'])) {
        foreach ($_POST['categories'] as $categoryName) { // category: female, category: children

            switch ($categoryName) { // Перевод как в БД
                case 'female':
                    $category = 1;
                    break;
                 case 'male':
                    $category = 2;
                    break;
                 case 'children':
                    $category = 3;
                    break;
                 case 'accessories':
                    $category = 4;
                    break;
                default:
                    $category = 1;
                    break;
            }
            $categories[] = $category;
        }
    }

// Загрузка данных в БД-------------------------------------------------------------------------------------------
    // $valid = $validName && $validPrice && $validFile; // Результат валидации имени, цены и файла.

    if ($validName && $validPrice && $validFile) { // Если валидация пройдена

        if ($id) { // Редактировние товара
            $resultDB = editProduct($id, $name, $price, $img, $new, $sale, $categories);
        } else { // Добавление товара
            $resultDB = addProduct($id, $name, $price, $img, $new, $sale, $categories);
        }

        if ($resultDB['loadResult']) { // Если данные по товару удачно внесены в БД, 
            $loadMessage = 'Данные о товаре загружены в БД';
            $loadResult = true; //  Результат загрузки данных в БД

            if ($img) { // Если есть файл, то загружаем его с новым именем на сервер
                $fileName = $resultDB['fileName']; // Имя файла с фото товара с новым id-товара 
                $loadResult = false; // Результат загрузки файла на сервер

                $fileMoved = move_uploaded_file($tmpName, $uploadPath . $fileName); // $tmpName - откуда, $uploadPath - куда, $fileName - под каким именем

                if ($fileMoved) {
                    $loadMessage = 'Файл ' . $fileName . ' удачно загружен на сервер';
                    $loadResult = true;
                } else {
                    $loadMessage = 'Файл ' . $fileName . ' не был загружен на сервер';
                }
            } // if ($img)

        } else { // Если товар не был загружен в БД - сообщение об ошибке по работе с БД
               $loadMessage = 'Произошел сбой в работе с БД';
        }
    } // Валидация
} // Отправка формы

$jsonResult = json_encode(['loadMessage' => $loadMessage, 'loadResult' => $loadResult], JSON_UNESCAPED_UNICODE);

echo $jsonResult; // Отправка результата в JS
