<?php

/* here goes model for item */
require_once CLIENT_ROOT . "/model/ClientItems.php";
class ClientRelation
{
    public static function submitItemsToRelationTable($client_id = 0){
        $db = DB::getConnection();
        $query = "insert into relation(item_id, item_count, published_date, order_status, id_client) values(?,?,?,?,?)";
        $stmt = $db->prepare($query);
        foreach ($_SESSION['basket'] as $item){
            $item_id = intval($item['id']);
            $item_count = intval($item['count']);
            $order_status = 1;
            $client_id = intval($client_id);
            $published_date = ClientItems::getItemById($item_id)['publish_date'];
            $stmt->execute([$item_id, $item_count, $published_date, $order_status, $client_id]) or die(print_r($stmt->errorInfo(),true));
        }
        if ($stmt){
            return true;
        }
        return false;
    }
}