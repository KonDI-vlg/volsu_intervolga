<?php
require_once 'db.php';
require_once 'header.php';
global $db;
if(isset($_POST['url'])) {
    $url = $_POST['url'];

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $json = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($json, true);

        if($data === null) {
            echo "<div class='alert-danger alert' role='alert'>Неверный формат файла. Необходимо: JSON</div>";
        }
        else{
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

            $filename = pathinfo($url, PATHINFO_FILENAME);

            $tablename = $filename . "_imported";

            $copy = 0;
            do {
                if ($copy == 0) {
                    $newname = $tablename;
                } else {
                    $newname = $tablename . "(" . $copy . ")";
                }

                $stmt = $db->prepare("SHOW TABLES WHERE :table");
                $stmt->execute([":table" => $newname]);
                $result = $stmt->fetch();

                if ($result) {
                    $copy++;
                }
            } while ($result);

            $fields = array_keys($data[0]);
            $values = "";
            foreach ($fields as $field) {
                $values .= ":$field, ";
            }
            $values = rtrim($values, ", ");

            $sql = "CREATE TABLE :table (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, img_path TEXT, name TEXT, description TEXT, id_type int(11),price int(11))";
            $stmt = $db->prepare($sql);
            $stmt->execute(["table"=>$tablename]);

            $sql = "INSERT INTO :table (id, img_path, name, description, id_type, price) VALUES ($values)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":table", $tablename);

            $count = 0;
            foreach ($data as $row) {
                foreach ($fields as $field) {
                    $stmt->bindValue(":$field", $row[$field]);
                }
                $stmt->execute();
                $count++;
            }
            echo "<div class='alert alert-success'>Создана таблица $tablename и $count записей в ней</div>";
        }
    } else {
        echo "Неверная ссылка на файл. Пожалуйста, введите корректную ссылку.";
    }

}
?>


<form action="import.php" method="post">
    <div class="container">
        <label for="url">Введите ссылку на JSON-файл:</label>
        <input type="text" id="url" name="url" required>
        <button class="btn btn-primary" type="submit">Импорт</button>
    </div>
</form>


