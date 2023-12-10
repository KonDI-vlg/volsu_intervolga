<?php
    $fields = ['email','birth','FIO','address','gender','vk','interesting','blood','blood_rh'];

    if (isset($_POST['button'])){
        $errors = [];
        foreach ($fields as $field){
            if(empty($_POST[$field])){
                ?>
                <div class="alert alert-danger" role="alert">
                    Не все поля формы заполнены!
                </div>
                <?php
                break;
            }

        }
    }

?>
