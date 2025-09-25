<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

function p($data = [])
{
    echo '<pre>';
    print_r($data, true);
    echo '</pre>';
}

function logMessage($message) {
    file_put_contents(
        $_SERVER['DOCUMENT_ROOT'].'/debug.log',
        date('Y-m-d H:i:s').$message."\n",
        FILE_APPEND
    );
}