<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

function p($data = [])
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}