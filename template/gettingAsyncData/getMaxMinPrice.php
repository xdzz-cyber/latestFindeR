<?php
//require_once "../../components/DB.php";
//$db = DB::getConnection();
$db = new PDO("mysql:host=localhost;dbname=mvc-shop", "root", "root");
$query = "select max(price) as maxPrice, min(price) as minPrice from items";
$stmt = $db->prepare($query);
$stmt->execute([]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$result = json_encode($result);
header("Content-type: application/json");
echo $result;