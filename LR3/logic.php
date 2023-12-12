<?php
require_once 'db.php';


$SALT = "sanya_shedrin_molodec";


function checkErrors($input_data):bool {
    $fields = ['email','birth','FIO','address','gender','vk','interesting','blood','blood_rh','password','password1'];
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
        'password' => 'Не указан пароль'
    ];
     $error_input = false;
     foreach ($fields as $field){
         if(empty($_POST[$field])){
             $error_input = true;
             ?>
             <div class="alert alert-danger" role="alert">
                <?= $error_text[$field] ?>
            </div>
            <?php
         }
     }
    return $error_input;
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
        'password' => ''
    ];
    foreach ($_POST as $key => $value) {
        $defaultValues[$key] = htmlspecialchars($value);
    }
    return $defaultValues;
}
function addUserInDB($user_data) {
    global $db;
    global $SALT;
    $hashed_password = md5($user_data['password'].$SALT);


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

    header('login.php');

    exit();
}
function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}


if (isset($_POST['button'])) {
    if(!checkErrors(getValuesFromPost()))
        addUserInDB(getValuesFromPost());
}

