<?php

require_once('header.php');

?>

<div style="text-align:center;margin-top:50px;" class="container">
    <?php
    if(isset($_SESSION['errors'])):
        foreach ($_SESSION['errors'] as $err): ?>
            <div class="alert alert-danger" role="alert">
                <?= $err ?>
            </div>
        <?php endforeach;
        unset($_SESSION['errors']);
    endif;
    ?>
    <form action="login.php" method="post">
        <div class="d-flex flex-column align-items-center">
            <div class="col-4">
                <label for="exampleFormControlInput1" class="form-label">E-mail</label>
                <input value="<?= (isset($_POST['login_mail'])) ? htmlspecialchars($_POST['login_mail']) : "" ?>"
                       type="text" class="form-control" id="exampleFormControlInput1" name="login_mail" required>
            </div>
            <div class="col-4">
                <label for="exampleFormControlInput2" class="form-label">Пароль</label>
                <input type="text" class="form-control" id="exampleFormControlInput2" name="login_pass" required
                       value="<?= (isset($_POST['login_pass'])) ? htmlspecialchars($_POST['login_pass']) : "" ?>">
            </div>

            <button class="btn btn-primary mt-4"  name="button" type="submit">
                Войти
            </button>
        </div>
    </form>


</div>
