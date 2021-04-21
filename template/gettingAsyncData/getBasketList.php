<?php
session_start();
$response = [];

if (isset($_SESSION['basket'])){
    foreach ($_SESSION['basket'] as $item){
        $response[] = array("id"=>$item['id'], "count"=>$item['count'], "price"=>$item['price']);
    }
}

$jsonData = json_encode(array("data"=>$response));
header("Content-type: application/json");
echo $jsonData;