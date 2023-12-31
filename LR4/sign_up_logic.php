<?php
require_once 'db.php';
session_start();
$GLOBALS['salt'] = "sanya_shedrin_molodec";
$valuesFromPost = getValuesFromPost();

function checkErrors($input_data): array {
    global $db;
    $fields = ['email','birth','FIO','address','gender','vk','interesting','blood','blood_rh','password','password_compare'];
    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-_ !@#$%^&*()+,])[a-zA-Z\d!@#$%^&*()+,\-_\s]{6,}$/';
    $error_text = [
        'email' => 'Не указана электронная почта',
        'birth' => 'Не указана дата рождения',
        'FIO' => 'Не указано ФИО',
        'address' => 'Не указан адрес',
        'gender' => 'Не указан пол',
        'vk' => 'Не указана ссылка на ВК',
        'interesting' => 'Не указана интересная информация',
        'blood' => 'Не указана группа крови',
        'blood_rh' => 'Не указан резус фактор крови',
        'password' => 'Не указан пароль',
        'password_compare' => 'Подтвердите пароль'
    ];

    $stmt = $db->prepare("SELECT mail FROM users WHERE mail = :email");
    $stmt->execute(['email' => $input_data['email']]);
    $existing_user = $stmt->fetch();

     $error_output = array();
     foreach ($fields as $field){
         if(empty($_POST[$field])){
             $error_output[] = $error_text[$field];
         }
     }
     if($existing_user){
         $error_output[] = "Пользователь с такой электронной почтой уже зарегистрирован";
     }
     elseif(!preg_match($password_pattern,$input_data['password']))
         $error_output[] = " <ul>Слишком легкий пароль<br>Требования к паролю: </ul> 
                        <li>Длиннее 6 символов</li>
                        <li>Содержит как большие, так и маленькие латинские буквы</li>
                        <li>Минимум 1 специальный символ</li>
                        <li>Только латинские буквы</li>
                        ";
     elseif($input_data['password'] !== $input_data['password_compare'])
          $error_output[] = "Пароли не совпадают";


     return $error_output;
}
function getValuesFromPost(): array {
    $defaultValues = [
        'FIO' => '',
        'birth' => '',
        'email' => '',
        'address' => '',
        'vk' => '',
        'interesting' => '',
        'gender' => '',
        'blood' => '',
        'blood_rh' => '',
        'password' => '',
        'password1' => ''
    ];
    foreach ($_POST as $key => $value) {
        $defaultValues[$key] = htmlspecialchars($value);
    }
    return $defaultValues;
}
function addUserInDB($user_data) {
    global $db;
    global $SALT;
    $hashed_password = md5($user_data['password'].$GLOBALS['salt']);


    $register_data = [
        'email' => $user_data['email'],
        'FIO' => $user_data['FIO'],
        'birth' => $user_data['birth'],
        'address' => $user_data['address'],
        'vk' => $user_data['vk'],
        'interesting' => $user_data['interesting'],
        'gender' => $user_data['gender'],
        'blood' => $user_data['blood'],
        'blood_rh' => $user_data['blood_rh'],
        'password' => $hashed_password,
    ];

    $sql =
        'INSERT INTO users
        (mail,pass,name,birth_date,address,vk_link,interesting,gender,blood,blood_rh)
        VALUES (:email, :password, :FIO, :birth, :address, :vk, :interesting, :gender, :blood, :blood_rh)';
    $stmt = $db->prepare($sql);
    $stmt->execute($register_data);

    header('Location:login.php');

    exit();
}
function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}


if(isset($_SESSION['user_id'])){
    Header("Location:secret_page.php");
}
else if (isset($_POST['button'])) {
    $error_output = checkErrors($valuesFromPost);
    if($error_output == null){
        addUserInDB($valuesFromPost);
    }
    else{
        $_SESSION['errors'] = $error_output;
    }
}
else if (!debug_backtrace()){
    Header("Location:sign_up.php");
}

