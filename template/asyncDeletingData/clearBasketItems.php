<?php
session_start();

$response = "";

if (isset($_SESSION['basket'])){
    unset($_SESSION['basket']);
    $_SESSION['basket'] = [];
    $response = "Successfully cleared basket items";
}

$jsonData = json_encode(array("data"=>$response));
header("Content-type: application/json");
echo $jsonData;