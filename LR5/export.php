<?php
require_once 'db.php';

global $db;
if(isset($_GET["table"])){
    $table = $_GET["table"];

    $file_name = $table . "_exported.json";

    $query = $db->query("SELECT * FROM $table");

    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    $json = json_encode($data, JSON_UNESCAPED_UNICODE);

    header("Content-Type: application/json");
    header("Content-Disposition: attachment; filename=$file_name");
    header("Content-Length: " . strlen($json));

    echo $json;
}
require_once 'header.php';

?>
<form action="export.php" method="get">
    <div class="container">
        <label for="download">Экспорт таблицы в формате json</label>
        <input type="text" class="form-control" id="download" name="table" value="bikes">
        <button type="submit" class="btn btn-primary">Экспорт</button>
    </div>
</form>



