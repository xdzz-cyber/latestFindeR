<?php

/* here goes model */
require_once CLIENT_ROOT . "/model/ClientItems.php";

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
        header("Location: /clientBasket/showBasketItems");
    }

    public function actionShowBasketItems()
    {
        $basketItems = $_SESSION['basket'] ?? [];
        if ($basketItems) {
            $this->params = ["main_content_path" => "/views/basket/showBasketItems.php", "items" => $basketItems];
            ClientConnectPartials::clientConnectParts($this->params);
        } else {
            ClientItems::findItemsByFilters([]);
        }

        return true;
    }

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