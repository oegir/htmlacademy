<?php
require_once('src/helpers.php');
require_once('src/database.php');
require_once('src/functions.php');
require_once('src/templates.php');

$required = ['lot-name', 'lot-category', 'lot-description', 'lot-rate', 'lot-step', 'lot-date'];
$errors = [];
$cats_ids = array_column($categories, 'id');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
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

    $addLot = filter_input_array(INPUT_POST, [
        'lot-name' => FILTER_DEFAULT, 
        'lot-category' => FILTER_DEFAULT,
        'lot-description' => FILTER_DEFAULT,
        'lot-img' => FILTER_DEFAULT,
        'lot-rate' => FILTER_DEFAULT,
        'lot-step' => FILTER_DEFAULT,
        'lot-date' => FILTER_DEFAULT
    ], true);

    foreach ($addLot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Это поле надо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (!empty($_FILES['lot-img']['name'])) {
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        if ($_FILES['lot-img']['size'] > UPLOAD_MAX_SIZE) {
            $errors['lot-img'] = "Превышен максимальный размер файла 2 мб";
        }
        $filename = $_FILES['lot-img']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
        $mimetype = ['image/jpg', 'image/jpeg', 'image/png'];
        if (!in_array($file_type, $mimetype)) {
			$errors['lot-img'] = "Загрузите картинку в формате JPG или PNG";
		}
	}
    else {
		$errors['lot-img'] = "Вы не загрузили файл";
	}

    if (count($errors)) {
		$content = include_template('add.php', ['errors' => $errors, 'categories' => $categories]);
	}
    else {
    move_uploaded_file($tmp_name, 'uploads/' . $filename);
	$addLot['lot-img'] = "uploads/" . $filename;
    $result = 'INSERT INTO lot (`create`, `heading`, `category_id`, `description`, `image`, `first_price`, `price_step`, `finish`, `user_id`) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 1)';
    
    $stmt = db_get_prepare_stmt($connection, $result, $addLot);
    $res = mysqli_stmt_execute($stmt);
    var_dump($res);
    if ($res) {
    $last_lot_id = mysqli_insert_id($connection);
    header('Location: lot.php?id=' . $last_lot_id);
    }
    else {
        $error = "Не удалось добавить новый лот";
        show_error($content, $error); 
    }
 }

}

else {
$content = include_template ('add.php', [
    'errors' => $errors, 
    'categories' => $categories
]);
}
$page_content = include_template ('layout.php', [ 
    'header' => $header, 
    'top_menu' => $top_menu, 
    'main_content' => $content, 
    'single_lot_content' => '',
    'categories' => $categories
]);

print($page_content);

