<?php
session_start();

$id = 0;
$response = "";
$newArr = [];

function replaceToNewArray(): array
{
    $tmp = [];
    if (isset($_SESSION['basket'])){
        foreach ($_SESSION['basket'] as $item){
            if ($item){
                $tmp[] = $item;
            }
        }
    }
    return $tmp;
}

if (isset($_POST['id']) && !empty($_POST['id'])){
    $id = $_POST['id'];
    if (isset($_SESSION['basket'])){
        for ($i = 0; $i < count($_SESSION['basket']); $i++){
            if ($_SESSION['basket'][$i]['id'] == $id){
                unset($_SESSION['basket'][$i]);
                $response = "Delete successfully";
            }
        }

        $newArr = replaceToNewArray();
        unset($_SESSION['basket']);
        $_SESSION['basket'] = $newArr;
        unset($newArr);
    }
} else{
    $response = "Wrong id";
}

$jsonData = json_encode(array("data"=>$response, "basketIsEmpty"=> empty($_SESSION['basket'])));
header("Content-type: application/json");
echo $jsonData;