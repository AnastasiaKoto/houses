<?php
$_SERVER["DOCUMENT_ROOT"] = 'www/10domov.ru/';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule('iblock');

function getPropertyEnumId($propertyCode, $value, $iblockId) {
    if (empty($value)) return null;
    
    $property = CIBlockProperty::GetList([], [
        'CODE' => $propertyCode,
        'IBLOCK_ID' => $iblockId
    ])->Fetch();
    
    if (!$property) {
        logMessage("Свойство $propertyCode не найдено");
        return null;
    }

    $enumRes = CIBlockPropertyEnum::GetList([], [
        'PROPERTY_ID' => $property['ID'],
        'VALUE' => $value
    ]);
    if ($existing = $enumRes->Fetch()) {
        return $existing['ID'];
    }
    logMessage("Значение $value не найдено");
    
    return null;
}

function generateCode($name, $iblockId = 0) {
    $params = array(
        "max_len" => 100,
        "change_case" => 'L',
        "replace_space" => '-',
        "replace_other" => '-',
        "delete_repeat_replace" => true,
        "use_google" => false,
    );
    
    $baseCode = CUtil::translit($name, "ru", $params);
    $code = $baseCode;
    //$counter = 1;
    
    if ($iblockId > 0) {
        $filter = [
            'IBLOCK_ID' => $iblockId,
            '=CODE' => $code
        ];
        
        $res = CIBlockElement::GetList([], $filter, false, false, ['ID']);
        while ($res->Fetch()) {
            $randomSymbols = generateRandomSuffix();
            $code = $baseCode . '-' . $randomSymbols;
            $filter['=CODE'] = $code;
            $res = CIBlockElement::GetList([], $filter, false, false, ['ID']);
            //$counter++;
        }
    }
    
    return $code;
}

// Функция для генерации случайного набора символов
function generateRandomSuffix($length = 3) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $randomString;
}

function addImages($paths, $descriptions = []) {

    $gallery = [];

    if(!empty($paths)) {
        $photoGallery = explode(", ", $paths);
        
        $descriptionArray = [];
        if (!empty($descriptions)) {
            if (is_string($descriptions)) {
                $descriptionArray = explode(", ", $descriptions);
            }
        }
    
        if (!empty($photoGallery)) {
            foreach ($photoGallery as $index => $field) {
                $fileArray = CFile::MakeFileArray($field);
                if ($fileArray) {
                    // Добавляем описание, если оно есть
                    if (isset($descriptionArray[$index])) {
                        $fileArray['description'] = trim($descriptionArray[$index]);
                    }
                    $gallery[] = $fileArray;
                }
            }
        }
    }
    
    return $gallery;
}

/*
function addImages($paths) {
    $gallery = [];

    if(!empty($paths)) {
        $photoGallery = explode(", ", $paths);
    
        if (!empty($photoGallery)) {
            foreach ($photoGallery as $field) {
                $fileArray = CFile::MakeFileArray($field);
                if ($fileArray) {
                    $gallery[] = $fileArray;
                }
            }
        }
    }
    
    return $gallery;
}
*/

function stringProjectsToArray($progectsString) {
    $projectIds = explode(", ", $progectsString);
    $linkedProjects = [];
    foreach($projectIds as $projectId) {
        $project = CIBlockElement::GetByID($projectId)->Fetch();
        if ($project) {
            $linkedProjects[] = $projectId;
        } else {
            logMessage("Элемент прилинкованного проекта не найден");
        }
    }

    if(!empty($linkedProjects)) {
        return $linkedProjects;
    } else {
        return null;
    }
}


