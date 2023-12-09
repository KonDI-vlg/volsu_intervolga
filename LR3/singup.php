<?php
error_reporting(E_ERROR | E_PARSE);
require_once 'header.php';
require_once 'error.php';
?>

<div style="text-align:center;margin-top:50px;" class="container">
    <form method="post" action="logic.php">
        <div class="row">
            <div class="col-6">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input value="<?php if (isset($_POST['email'])) {
                    echo htmlspecialchars($_POST['email']);
                } ?>" type="email" class="form-control" id="exampleFormControlInput1" name="email"
                       placeholder="name@example.com">
            </div>
            <div class="col-6">
                <label for="exampleFormControlInput2" class="form-label">ФИО</label>
                <input value="<?php if (isset($_POST['FIO'])) {
                    echo htmlspecialchars($_POST['FIO']);
                } ?>" type="text" class="form-control" id="exampleFormControlInput2" name="FIO"
                       placeholder="Иванов Иван Иванович">
            </div>
            <div class="col-6">
                <label for="exampleFormControlInput3" class="form-label">Дата Рождения</label>
                <input type="date" class="form-control" id="exampleFormControlInput3" name="birth"
                       value="<?php if (isset($_POST['birth'])) {
                           echo htmlspecialchars($_POST['birth']);
                       } ?>"></div>
            <div class="col-6">
                <label for="exampleFormControlInput4" class="form-label">Адрес</label>
                <input type="text" name="address" value="<?php if (isset($_POST['address'])) {
                    echo htmlspecialchars($_POST['address']);
                } ?>" class="form-control" id="exampleFormControlInput4"
                       placeholder="пр. имени В.И. Ленина, 56А, Волгоград, Волгоградская обл">
            </div>
            <div class="col-6">
                <select style="margin-top:10px;" name="gender" class="form-select"
                                       aria-label="Default select example">
                    <option selected disabled="disabled">Пол</option>
                    <option value="Ж" <?php if ($_POST['gender'] === "Ж") {
                        echo " selected";
                    } ?> >Ж
                    </option>
                    <option value="М"<?php if ($_POST['gender'] === "М") {
                        echo " selected";
                    } ?> >М
                    </option>
                    <option value="Не скажу"<?php if ($_POST['gender'] === "Не скажу") {
                        echo " selected";
                    } ?>>Не скажу
                    </option>
                    <option value="Еще не определился"<?php if ($_POST['gender'] === "Еще не определился") {
                        echo " selected";
                    } ?>>Еще не определился
                    </option>
                </select></div>
            <div class="col-6">
                <label for="exampleFormControlInput5" class="form-label">Интересы</label>
                <input style="height:100px;" type="text" class="form-control" name="interesting"
                       value="<?php if (isset($_POST['interesting'])) {
                           echo htmlspecialchars($_POST['interesting']);
                       } ?>" id="exampleFormControlInput5">
            </div>
            <div class="col-6">
                <label for="exampleFormControlInput6" class="form-label">Ссылка на профиль
                    Вконтакте</label>
                <input type="url" class="form-control" id="exampleFormControlInput6" name="vk"
                       value="<?php if (isset($_POST['vk'])) {
                           echo htmlspecialchars($_POST['vk']);
                       } ?>" placeholder="https://vk.com/id"></div>
            <div class="col-6">
                <select style="margin-top:10px;" name="blood" class="form-select"
                                       aria-label="Default select example">
                    <option selected disabled="disabled">Группа Крови</option>
                    <option value="0 (I)"<?php if ($_POST['blood'] === "0 (I)") {
                        echo " selected";
                    } ?>>0 (I)
                    </option>
                    <option value="A (II)"<?php if ($_POST['blood'] === "A (II)") {
                        echo " selected";
                    } ?>>A (II)
                    </option>
                    <option value="B (III)"<?php if ($_POST['blood'] === "B (III)") {
                        echo " selected";
                    } ?>>B (III)
                    </option>
                    <option value="AB (IV)"<?php if ($_POST['blood'] === "AB (IV)") {
                        echo " selected";
                    } ?>>AB (IV)
                    </option>
                </select></div>
            <div class="col-6">
                <select style="margin-top:10px;" name="blood_rh" class="form-select"
                                       aria-label="Default select example">
                    <option selected disabled="disabled">Резус-фактор</option>
                    <option value="Положительный (+)"<?php if ($_POST['blood_rh'] === "Положительный (+)") {
                        echo " selected";
                    } ?>>Положительный (+)
                    </option>
                    <option value="Отрицательный (-)"<?php if ($_POST['blood_rh'] === "Отрицательный (-)") {
                        echo " selected";
                    } ?>>Отрицательный (-)
                    </option>
                </select></div>
            <div class="col-6">
                <label for="exampleFormControlInput7" class="form-label">Пароль</label>
                <input type="password" class="form-control" name="password" id="exampleFormControlInput7"></div>
            <div class="col-6">
                <label for="exampleFormControlInput8" class="form-label">Подтверждение пароля</label>
                <input type="password" class="form-control" name="password1" id="exampleFormControlInput8"">
            </div>
        </div>
        <button class="btn btn-primary" style="margin-top:20px;width:500px;" name="button" type="submit">
            Зарегистрироваться
        </button>
    </form>

</div>
