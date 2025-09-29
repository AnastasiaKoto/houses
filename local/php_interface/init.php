<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

function p($data = [])
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function logMessage($message) {
    file_put_contents(
        $_SERVER['DOCUMENT_ROOT'].'/debug.log',
        date('Y-m-d H:i:s').$message."\n",
        FILE_APPEND
    );
}

function formatPriceInMillions($price) {
    if($price < 1000000) {
        return number_format($price, 0, ".", " ");
    }
    $millions = $price / 1000000;
    
    // Если число целое - показываем без десятичных
    if ($millions == (int)$millions) {
        return (int)$millions . ' млн';
    }
    
    // Округляем до целых миллионов
    return round($millions) . ' млн';
}