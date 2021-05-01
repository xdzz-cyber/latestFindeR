<?php


class ClientItems
{
    public static function getItemsNumRows($search_params){
        $rowsCount = ClientItems::findItemsByFilters($search_params,true);
        return $rowsCount;
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

    public static function findItemsByFilters($search_params, $getNumRows = false){
        $db = DB::getConnection();
        $skip = 0;
        $perPage = 0;
        $findByName = "";
        $minPrice = 0;
        $maxPrice = 0;
        $findByCategory = "";
        $findByDate = "";
        if ($search_params){
            $minPrice = $search_params['minPrice'] ?? ClientItems::getMinPrice();
            $maxPrice = $search_params['maxPrice'] ?? ClientItems::getMaxPrice();

            $findByDate = $search_params['findByDate'] ?? "";
            $findByCategory = $search_params['findByCategory'] ?? 0;
            $findByName = !empty($search_params['searchName']) ? "'%{$search_params['searchName']}%'" : "'%%'";

            $skip = $search_params['skip'];
            $perPage = $search_params['perPage'];

            $query = "select * from items where name like {$findByName} and price between {$minPrice} and {$maxPrice}";
            //$query = "select * from items where name like :findByName and price between :minPrice and :maxPrice";
            if ($findByCategory > 0){
                $query.= " and category_id = {$findByCategory}";
                //$query.= " and category_id = :findByCategory";
            }
            if(!empty($findByDate)){
                $query.= " and publish_date > '{$findByDate}'";
                //$query.= " and publish_date > :findByDate";
            }

        } else{
            $query = "select * from items"; /* Later should be deleted, i believe */
        }

        $query.= !$getNumRows ? " limit {$skip}, {$perPage}" : "";
        //$query.= !$getNumRows ? " limit :skip , :perPage" : "";
        $stmt = $db->query($query);
        //$stmt = $db->prepare($query);

        //$stmt->execute([":findByName"=>$findByName, ":minPrice"=>$minPrice, ":maxPrice"=>$maxPrice, ":findByCategory"=>$findByCategory, ":findByDate"=>$findByDate, ":skip"=>$skip, ":perPage"=>$perPage]) or die(print_r($stmt->errorInfo(), true));

        if ($getNumRows){
            return $stmt->rowCount();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}