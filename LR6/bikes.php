<?php
require_once 'logic.php';
require_once 'BikesTable.php';

BikesTable::DatabaseConnect();

$bikes = BikesTable::exportBikes();
$types = BikesTable::exportTypes();

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Горный велосипед Cube Aim Pro 29 (2023) купить в Волгограде, цена, фото в интернет-магазине
        ВелоСтрана.ру</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/app.css">
</head>

<body>
<div class="topline-row row">
    <div class="container-fluid col-9">
        <div class="topline-menu">
            <ul class="topline-buttons row-cols-auto ps-0 mb-0">
                <li class="col ps-0"><a class="fw-bold" href="#">Распродажа</a></li>
                <li class="col"><a class="fw-bold" href="#">Акции</a></li>
                <li class="col"><a href="#">Контакты</a></li>
                <li class="col"><a href="#">Покупателям</a></li>
                <li class="col"><a href="#">Доставка и оплата</a></li>
                <li class="col"><a href="#">YouTube</a></li>
            </ul>
        </div>
    </div>
</div>

<header class="header row">
    <div class="container col-9">
        <div class="header__row row align-items-center">
            <div class="col-3">
                <a href="/"><img width="240" alt="велосипед" src="img/logo.svg"></a>
            </div>
            <div class="col-4">
                <form class="search-input position-relative" action="" method="get">
                    <input type="search" placeholder="Я ищу...">
                    <button class="position-absolute top-0 end-0" type="submit"></button>
                </form>
            </div>
            <div class="col-5">
                <div class="shop_location row">
                    <div class="city col"><a href="#">Волгоград</a></div>
                    <div class="shops col">
                        <a href="#">Пункт самовывоза: 400075, Волгоградская обл, Волгоград г, Моторная (Рабочий поселок
                            Гумрак тер.) ул, дом № 9, Г</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="main-page" class="row justify-content-center">
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
                <td class="col-1 d-block text-start">
                    <img height="90" src="<?=htmlspecialchars($bike['img_path'])?>">
                </td>
                <td class="col-1"><?=htmlspecialchars($bike['name'])?></td>
                <td class="col-1"><?=htmlspecialchars($bike['type'])?></td>
                <td class="col-2"><?=htmlspecialchars(mb_strimwidth($bike['description'],0,100,'...'))?></td>
                <td class="col-1"><?=htmlspecialchars($bike['price'])?></td>
                <td class="col-1">
                    <form method="post" action="addBike.php">
                        <button class="btn btn-outline-primary" type="submit">Изменить</button>
                    </form>
                </td>
                <td class="col-1">
                    <form method="post" action="deleteBike.php">
                        <button class="btn btn-outline-danger" type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
</div>

</body>

