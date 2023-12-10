<?php
error_reporting(E_ERROR | E_PARSE);
require_once 'logic.php';
require_once 'header.php';
require_once 'error.php';
$valuesFromPost = getValuesFromPost();
if (isset($_POST['button'])) {
    addUserInDB($valuesFromPost);
}

?>

<div style="text-align:center;margin-top:50px;" class="container">
    <form method="post" action="logic.php">
        <div class="row g-4">
            <div class="col-6 ">
                <label for="exampleFormControlInput2" class="form-label">Ф.И.О.</label>
                <input value="<?= (isset($_POST['FIO'])) ? htmlspecialchars($_POST['FIO']) : "" ?>"
                       type="text" class="form-control" id="exampleFormControlInput2" name="FIO"
                       placeholder="Иванов Иван Иванович">
            </div>
            <div class="col-6 ">
                <label for="exampleFormControlInput3" class="form-label">Дата рождения</label>
                <input type="date" class="form-control" id="exampleFormControlInput3" name="birth"
                       value="<?= (isset($_POST['birth'])) ? htmlspecialchars($_POST['birth']) : "" ?>">
            </div>
            <div class="col-6 ">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input value="<?= (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : "" ?>"
                       type="email" class="form-control" id="exampleFormControlInput1" name="email"
                       placeholder="name@example.com">
            </div>
            <div class="col-6 ">
                <label for="exampleFormControlInput4" class="form-label">Адрес</label>
                <input value="<?= (isset($_POST['address'])) ? htmlspecialchars($_POST['address']) : "" ?>"
                       type="text" class="form-control" id="exampleFormControlInput4" name="address"
                       placeholder="пр. имени В.И. Ленина, 56А, Волгоград, Волгоградская обл">
            </div>
            <div class="col-6 ">
                <label for="exampleFormControlInput6" class="form-label">Ссылка на профиль
                    Вконтакте</label>
                <input type="url" class="form-control" id="exampleFormControlInput6" name="vk"
                       value="<?= (isset($_POST['vk'])) ? htmlspecialchars($_POST['vk']) : "" ?>"
                       placeholder="https://vk.com/id">
            </div>
            <div class="col-6 ">
                <label for="exampleFormControlInput5" class="form-label">Интересы</label>
                <input  type="text" class="form-control" name="interesting"
                        value="<?= (isset($_POST['interesting'])) ? htmlspecialchars($_POST['interesting']) : "" ?>"
                        id="exampleFormControlInput5">
            </div>
            <div class="col-6 ">
                <select  name="gender" class="form-select"
                                       aria-label="Default select example">
                    <option selected disabled="disabled">Пол</option>
                    <option value="Ж" <?= ($_POST['gender'] === "Ж") ? " selected" : "" ?>>
                        Ж
                    </option>
                    <option value="М" <?= ($_POST['gender'] === "М") ? " selected" : "" ?>>
                        М
                    </option>
                    <option value="Не скажу" <?= ($_POST['gender'] === "Не скажу") ? " selected" : "" ?>>
                        Не скажу
                    </option>
                    <option value="Еще не определился" <?= ($_POST['gender'] === "Еще не определился") ? " selected" : "" ?>>
                        Еще не определился
                    </option>
                </select>
            </div>
            <div class="col-6 ">
                <select  name="blood" class="form-select"
                                       aria-label="Default select example">
                    <option selected disabled="disabled">Группа Крови</option>
                    <option value="0 (I)"<?= ($_POST['blood'] === "0 (I)") ? " selected" : "" ?>>
                        0 (I)
                    </option>
                    <option value="A (II)"<?= ($_POST['blood'] === "A (II)") ? " selected" : "" ?>>
                        A (II)
                    </option>
                    <option value="B (III)"<?= ($_POST['blood'] === "B (III)") ? " selected" : "" ?>>
                        B (III)
                    </option>
                    <option value="AB (IV)"<?= ($_POST['blood'] === "AB (IV)") ? " selected" : "" ?>>
                        AB (IV)
                    </option>
                </select>
            </div>
            <div class="col-6 ">
                <select name="blood_rh" class="form-select"
                                       aria-label="Default select example">
                    <option selected disabled="disabled">Резус-фактор</option>
                    <option value="Положительный (+)"<?= ($_POST['blood_rh'] === "Положительный (+)") ? " selected" : "" ?>>
                        Положительный (+)
                    </option>
                    <option value="Отрицательный (-)"<?= ($_POST['blood_rh'] === "Отрицательный (-)") ? " selected" : "" ?>>
                        Отрицательный (-)
                    </option>
                </select>
            </div>
            <div class="w-100"></div>
            <div class="col-6 ">
                <label for="exampleFormControlInput7" class="form-label">Пароль</label>
                <input type="password" class="form-control" name="password" id="exampleFormControlInput7">
            </div>
            <div class="col-6 ">
                <label for="exampleFormControlInput8" class="form-label">Подтверждение пароля</label>
                <input type="password" class="form-control" name="password1" id="exampleFormControlInput8"">
            </div>

        </div>
        <button class="btn btn-primary mt-4"  name="button" type="submit">
            Зарегистрироваться
        </button>
    </form>

</div>

<?php
    $fields = ['email','birth','FIO','address','gender','vk','interesting','blood','blood_rh'];

    if (isset($_POST['button'])){
     $errors = [];
     foreach ($fields as $field){
         if(empty($_POST[$field])){
             $errors[] = $field;

         }
     }
}

    ?>