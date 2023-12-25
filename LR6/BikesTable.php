<?php

class BikesTable
{
    private static $db;

    public static $errors = [];

    public static function DatabaseConnect(){
        try {
           self::$db = new PDO('mysql:host=localhost;dbname=velostrana','root');
        }
        catch (PDOException $e){
            self::$errors = $e->getMessage();
            die;
        }
    }

    public static function exportBikes(){
        $sql = "SELECT * FROM bikes INNER JOIN types ON bikes.id_type = types.id ";
        $stmt = self::$db->query($sql);
        return $stmt->fetchAll();
    }

    public static function exportTypes(){
        $sql = "SELECT * FROM types";
        $stmt = self::$db->query($sql);
        return $stmt->fetchAll();
    }

    public static function addNewBike($img, $name, $description, $id_type, $price){
        $sql =  "INSERT INTO bikes (img_path,name,description,id_type,price) VALUES (:image,:name,:description,:id_type,:price)";
        $stmt = self::$db->prepare($sql);
        $params = [
            'image' => $img,
            'name' => $name,
            'description' => $description,
            'id_type' => $id_type,
            'price' => $price
        ];
        $bikeAdded = $stmt->execute($params);
        return $bikeAdded ?  "Велосипед был добавлен" : "";
    }

    public static function checkErrors($img, $name, $description, $id_type, $price){
        if (empty($name)||empty($description) ||empty($id_type) || empty($img['tmp_name']) || empty($price)){
            self::$errors[] = "Не все поля формы заполнены";
            return self::$errors;
        }
        if((int)$price != $price){
            self::$errors[] = "Цена должна быть целым числом";
        }
        if($price <= 0){
            self::$errors[] = "Цена должна быть целым числом";
        }
        if(exif_imagetype($img['tmp_name']) === false){
            self::$errors[] = "Выбранный файл не является фото";
        }
        return self::$errors;
    }
}