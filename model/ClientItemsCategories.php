<?php


class ClientItemsCategories
{
    public static function getCategories(){
        $db = DB::getConnection();
        $query = "select * from categories";
        $stmt = $db->prepare($query);
        $stmt->execute([]);
        if ($stmt){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}