<?php


class ClientItems
{
    public static function getItemsNumRows($params = []){
        $db = DB::getConnection();
        if ($params){
            $minPrice = $params['minPrice'];
            $maxPrice = $params['maxPrice'];
            $findByDate = $params['findByDate'];
            $findByCategory = $params['findByCategory'];
            $query = "select id from items where price between (:minPrice, :maxPrice) and publish_date = :findByDate and category_id = :findByCategory";
        } else{
            $query = "select id from items";
        }

        $stmt = $db->prepare($query);
        $stmt->execute([]);
        if ($stmt){
            return $stmt->rowCount();
        }
        return false;
    }

    public static function getPaginationItems($params){
        $params = DB::protectData($params);
        $db = DB::getConnection();
        $query = "select * from items limit {$params['skip']},{$params['perPage']}";
        $stmt = $db->query($query);
        if ($stmt){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public static function getItemById($id){
        if ($id > 0){
            $db = DB::getConnection();
            $query = "select * from items where id = :id";
            $stmt = $db->prepare($query);
            $stmt->execute([":id"=>$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public static function getMaxPrice()
    {
        $db = DB::getConnection();
        $query = "select max(price) as maxPrice from items";
        $stmt = $db->prepare($query);
        $stmt->execute([]);
        if ($stmt){
            return $stmt->fetch(PDO::FETCH_ASSOC)["maxPrice"];
        }
        return false;
    }

    public static function getMinPrice(){
        $db = DB::getConnection();
        $query = "select min(price) as minPrice from items";
        $stmt = $db->prepare($query);
        $stmt->execute([]);
        if ($stmt){
            return $stmt->fetch(PDO::FETCH_ASSOC)["minPrice"];
        }
        return false;
    }

    public static function findItems($search_data){
        $db = DB::getConnection();
        $minPrice = $search_data['minPrice'];
        $maxPrice = $search_data['maxPrice'];
        $findByDate = $search_data['findByDate'];
        $category = $search_data['findCategory'];
        $query = "select * from items where price between (:minPrice,:maxPrice) and publish_date = :findByDate and category_id = :findCategory";
        $stmt = $db->prepare($query);
        $stmt->execute(["minPrice"=>$minPrice, "maxPrice"=>$maxPrice, "findByDate"=>$findByDate, "findCategory"=>$category]);
        if ($stmt){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}