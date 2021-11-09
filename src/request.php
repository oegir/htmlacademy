<?php 

function requset_isPost(): bool
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function requset_getPostVal($name) {
    return filter_input(INPUT_POST, $name);
}

function requset_getGetInt(string $name, int $default = 0): int
{
    $value = filter_input(INPUT_GET, $name);
    
    if (! is_numeric($value)) {
        return $default;
    }
    return (int) $value;
}

/**
 * @param string $param_name file field name
 * 
 * @return array [
 *      'success' => true,
 *      'uploaded_name' => '',
 *      'error' => ''
 * ]
 */
function request_save_file(string $param_name): array
{
    $result = [
        'success' => true,
        'uploaded_name' => '',
        'error' => ''
    ];
    
    if (empty($_FILES[$param_name]['name'])) {
        $result['success'] = false;
        $result['error'] = 'Вы не загрузили файл';
        
        return $result;
    }
        
    $tmp_name = $_FILES[$param_name]['tmp_name'];
    
    if ($_FILES[$param_name]['size'] > UPLOAD_MAX_SIZE) {
        $result['success'] = false;
        $result['error'] = 'Превышен максимальный размер файла 2 мб';
        
        return $result;
    }
    
    $filename = $_FILES[$param_name]['name'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    $mimetype = ['image/jpg', 'image/jpeg', 'image/png'];
    
    if (!in_array($file_type, $mimetype)) {
        $result['success'] = false;
        $result['error'] = 'Загрузите картинку в формате JPG или PNG';
        
        return $result;
    }
    
    $result['uploaded_name'] = 'uploads/' . $filename;
    move_uploaded_file($tmp_name, $result['uploaded_name']);
    
    return $result;
}