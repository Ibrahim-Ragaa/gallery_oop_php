<?php require_once("init.php"); ?>

<?php

$user = new User();

if (isset($_POST['image_name'])) {
    $user->ajax_update_image($_POST['image_name'], $_POST['user_id']);
    //    echo "yessssssssssss";
}


?>