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

    public static function exportBikes(): array {
        BikesTable::DatabaseConnect();
        $sql = "SELECT bikes.id,bikes.name as name,types.type as type,bikes.img_path,bikes.description,bikes.price from bikes INNER JOIN types ON bikes.id_type = types.id";
        $stmt = self::$db->query($sql);
        return $stmt->fetchAll();
    }

    public static function exportTypes(): array{
        BikesTable::DatabaseConnect();
        $sql = "SELECT * FROM types";
        $stmt = self::$db->query($sql);
        return $stmt->fetchAll();
    }

    public static function selectBike($id){
        self::DatabaseConnect();
        $sql ="SELECT bikes.id,bikes.name as name,types.type as type,bikes.img_path,bikes.description,bikes.price from bikes INNER JOIN types ON bikes.id_type = types.id WHERE bikes.id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['id'=> $id]);
        return $stmt->fetch();
    }

    public static function addNewBike($img, $name, $description, $type, $price){
        BikesTable::DatabaseConnect();
        try{
            $sql = "SELECT id FROM types WHERE type = :type";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(['type' => $type]);
            $row = $stmt->fetch();
            $id_type = $row['id'];
        }
        catch (Exception $e){
            $message = "wrongType";
            Header("Location:addBike.php?message=".$message);
        }

        $sql = "INSERT INTO bikes (img_path,name,description,id_type,price) VALUES (:image,:name,:description,:id,:price)";
        $stmt = self::$db->prepare($sql);
        $params = [
            'image' => $img,
            'name' => $name,
            'description' => $description,
            'id' => $id_type, // Используем полученный id вместо id_type
            'price' => $price
        ];
        $stmt->execute($params);
        Header("Location:bikes.php?message="."addedSuccessfully");
    }

    public static function checkErrors($name, $id_type, $description, $price, $img): array{
        if (empty($name) || empty($description) || empty($id_type) || empty($img) || empty($price)){
            self::$errors[] = "Не все поля формы заполнены";
            return self::$errors;
        }
        if((int)$price != $price){
            self::$errors[] = "Цена должна быть целым числом";
        }
        if($price <= 0){
            self::$errors[] = "Цена должна быть положительным числом";
        }
        if(exif_imagetype($img['tmp_name']) === false){
            self::$errors[] = "Выбранный файл не является фото";
        }
        return self::$errors;
    }

    public static function renameInputImage($image): string {
        // $image передается через $_FILES
        $fileExtension = '.jpg';
        $newPhotoName = 'photo_'.self::uniqidReal().$fileExtension;
        $newPhotoPath = __DIR__.'\img\\'.$newPhotoName;
        move_uploaded_file($image['tmp_name'],$newPhotoPath);
        return "img/".$newPhotoName;
    }

    private static function uniqidReal($lenght = 8) {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}