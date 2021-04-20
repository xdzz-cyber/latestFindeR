<?php
session_start();
$count = 0;

$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['id']) && !empty($_POST['id'])){
    $id = $_POST['id'];
    if (isset($_SESSION['basket'])){
        foreach ($_SESSION['basket'] as $item){
            if($item['id'] == $id){
                $count = $item['count'];
            }
        }
    }
} else{
    $count = 55;
}

$jsonData = json_encode(array("data"=>$count));
header("Content-type: application/json");
echo $jsonData;