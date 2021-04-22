<?php
session_start();

$response = 0;

if (isset($_SESSION['basket'])){
    $response = count($_SESSION['basket']);
}

$jsonData = json_encode(array("data"=>$response));
header("Content-type: application/json");
echo $jsonData;