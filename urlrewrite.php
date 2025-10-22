<?php
$arUrlRewrite=array (
  3 => 
  array (
    'CONDITION' => '#^SECTION_CODE=$1&ELEMENT_CODE=$2&$3\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/company/vacancies/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/company/vacancies/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/company/news/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/company/news/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
);
