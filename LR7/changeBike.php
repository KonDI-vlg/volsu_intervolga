<?php
require_once 'header.php';
require_once 'BikesTable.php';

$types = BikesTable::exportTypes();

// Если через $_GET указан несуществующий id, то возвращаем пользователя назад
if(isset($_GET['id_bike'])){
    $bikeData = BikesTable::selectBike($_GET['id_bike']);
    if(empty($bikeData))
        header("Location:bikes.php");
}

// Проверяем ошибки после нажатия кнопки
if(isset($_POST['btn_upd']))
    $errors = BikesTable::checkErrors($_POST['setName'],$_POST['setType'],$_POST['setDescription'],$_POST['setPrice'],$_FILES['setImage']);

// Если ошибок нет, то обновляем запись в таблице
if(empty($errors) and !empty($_FILES['setImage'])){
    $newPhotoPath = BikesTable::renameInputImage($_FILES['setImage']);
    BikesTable::updateExistingBike($_POST['id_bike'], $newPhotoPath, $_POST['setName'], $_POST['setDescription'], $_POST['setType'], $_POST['setPrice']);
}
?>


<div class='container col-9'>
    <a class="btn btn-primary mt-3 mb-3" href="index.php">Назад</a>
    <form method="post" action="changeBike.php"  enctype="multipart/form-data">
        <?php
        if(isset($_GET['message'])){
            if ($_GET['message'] == 'wrongType')
                echo "<div class='alert alert-danger' role='alert'>Неправильный тип</div>";
        }
        if(!empty($errors)):
            ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php
                    foreach ($errors as $error):
                        ?>
                        <li><?php echo $error; ?></li><?php
                    endforeach;
                    ?>
                </ul>
            </div>
        <?php endif ?>
        <div class="row justify-content-center">
            <h1>Редактировать велосипед</h1>
            <input type="hidden" name="id_bike" value="<?= isset($bikeData['id']) ? htmlspecialchars($bikeData['id']) : $_POST['id_bike'] ?>">
            <div class="col">
                <input type="text" class="form-control" placeholder="Название" name="setName" value="<?= isset($_GET['id_bike']) ? htmlspecialchars($bikeData['name']) : $_POST['setName'] ?>" required>
            </div>
            <div class="col-2">
                <select class="form-select" name="setType" required>
                    <option value="">Тип</option>
                    <?php foreach ($types as $type):
                        ?>
                    <option value="<?= $type['type'] ?>" <?= (isset($_GET['id_bike']) and isset($_GET['id_bike']) == $bikeData['id']) ? " selected" : $_POST['setType'] ?>><?=$type['type']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Описание" name="setDescription" value="<?= isset($_GET['id_bike']) ? htmlspecialchars($bikeData['description']) : $_POST['setDescription'] ?>" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Стоимость" name="setPrice" value="<?= isset($_GET['id_bike']) ? htmlspecialchars($bikeData['price']) : $_POST['setPrice'] ?>" required>
            </div>
            <div class="col-3">
                <input type="file" class="form-control" name="setImage" value="<?= isset($_GET['id_bike']) ? htmlspecialchars($bikeData['img_path']) : $_POST['setImage'] ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4" name="btn_upd">Обновить данные</button>
    </form>

</div>

