<?php
require_once 'db.php';

$price_min = !empty($price_min) ? $price_min : 0;
$price_max = !empty($price_max) ? $price_max : 0;

if(!isset($_SESSION['user_id']))
    Header("Location:login.php");
function getBikesFromDb(): array{
    global $db;
    $sql =
        'SELECT bikes.name as name,
        types.type as type,
        bikes.img_path,
        bikes.description,
        bikes.price 
        from bikes
        INNER JOIN types ON bikes.id_type = types.id WHERE TRUE';
    $arBinds = [];

    if(!empty($_GET['type'])){
        $type = $_GET['type'];
        $sql .= " AND bikes.id_type = :type";
        $arBinds['type'] = $type;
    }
    if(!empty($_GET['name'])){
        $name = $_GET['name'];
        $sql .= " AND name LIKE :name";
        $arBinds['name'] = '%'.$name.'%';
    }
    if(!empty($_GET['description'])){
        $description = $_GET['description'];
        $sql .= " AND bikes.description LIKE :description";
        $arBinds['description'] = '%'.$description.'%';
    }
    if(!empty($_GET['price_min']) or !empty($_GET['price_max'])){
        $price_min = $_GET['price_min'];
        $price_max = $_GET['price_max'];

        $price_min = !empty($price_min) ? $price_min : 0;
        $price_max = !empty($price_max) ? $price_max : PHP_INT_MAX;

        $sql .= ' AND bikes.price > :price_min AND bikes.price < :price_max';
        $arBinds['price_min'] = $price_min;
        $arBinds['price_max'] = $price_max;
    }
    $stmt = $db->prepare($sql);
    $stmt->execute($arBinds);
    return $stmt->fetchAll();
}

function getTypesFromDb(): array{
    global $db;
    $sql =
        'SELECT * FROM types';
    $arBinds = [];
    $stmt = $db->prepare($sql);
    $stmt->execute($arBinds);
    return $stmt->fetchAll();
}

function getValuesFromGet():array {
    $defaultValues = [
        'name' => '',
        'type' => '',
        'description' => '',
        'price_min' => '',
        'price_max' => ''
    ];
    foreach ($_GET as $key => $value) {
        $defaultValues[$key] = htmlspecialchars($value);
    }
    return $defaultValues;
}