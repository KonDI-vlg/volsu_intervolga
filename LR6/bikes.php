<?php
require_once 'header.php';
require_once 'BikesTable.php';


BikesTable::DatabaseConnect();

$bikes = BikesTable::exportBikes();
$types = BikesTable::exportTypes();

?>

<div id="main-page" class="row justify-content-center">
    <div class="d-flex col-8 justify-content-between align-items-center mt-3">
        <?php if(isset($_GET['success'])){
            if($_GET['success'])
                echo "<div class='alert alert-success' role='alert'>Успешно добавлено</div>";
        }
        else{
            echo "<div></div>";
        }
        ?>
        <a href="addBike.php" class="btn btn-primary">Добавить</a>
    </div>
    <table class="col-9 table table-hover ">
        <thead>
        <tr class="row justify-content-center">
            <th scope="col" class="col-1">Фото</th>
            <th scope="col" class="col-1">Название</th>
            <th scope="col" class="col-1">Тип</th>
            <th scope="col" class="col-2">Описание</th>
            <th scope="col" class="col-1">Стоимость</th>
            <th scope="col" class="col-1"></th>
            <th scope="col" class="col-1"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bikes as $bike):?>
            <tr class="row justify-content-center">
                <form method="post">
                    <td class="col-1 d-block text-start">
                        <img height="90" src="<?=htmlspecialchars($bike['img_path'])?>">
                    </td>
                    <td class="col-1"><?=htmlspecialchars($bike['name'])?></td>
                    <td class="col-1"><?=htmlspecialchars($bike['type'])?></td>
                    <td class="col-2"><?=htmlspecialchars(mb_strimwidth($bike['description'],0,100,'...'))?></td>
                    <td class="col-1"><?=htmlspecialchars($bike['price'])?></td>
                    <td class="col-1">
                        <button class="btn btn-outline-primary" type="submit" name="btn_change">Изменить</button>
                    </td>
                    <td class="col-1">
                        <button class="btn btn-outline-danger" type="submit" name="btn_delete">Удалить</button>
                    </td>
                </form>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
</div>

</body>

