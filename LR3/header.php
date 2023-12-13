<?php
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
                <div class="shop_location d-flex flex-row justify-content-between">
                    <div class="city w-50"><a href="#">Волгоград</a></div>
                    <?php
                        if(!isset($_SESSION['user_id'])): ?>
                    <div class="auth w-50 d-flex flex-row align-items-center gap-2">
                        <a class="login col btn btn btn-outline-primary" href="login.php">
                            Войти
                        </a>
                        <a class="sign col btn btn-outline-primary" href="sign_up.php">
                            Зарегистрироваться
                        </a>
                    </div>
                        <?php
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>
