<?php
session_start();
$id = 0;
$response = "";


if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_SESSION['basket'])) {

        for ($i = 0; $i < count($_SESSION['basket']); $i++) {
            if ($_SESSION['basket'][$i]['id'] == $id) {
                $_SESSION['basket'][$i]['count'] -= 1;
                $response = "Decremented successfully";
            }
        }
    }

} else{
    $response = "idIsEmpty";
}

$jsonData = json_encode(array("data"=>$response));
header("Content-type: application/json");
echo $jsonData;

