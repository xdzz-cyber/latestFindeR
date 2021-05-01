<?php

/* here goes model */
require_once CLIENT_ROOT . "/model/ClientItems.php";
require_once CLIENT_ROOT . "/model/ClientRelation.php";

class ClientBasketController
{
    private $params;

    /* private $search_params = []; */

    public function actionAddItem($id)
    {
        $exists = false;
        $foundItem = ClientItems::getItemById($id);

        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        if (count($_SESSION['basket']) > 0) {
            for ($i = 0; $i < count($_SESSION['basket']); $i++) {
                if ($_SESSION['basket'][$i]['id'] == $id) {
                    $exists = true;
                    $_SESSION['basket'][$i]['count']++;
                    break;
                }
            }
        }

        if (count($_SESSION['basket']) < 1 || !$exists) {
            $_SESSION['basket'][] = ['id' => $id, "name" => $foundItem['name'], "price" => $foundItem['price'], "photo" => $foundItem['photo'], "count" => 1];
        }

        $perPage = 3;
        $lastPage = ceil(count($_SESSION['basket']) / $perPage);
        header("Location: /clientBasket/showBasketItems/" . $lastPage);
    }

    public function actionShowBasketItems($current_page = 1)
    {
        $basketItems = $_SESSION['basket'] ?? [];
        $current_page = intval($current_page);
        if ($basketItems) {
            $perPage = 3;
            $skip = ($current_page - 1) * $perPage;
            $numPages = ceil(count($basketItems) / $perPage);

            $basketItems = array_slice($basketItems, $skip, $skip + $perPage);
            $this->params = ["main_content_path" => "/views/basket/showBasketItems.php", "items" => $basketItems, "current_page"=>$current_page, "numPages"=>$numPages];
            ClientConnectPartials::clientConnectParts($this->params);
        } else {
            ClientItems::findItemsByFilters([]);
        }

        return true;
    }

    public function actionFinalSubmitBasketItems(){
        $client_id = isset($_COOKIE['client_id']) ? $_COOKIE['client_id'] : 0;
        $info = "";
        if(ClientRelation::submitItemsToRelationTable($client_id)){
            foreach ($_SESSION['basket'] as $item){
                unset($item);
            }
            unset($_SESSION['basket']);
            $_SESSION['basket'] = [];
            $info = "Successfully completed order, please, wait 'til our worker will contact you.";
        } else{
            $info = "Error making final complete of order. Please, try again.";
        }
        $this->params = ["main_content_path"=>"/views/basket/successBasketOrder.php", "info"=>$info];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

//    private function actionGetPaginatedBasketItems($from, $to){
//        $response = [];
//        if (isset($_SESSION['basket'])){
//            for ($i=$from;$i < $to; $i++){
//                $response[] = $_SESSION['basket'][$i];
//            }
//            return $response;
//        }
//        return false;
//    }

//    public static function actionGetBasketItemsCount(){
//        $count = 0;
//        if (isset($_SESSION['basket'])){
//            foreach ($_SESSION['basket'] as $item){
//                $count+=$item['count'];
//            }
//        }
//        return $count;
//    }
}