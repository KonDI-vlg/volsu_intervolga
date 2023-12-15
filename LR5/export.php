<?php
require_once 'db.php';

global $db;
if(isset($_GET["table"])){
    $table = $_GET["table"];

// Формируем имя файла с постфиксом _exported и расширением json
    $file_name = $table . "_exported.json";

// Выполняем запрос к базе данных, выбирая все данные из таблицы
    $query = $db->query("SELECT * FROM $table");

// Преобразуем данные в ассоциативный массив
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

// Кодируем данные в формат json
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);

// Устанавливаем заголовки для отправки файла пользователю
    header("Content-Type: application/json");
    header("Content-Disposition: attachment; filename=$file_name");
    header("Content-Length: " . strlen($json));

// Выводим содержимое файла
    echo $json;
}
require_once 'header.php';
// Получаем имя таблицы из GET-параметра

?>
<form action="export.php" method="get">
    <div class="container">
        <label for="download">Экспорт таблицы в формате json</label>
        <input type="text" class="form-control" id="download" name="table" value="bikes">
        <button type="submit" class="btn btn-primary">Экспорт</button>
    </div>
</form>



