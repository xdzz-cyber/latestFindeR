<?php
session_start();
$response = 0;

if (isset($_SESSION['basket'])){
    foreach ($_SESSION['basket'] as $item){
        $response+=(intval($item['price']) * $item['count']);
    }
}

$jsonData = json_encode(array("data"=>$response));
header("Content-type: application/json");
echo $jsonData;