<?php

function templates_include_layout(bool $is_auth, ?string $user_name, array $categories): array
{
    return [
        'header' => include_template('header.php', [
            'title' => 'YetiCave',
            'is_auth' => $is_auth,
            'user_name' => $user_name
        ]),
        'top_menu' => include_template('top-menu.php', [
            'categories' => $categories
        ])
    ];
}

function print_page(string $content, mysqli $connection): void
{
    $categories = get_categories($connection);
    $is_auth = database_isAuth();
    $user_name = database_username($connection);
    
    $layout = templates_include_layout($is_auth, $user_name, $categories);
    
    $page_content = include_template('layout.php', [
        'header' => $layout['header'],
        'top_menu' => $layout['top_menu'],
        'main_content' => $content,
        'single_lot_content' => '',
        'categories' => $categories
    ]);

    print($page_content);
}