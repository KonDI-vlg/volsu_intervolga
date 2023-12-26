<?php
require_once 'BikesTable.php';
require_once 'header.php';

$types = BikesTable::exportTypes();

if(isset($_POST['setName']))
    $errors = BikesTable::checkErrors($_POST['setName'],$_POST['setType'],$_POST['setDescription'],$_POST['setPrice'],$_FILES['setImage']);

if(empty($errors) and !empty($_FILES['setImage'])){
    $newPhotoPath = BikesTable::renameInputImage($_FILES['setImage']);
    BikesTable::addNewBike($newPhotoPath,$_POST['setName'],$_POST['setDescription'],$_POST['setType'],$_POST['setPrice']);
}
?>



<form class='container col-9' method="post" action="addBike.php"  enctype="multipart/form-data">

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
        <h1>Добавить велосипед</h1>
        <div class="col">
            <input type="text" class="form-control" placeholder="Название" name="setName" value="<?= isset($_POST['setName']) ? htmlspecialchars($_POST['setName']) : "" ?>" required>
        </div>
        <div class="col-2">
            <select class="form-select" name="setType" required>
                <option value="">Тип</option>
                <?php foreach ($types as $type):
                    ?>
                    <option value="<?= $type['type'] ?>" <?= (isset($_POST['setType']) and $_POST['setType'] == $type['type']) ? " selected" : "" ?>><?=$type['type']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Описание" name="setDescription" value="<?= isset($_POST['setDescription']) ? htmlspecialchars($_POST['setDescription']) : "" ?>" required>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Стоимость" name="setPrice" value="<?= isset($_POST['setPrice']) ? htmlspecialchars($_POST['setPrice']) : "" ?>" required>
        </div>
        <div class="col-3">
            <input type="hidden" name="MAX_FILE_SIZE" value="300000">
            <input type="file" class="form-control" placeholder="Фото" name="setImage" value="<?= isset($_POST['setImage']) ? htmlspecialchars($_POST['setImage']) : "" ?>" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-4">Добавить</button>
</form>
