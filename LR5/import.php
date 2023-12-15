<?php
require_once 'db.php';
global $db;
// Получаем ссылку на файл из формы
$url = $_POST['url'];

// Проверяем валидность ссылки
if (filter_var($url, FILTER_VALIDATE_URL)) {
  // Инициализируем cURL-сессию
  $ch = curl_init($url);
  // Устанавливаем опцию для возврата содержимого в виде строки
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);

  // Выполняем cURL-запрос
  $json = curl_exec($ch);
    echo $json;
  // Закрываем cURL-сессию
  curl_close($ch);

  // Декодируем JSON в массив
  $data = json_decode($json, true);

  echo $data;

  // Подключаемся к базе данных с помощью PDO
  // В этом примере мы используем MySQL, но вы можете использовать любой другой драйвер, поддерживаемый PDO
  // Вы также должны указать свои параметры подключения вместо localhost, username, password и database
  // Устанавливаем режим обработки ошибок в PDO
  // В этом примере мы используем исключения, но вы можете использовать любой другой режим, поддерживаемый PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Получаем имя файла без расширения
  $filename = pathinfo($url, PATHINFO_FILENAME);

  // Создаем новую таблицу с постфиксом _imported
  $tablename = $filename . "_imported";

  // Определяем структуру таблицы в соответствии с данными из JSON-файла
  // В этом примере мы предполагаем, что JSON-файл содержит массив объектов с одинаковыми полями
  // Вы можете изменить этот код в зависимости от формата вашего JSON-файла
  $fields = array_keys($data[0]); // Получаем имена полей из первого объекта
  $columns = ""; // Строка для хранения списка столбцов
  $values = ""; // Строка для хранения списка значений
  foreach ($fields as $field) {
    // Добавляем имя и тип столбца в список
    // В этом примере мы предполагаем, что все поля имеют тип VARCHAR(255)
    // Вы можете изменить этот код в зависимости от типов данных в вашем JSON-файле
    $columns .= "$field VARCHAR(255), ";

    // Добавляем плейсхолдер для значения в список
    $values .= ":$field, ";
  }
  // Удаляем последнюю запятую из списков
  $columns = rtrim($columns, ", ");
  $values = rtrim($values, ", ");

  // Формируем SQL-запрос для создания таблицы
  $sql = "CREATE TABLE $tablename ($columns)";

  // Выполняем SQL-запрос
    $db->exec($sql);

  // Подготавливаем SQL-запрос для вставки данных в таблицу
  $sql = "INSERT INTO $tablename ($columns) VALUES ($values)";
  $stmt = $db->prepare($sql);

  // Заполняем таблицу данными из JSON-файла
  $count = 0; // Счетчик для хранения числа записей
  foreach ($data as $row) {
    // Присваиваем значения параметрам с именами полей
    foreach ($fields as $field) {
      $stmt->bindValue(":$field", $row[$field]);
    }
    // Выполняем SQL-запрос
    $stmt->execute();
    // Увеличиваем счетчик
    $count++;
  }

  // Выводим сообщение об успешном импорте
  echo "Файл с данными получен из $url и обработан. Создана таблица $tablename и $count записей в ней.";
} else {
  // Выводим сообщение об ошибке, если ссылка невалидна
  echo "Неверная ссылка на файл. Пожалуйста, введите корректную ссылку.";
}
?>


<form action="import.php" method="post">
    <label for="url">Введите ссылку на JSON-файл:</label>
    <input type="text" id="url" name="url" required>
    <input type="submit" value="Импорт">
</form>

