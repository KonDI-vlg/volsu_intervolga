<?php
require_once 'BikesTable.php';

if(!isset($_POST['btn_delete'])){
    Header("Location:index.php");
}