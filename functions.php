<?php

/**
 * Callback-функция для провалившего проверку утверждения
 * @param string $file Файл, в котором была вызвана assert()
 * @param int $line Строка, в которой была вызвана assert()
 * @param string $assertion Утверждение, которое было передано в assert(), преобразованное в строку
 * @param string $message Описание, которое было передано в assert()
 * 
 * @return void
 */
function assert_handler($file, $line, $assertion, $message): void
{
    echo "Проверка $assertion в $file на строке $line провалена: $message<hr>";
}
