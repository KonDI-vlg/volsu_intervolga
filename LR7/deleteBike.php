<?php
require_once 'BikesTable.php';

if(!isset($_POST['btn_delete'])){
    BikesTable::deleteBike($_POST['id_bike']);
    Header("Location:bikes.php?message=deletedSuccessfully");
}