<?php

require_once __DIR__. "/../../model/ClientItems.php";
require_once __DIR__ . "/../../components/DB.php";

$response = json_encode(array("data"=>ClientItems::getAllItemsIdNCount()));

header("Content-type: application/json");

echo $response;



