<?php
session_start();
$count = 0;
if (isset($_SESSION['basket'])){
    foreach ($_SESSION['basket'] as $item){
        $count+=$item['count'];
    }
}
$encoded_data = json_encode(array("count"=>$count));
header("Content-type: application/json");
echo $encoded_data;