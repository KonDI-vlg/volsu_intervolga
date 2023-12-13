<?php
require_once('db.php');

$GLOBALS['salt'] = "sanya_shedrin_molodec";

$valuesFromPost = getValuesFromPost();
$user = array();

function getValuesFromPost(): array {
    $defaultValues = [
        'login_mail' => '',
        'login_pass' => ''
    ];
    foreach ($_POST as $key => $value) {
        $defaultValues[$key] = htmlspecialchars($value);
    }
    return $defaultValues;
}
function checkErrors($input_data): array
{
    global $db;
    global $user;
    $error_output = array();
    if (empty($input_data['login_mail']) || empty($input_data['login_pass'])) {
        $error_output[] = "Не все поля заполнены";
        return $error_output;
    }
    $stmt = $db->prepare("SELECT users.id, users.mail, users.pass FROM users WHERE mail = :login_mail");
    $stmt->execute(['login_mail' => $input_data['login_mail']]);
    $user = $stmt->fetch();

    if (!$user) {
        $error_output[] = "Пользователь не найден";

    }
    elseif(freezeAcc($input_data)){
        $error_output[] = "Попробуйте снова войти через 1 час";
    }
    elseif (strcmp(md5($input_data['login_pass'].$GLOBALS['salt']), $user['pass']) != 0) {
        $error_output[] = "Пароль неправильный";
        addLoginTry($input_data);
    }
    return $error_output;
}

function freezeAcc($input_data):bool {
    global $db;
    $curr_time = time();
    $stmt = $db->prepare("SELECT users.last_try_login, users.tries_count FROM users WHERE mail = :login_mail");
    $stmt->execute(['login_mail' => $input_data['login_mail']]);
    $data = $stmt->fetch();

    $user_time = intval($data['last_try_login']);
    $user_count = $data['tries_count'];


    if($curr_time - $user_time < 3600  and $user_count > 3)
        return true;
    else
        return false;
}

function addLoginTry($input_data){
    global $db;

    $stmt = $db->prepare("SELECT users.tries_count FROM users WHERE users.mail = :login_mail");
    $stmt->execute(['login_mail' => $input_data['login_mail']]);
    $data = $stmt->fetch()['tries_count'];
    $data++;

    $stmt = $db->prepare("UPDATE users SET tries_count = :new_tries WHERE users.mail = :login_mail");
    $stmt->execute(['login_mail' => $input_data['login_mail'],
        'new_tries' => $data]);
}

function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

if(isset($_SESSION['user_id'])){
    Header("Location:secret_page.php");
}
else if(isset($_POST['button'])){
    global $user;
    $error_output = checkErrors($valuesFromPost);
    if($error_output == null){
        $_SESSION['user_id'] = $user['id'];
        Header("Location:secret_page.php");
    }
    else{
        $_SESSION['errors'] = $error_output;
    }
}
else if (!debug_backtrace()){
    Header("Location:login.php");
}


