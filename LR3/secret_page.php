<?php
require_once('header.php');

require_once 'secret_page_logic.php';
$bikes = getBikesFromDb();
$types = getTypesFromDb();
$valuesFromGet = getValuesFromGet();

if(!isset($_SESSION['user_id']))
    Header("Location:login.php");
?>

<div id="main-page" class="row justify-content-center">
    <form class="col-7" action="secret_page.php" method="get">
        <div class=" mt-4">
            <label for="inputName" class="form-label">Название</label>
            <input value="<?=$valuesFromGet['name']?>" name="name" type="text" class="form-control" id="inputName">
        </div>
        <div class="mt-4">
            <label for="inputSelect" class="form-label">Тип</label>
            <select name="type" id="inputSelect" class="form-select">
                <option <?= empty($_GET['type']) ? 'selected' : '' ?> value="">Не выбрано</option>
                <?php foreach ($types as $type): ?>
                    <?php if ($type['id'] == $_GET['type']): ?>
                        <option selected value="<?=htmlspecialchars($type['id'])?>">
                            <?=htmlspecialchars($type['type'])?>
                        </option>
                    <?php else: ?>
                        <option value="<?=htmlspecialchars($type['id'])?>">
                            <?=htmlspecialchars($type['type'])?>
                        </option>
                    <?php endif ?>
                <?php endforeach;?>
            </select>
        </div>
        <div class=" mt-4">
            <label for="inputDescription" class="form-label">Описание</label>
            <textarea name="description" type="text" class="form-control" id="inputDescription"><?=$valuesFromGet['description']?></textarea>
        </div>
        <div class="mt-4">
            <label for="inputPrice" class="form-label">Стоимость</label>
            <div class="d-flex flex-row col-6 justify-content-between">
                <input value="<?=$valuesFromGet['price_min']?>" placeholder="Мин. цена" name="price_min" type="number" min="0" class="form-control" id="inputPrice">
                <input value="<?=$valuesFromGet['price_max']?>" placeholder="Макс. цена" name="price_max" type="number" min="0" class="form-control" id="inputPrice">
            </div>
        </div>
        <div class="d-flex flex-row mt-4">
            <button type="submit" class="btn btn-primary me-3">Применить фильтры</button>
            <a href="secret_page.php" class="btn btn-danger">Сбросить фильтры</a>
        </div>
    </form>

    <table class="col-7 table table-hover ">
        <thead>
        <tr class="row justify-content-center">
            <th scope="col" class="col-2">Фото</th>
            <th scope="col" class="col-1">Название</th>
            <th scope="col" class="col-1">Тип</th>
            <th scope="col" class="col-2">Описание</th>
            <th scope="col" class="col-1">Стоимость</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bikes as $bike):?>
            <tr class="row justify-content-center">
                <td class="col-2 d-block text-center">
                    <img height="180" src="<?=htmlspecialchars($bike['img_path'])?>">
                </td>
                <td class="col-1"><?=htmlspecialchars($bike['name'])?></td>
                <td class="col-1"><?=htmlspecialchars($bike['type'])?></td>
                <td class="col-2"><?=htmlspecialchars(mb_strimwidth($bike['description'],0,250,'...'))?></td>
                <td class="col-1"><?=htmlspecialchars($bike['price'])?></td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
</div>

</body>

