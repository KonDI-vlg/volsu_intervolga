<?php
require_once 'db.php';
global $db;
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

  echo $data;

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $filename = pathinfo($url, PATHINFO_FILENAME);

  $tablename = $filename . "_imported";

  $fields = array_keys($data[0]);
  $columns = "";
  $values = "";
  foreach ($fields as $field) {
    $columns .= "$field VARCHAR(32), ";
    $values .= ":$field, ";
  }
  $columns = rtrim($columns, ", ");
  $values = rtrim($values, ", ");

  $sql = "CREATE TABLE $tablename ($columns)";

    $db->exec($sql);

  $sql = "INSERT INTO $tablename ($columns) VALUES ($values)";
  $stmt = $db->prepare($sql);

  $count = 0;
  foreach ($data as $row) {
    foreach ($fields as $field) {
      $stmt->bindValue(":$field", $row[$field]);
    }
    $stmt->execute();
    $count++;
  }

  echo "Файл с данными получен из $url и обработан. Создана таблица $tablename и $count записей в ней.";
} else {
  echo "Неверная ссылка на файл. Пожалуйста, введите корректную ссылку.";
}
?>


<form action="import.php" method="post">
    <label for="url">Введите ссылку на JSON-файл:</label>
    <input type="text" id="url" name="url" required>
    <input type="submit" value="Импорт">
</form>

