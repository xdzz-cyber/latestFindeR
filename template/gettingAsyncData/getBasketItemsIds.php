<?php

session_start();
$ids = [];

if (isset($_SESSION['basket'])){
    foreach ($_SESSION['basket'] as $item){
        if ($item){
            $ids[] = $item['id'];
        }
    }
}

$jsonData = json_encode(array("data"=>$ids));
header("Content-type: application/json");
echo $jsonData;