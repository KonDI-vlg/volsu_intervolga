<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=velostrana','root');
}
catch (PDOException $e){
    echo $e->getMessage();
    die;
}