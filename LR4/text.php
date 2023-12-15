<?php
require_once 'header.php';
require_once 'text_logic.php';

$images = [];
if(isset($_POST['text']) and !empty($_POST['text']))
    $images = print_images($_POST['text']);

global $freqs;
?>


<div class="container">
    <form class="m-5" action="text.php" method="post">
        <label class="form-label">Введите текст</label>
        <textarea class="form-control" name="text"><?php
            if (!empty($_GET['preset'])) {
                $file = "preset".$_GET['preset'].".html";
                echo file_get_contents(__DIR__.'/'.$file);
            }
            else{
                echo (isset($_POST['text'])) ? htmlspecialchars($_POST['text']) : "";
            }
            ?></textarea>
        <button class="btn btn-primary mt-2">Отправить</button>
    </form>
    <div class="container m-5">
        <h2>Задание 2</h2>
        <div>
            <?php if(isset($_POST['text'])) foreach ($images as $img_src) {
                ?> <img src='<?=$img_src?>' alt="Image"><?php
            } ?>
        </div>
        <h2>Задание 6</h2>
        <div>
            <?php if(isset($_POST['text']) and !empty($_POST['text'])) echo punctuation($_POST['text']) ?>
        </div>
        <h2>Задание 15</h2>
        <div>
            <?php if(isset($_POST['text']) and !empty($_POST['text'])) echo count_words($_POST['text']) ?>
        </div>
        <h2>Задание 19</h2>
        <div>
            <?php if(isset($_POST['text']) and !empty($_POST['text'])) echo clean_html($_POST['text']) ?>
        </div>
        <h2>Изначальный текст с ссылками</h2>
        <div>
            <?php if(isset($_POST['text']) and !empty($_POST['text'])) echo print_html($_POST['text'],$freqs) ?>
        </div>
    </div>
</div>