function importOffersSimple($csvFilePath) {
    $handle = fopen($csvFilePath, 'r');
    if (!$handle) {
        throw new Exception("Не удалось открыть файл: $csvFilePath");
    }

    $header = fgetcsv($handle, 10000, ',');
    if (!$header) {
        throw new Exception("Ошибка чтения заголовков CSV");
    }
    
    $counter = 0;
    while (($data = fgetcsv($handle, 10000, ',')) !== false) {

        try {

            //if($counter <= 2):

            if (empty(array_filter($data))) {
                logMessage("Пустая дата.");
                continue;
            }

            if (count($data) !== count($header)) {
                logMessage("Не совпадает количество стролбцов строки.");
                continue;
            }

            $row = array_combine($header, $data);
            $productFields = [];
            $productProperties = [];
            $gallery = [];
            $productId = !empty($row['ID']) ? $row['ID'] : null;
            $iblockId = $row['TYPE'] == 'variation' ? 11 : 6;
            $productCode = generateCode($row['Название'], $iblockId);
            $gallery = addImages($row['Галерея']);
            $project_type = $row['TYPE'] == 'variation' ? 'вариация' : 'проект';
            $linkedProjects = [];

            if (!empty($row['Примеры реализованных проектов'])) {
                $linkedProjects = stringProjectsToArray($row['Примеры реализованных проектов']);
            }


            if($row['TYPE'] == 'variation'):
                $sectionId = 0;
                $anounce = $row['Описание для анонса'];

                $styleId = !empty($row['Стиль']) ? getPropertyEnumId('HOUSES_STYLE', $row['Стиль'], $iblockId) : null;
                $floors = !empty($row['Этажность']) ? getPropertyEnumId('HOUSES_FLOORS', $row['Этажность'], $iblockId) : null;
                $facades = !empty($row['Стиль фасадов']) ? getPropertyEnumId('HOUSES_FACADE', $row['Стиль фасадов'], $iblockId) : null;
                $otdelka = !empty($row['Отделка']) ? getPropertyEnumId('HOUSES_OTDELKA', $row['Отделка'], $iblockId) : null;
                $naruzh_otdelka = !empty($row['Стиль отделки']) ? getPropertyEnumId('HOUSES_OTDELKA_STYLE', $row['Стиль отделки'], $iblockId) : null;


                $other_gallery = addImages($row['Другое (галерея)']);
                $interjers_gallery = addImages($row['Изображения интерьеров']);
                $cuts_gallery = addImages($row['Изображения разрезов']);
                $facade_gallery = addImages($row['Изображения фасадов']);
                $roof_gallery = addImages($row['Кровля (галерея)']);
                $finish_gallery = addImages($row['Наружная отделка (галерея)']);
                $doors_gallery = addImages($row['Окна и двери (галерея)']);
                $walls_gallery = addImages($row['Стены (галерея)']);
                $insul_gallery = addImages($row['Утепление (галерея)']);
                $fundament_gallery = addImages($row['Фундамент (галерея)']);

                $plane = array_map('trim', explode(', ', $row['Планировка этажей']));
                //$square = getDirectoryItemId(9, $row['Площадь']);

                $productProperties = [
                    'SHOWED_NAME' => $row['Название для пользователя'],
                    'HEIGHT' => $row['Высота потолков'],
                    'SIZES' => $row['Габариты'],
                    'TERACCE' => $row['Площадь терассы'],
                    'ALL_SQUARE' => $row['Общая площадь'],
                    'GALLERY' => $gallery,
                    'OTHER_IMG' => $other_gallery,
                    'OTHER_CONFIG' => $row['Другое'],
                    'INTERJER_IMAGES' => $interjers_gallery,
                    'CUT_IMAGES' => $cuts_gallery,
                    'FACADE_IMAGES' => $facade_gallery,
                    'STORAGE' => $row['Кладовки'],
                    'ROOF_IMG' => $roof_gallery,
                    'ROOF_CONFIG' => $row['Кровля'],
                    'OUTER_FINISH_CONFIG' => $row['Наружная отделка'],
                    'OUTER_FINISH_IMG' => $finish_gallery,
                    'DOORS_CONFIG' => $row['Окна и двери'],
                    'DOORS_IMG' => $doors_gallery,
                    'PLANE' => $plane,
                    'HOUSES_SQUARES' => $row['Площадь'],
                    'PROJECTS' => $linkedProjects,
                    'WCS' => $row['Санузлы'],
                    'ROOMS' => $row['Спальни'],
                    'DEADLINE' => (int)$row['Срок строительства'],
                    'WALLS_CONFIG' => $row['Стены'],
                    'WALLS_IMG' => $walls_gallery,
                    'HOUSES_STYLE' => $styleId,
                    'HOUSES_OTDELKA_STYLE' => $naruzh_otdelka,
                    'HOUSES_OTDELKA' => $otdelka,
                    'HOUSES_FACADE' => $facades,
                    'FORMATTED_PRICE' => (int)preg_replace('/[^\d]/', '', $row['Стоимость (только число!!)']),
                    'INSULATION_CONFIG' => $row['Утепление'],
                    'INSULATION_IMG' => $insul_gallery,
                    'FUNDAMENT_CONFIG' => $row['Фундамент'],
                    'FUNDAMENT_IMG' => $fundament_gallery,
                    'HOUSES_FLOORS' => $floors
                ];
            elseif($row['TYPE'] == 'variable_project' || $row['TYPE'] == 'simple_active' || $row['TYPE'] == 'simple_real'):
                if($row['TYPE'] == 'simple_active') {
                    $sectionId = 9;
                } elseif($row['TYPE'] == 'simple_real') {
                    $sectionId = 7;
                } else {
                    $sectionId = 10;
                }
                
                $anounce = $row['Локация'];
                if($row['TYPE'] == 'simple_active' || $row['TYPE'] == 'simple_real') {
                    $detailDescr = $row['Детальное описание'];
                    $storages = !empty($row['Количество кладовок']) ? getPropertyEnumId('STORAGE', $row['Количество кладовок'], $iblockId) : null;
                    $plane = array_map('trim', explode(', ', $row['Планировка дома']));
                    $video = addImages($row['Превью видео'], $row['Видео (embed code)']);
                    $finished_project = addImages($row['Завершенный проект']);
                    $otdelka_gallery = addImages($row['Этап отделки']);
                    $building_gallery = addImages($row['Этап строительства']);
                }

                $buildings = array_map('trim', explode(', ', $row['Дополнительные постройки']));

                $rooms = !empty($row['Количество комнат']) ? getPropertyEnumId('HOUSES_ROOMS', $row['Количество комнат'], $iblockId) : null;
                $wcs = !empty($row['Количество санузлов']) ? getPropertyEnumId('HOUSES_WC', $row['Количество санузлов'], $iblockId) : null;
                $show_main = !empty($row['Показывать на главной']) ? getPropertyEnumId('SHOW_MAIN', $row['Показывать на главной'], $iblockId) : null;
                $styleId = !empty($row['Стиль']) ? getPropertyEnumId('HOUSES_STYLE', $row['Стиль'], $iblockId) : null;
                $floors = !empty($row['Этажность']) ? getPropertyEnumId('HOUSES_FLOORS', $row['Этажность'], $iblockId) : null;

                
                $variations = [];
                $productProperties = [
                    'HOUSE_VARIABLES' => $variations,
                    'BUILDINGS' => $buildings,
                    'ALL_SQUARE' => $row['Общая площадь'],
                    'VIDEO_POINT' => $video ?? null,
                    'HEIGHT' => $row['Высота потолков'] ?? null,
                    'GALLERY' => $gallery,
                    'END_POINT' => $finished_project ?? null,
                    'STORAGE' => $storages ?? null,
                    'HOUSES_ROOMS' => $rooms,
                    'HOUSES_WC' => $wcs,
                    'OTDELKA' => $row['Отделка (по умолчанию)'],
                    'PLANES' => $plane ?? null,
                    'HOUSES_SQUARES' => (int)$row['Площадь'],
                    'SHOW_MAIN' => $show_main,
                    'PROJECTS' => $linkedProjects,
                    'HOUSES_FLOORS' => $floors,
                    'HOUSES_SIZES' => $row['Размеры'],
                    'HOUSES_STYLE' => $styleId,
                    'HOUSES_PRICES' => (int)$row['Стоимость'],
                    'FINISHED_POINT' => $otdelka_gallery ?? null,
                    'CONSTRUCT_POINT' => $building_gallery ?? null,
                    'SIMPLE_DESCR' => $row['Описание простого проекта'] ?? null,
                    'DEADLINE' => $row['Срок строительства'] ?? null
                ];

                if($row['TYPE'] == 'variable_project') {
                    if (!empty($row['Вариации дома'])) {
                        $variations = stringProjectsToArray($row['Вариации дома']);
                        $productProperties['HOUSE_VARIABLES'] = $variations;
                    }
                }

                if($row['TYPE'] !== 'variable_project') {
                    $productProperties['TERACCE'] = $row['Площадь терассы'];
                }

                if($row['TYPE'] == 'simple_active') {
                    $translation = addImages($row['Превью трансляции'], $row['Ссылка на трансляцию']);
                    $productProperties['TRANSLATION_LINK'] = $translation;
                }  
                
            endif;

            $productFields = [
                'IBLOCK_ID' => $iblockId ?? null,
                'NAME' => $row['Название'],
                'ACTIVE' => $row['Активность'],
                'CODE' => $productCode,
                'PREVIEW_TEXT' => $anounce ?? null,
                'DETAIL_TEXT' => $detailDescr ?? null,
                'IBLOCK_SECTION' => $sectionId ?? null,
            ];
            $existingProduct = null;
            if($productId !== null) {
                $existingProduct = CIBlockElement::GetList(
                    [],
                    [
                        'IBLOCK_ID' => $iblockId,
                        'ID' => $productId
                    ],
                    false,
                    false,
                    ['ID']
                )->Fetch();

                $productProperties = array_filter($productProperties, function($value) {
                    return !empty($value);
                });
            }

            if ($existingProduct && !empty($existingProduct['ID'])):
                $element = new CIBlockElement;
                $productId = $existingProduct['ID'];
                /*
                $result = $element->Update($productId, array_merge($productFields, [
                    'PROPERTY_VALUES' => $productProperties
                ]));
                
                if ($result) {
                    logMessage("Успешно обновлён элемент ID: $productId");
                } else {
                    logMessage("Ошибка обновления элемента ID: $productId: " . $element->LAST_ERROR);
                }
                */
                $result = $element->Update($productId, $productFields);
                
                if ($result) {
                    if (!empty($productProperties)) {
                        try {
                            CIBlockElement::SetPropertyValuesEx($productId, $iblockId, $productProperties);
                            logMessage("Успешно обновлён элемент ID: $productId");
                        } catch (Exception $e) {
                            logMessage("Ошибка SetPropertyValuesEx: " . $e->getMessage());
                        }
                    } else {
                        logMessage("Нет свойств для обновления $project_type, ID: $productId - существующие значения сохранены");
                    }
                } else {
                    $error = $element->LAST_ERROR;
                    logMessage("Ошибка обновления $project_type, ID: $productId; Error: $error");
                }
            else:
                $element = new CIBlockElement;
                $newProductId = $element->Add(array_merge($productFields, [
                    'PROPERTY_VALUES' => $productProperties
                ]));

                if (!$newProductId) {
                    logMessage("Ошибка создания $project_type: " . $element->LAST_ERROR);
                }
            endif;
            $counter++;
        //endif;
        } catch (Exception $e) {
            logMessage("Ошибка импорта товара: " . $e->getMessage());
        }
        
    }
    
    fclose($handle);
}

try {
    importOffersSimple($_SERVER["DOCUMENT_ROOT"] . '/import/projects.csv');
} catch (Exception $e) {
    logMessage("Ошибка: " . $e->getMessage());
}