<?php

function assert_handler($file, $line, $assertion, $message)
{
    echo "Проверка $assertion в $file на строке $line провалена: $message<hr>";
}
