<?php

use app\models\QueryBuilder;

require($_SERVER['DOCUMENT_ROOT'].'/DWES/BatoiBook/config/database.php');

require ($_SERVER['DOCUMENT_ROOT'].'/DWES/BatoiBook/app/models/User.php');

echo "<hr>";
if (isset($_POST)){
    var_dump($_POST);
    $user = new QueryBuilder("users");

    $user->create($_POST);
    echo "user agregado";
}