<?php
require_once('src/request.php');
require_once('src/helpers.php');
require_once('src/database.php');
require_once('src/functions.php');
require_once('src/templates.php');

/*
 * Получение данных - Controller
 */

$connection = database_get_connection();
$categories = get_categories($connection);

$errors = [];
$lotId = null;

if (requset_isPost()) {
    $addLot = getFormData();
    $errors = validateFormData($addLot, array_column($categories, 'id'));
    $uploaded = request_save_file('lot-img');
    $addLot = correctStoredFileName($errors, $uploaded, $addLot);
    
    if (empty($errors)) {
        $lotId = saveLot($connection, $addLot);
        
        if (!is_null($lotId)) {
            header('Location: lot.php?id=' . $lotId);
            exit();
        }
    }
}

/*
 * Отображение View
 */
$content = '';

if (requset_isPost() && is_null($lotId)) {
    $content = show_error($content, 'Не удалось добавить новый лот');
} else {
    $content = include_template ('add.php', [
        'errors' => $errors,
        'categories' => $categories,
    ]);
}

print_page($content, $connection);

/*
 * Бизнес-логика - Model
 */

function getFormData(): array
{
    return filter_input_array(INPUT_POST, [
        'lot-name' => FILTER_DEFAULT,
        'lot-category' => FILTER_DEFAULT,
        'lot-description' => FILTER_DEFAULT,
        'lot-img' => FILTER_DEFAULT,
        'lot-rate' => FILTER_DEFAULT,
        'lot-step' => FILTER_DEFAULT,
        'lot-date' => FILTER_DEFAULT
    ], true);
}

/**
 * Change temporary file name with stored one
 * 
 * @param array $uploaded
 * @param array $addLot
 * @return array
 */
function correctStoredFileName(array &$errors, array $uploaded, array $addLot): array
{
    if (!$uploaded['success']) {
        $errors['lot-img'] = $uploaded['error'];
    }
    $addLot['lot-img'] = $uploaded['uploaded_name'];
    
    return $addLot;
}

/**
 * Validate incoming values
 * 
 * @param array $addLot add lot form data
 * @param array $cats_ids list of existing categories ids
 * @return array errors list
 */
function validateFormData(array $addLot, array $cats_ids): array
{
    $required = ['lot-name', 'lot-category', 'lot-description', 'lot-rate', 'lot-step', 'lot-date'];
    $errors = [];
    
    $rules = [
        'lot-name' => function($value) {
        return validateLength($value, 5, 200);
        },
        'lot-category' => function($value) use ($cats_ids) {
        return validateCategory($value, $cats_ids);
        },
        'lot-description' => function($value) {
        return validateLength($value, 5, 3000);
        },
        'lot-rate' => function($value) {
        return validateNumeric($value);
        },
        'lot-step' => function($value) {
        return validateNumeric($value);
        },
        'lot-date' => function($value) {
        return validateDate($value);
        }
    ];
    
    foreach ($addLot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
        
        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Это поле надо заполнить";
        }
    }
    
    return array_filter($errors);
}

/**
 * 
 * @param mysqli $connection
 * @param array $addLot add lot form data
 * 
 * @return int|NULL
 */
function saveLot(mysqli $connection, array $addLot): ?int
{
    $result = 'INSERT INTO lot (`create`, `heading`, `category_id`, `description`, `image`, `first_price`, `price_step`, `finish`, `user_id`) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 1)';

    $stmt = db_get_prepare_stmt($connection, $result, $addLot);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        return mysqli_insert_id($connection);
    }

    return null;
}

