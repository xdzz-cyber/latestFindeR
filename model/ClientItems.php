<?php


class ClientItems
{
    public static function getItemsNumRows($search_params){
        $rowsCount = ClientItems::findItemsByFilters($search_params,true);
        //var_dump($rowsCount);
        //echo "rowsCount is $rowsCount";
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
        //echo "zahod";
        $db = DB::getConnection();
        $skip = 0;
        $perPage = 0;
        //print_r($search_params);
        if ($search_params){
            $minPrice = $search_params['minPrice'] ?? ClientItems::getMinPrice();
            $maxPrice = $search_params['maxPrice'] ?? ClientItems::getMaxPrice();
            $findByDate = $search_params['findByDate'] ?? "";
            $findByCategory = $search_params['findByCategory'] ?? 0;
            $findByName = !empty($search_params['searchName']) ? "'%{$search_params['searchName']}%'" : "'%%'";

            $skip = $search_params['skip'];
            $perPage = $search_params['perPage'];

            //$query = "select * from items where name like :findByName and price between :minPrice and :maxPrice";
            //$execute_array = [":findByName"=>$findByName, ":minPrice"=>$minPrice, ":maxPrice"=>$maxPrice];
            $query = "select * from items where name like {$findByName} and price between {$minPrice} and {$maxPrice}";
            if ($findByCategory > 0){
                //$query.=" and category_id = :findByCategory";
                //$execute_array[":findByCategory"] = $findByCategory;
                $query.= " and category_id = {$findByCategory}";
            }
            if(!empty($findByDate)){
                //$query.= " and publish_date = :findByDate";
                //$execute_array[":findByDate"] = $findByDate;
                $query.= " and publish_date > '{$findByDate}'";
            }

        } else{
            $query = "select * from items"; /* Later should be deleted, i believe */
        }

        //$query.= " limit :skip,:perPage";
        $query.= !$getNumRows ? " limit {$skip}, {$perPage}" : "";

        //$execute_array[":skip"] = $skip;
        //$execute_array[":perPage"] = $perPage;

        //print_r($execute_array);
        $stmt = $db->query($query);
        //print_r($stmt);

        //$stmt = $db->prepare($query);
        //$stmt->execute($execute_array);

        //echo $query . "<br>";

        if ($getNumRows){
            return $stmt->rowCount();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}