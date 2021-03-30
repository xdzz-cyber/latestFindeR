<?php

/* Here goes model connection */
require_once CLIENT_ROOT . "/model/ClientItems.php";
class ClientItemsController
{
    private $params = [];
    private $search_params = [];
    private $perPage = 0;

    public function actionClientPagination($current_page){
        $numRows = ClientItems::getItemsNumRows();
        $this->perPage = 4;
        $current_page = intval($current_page);
        $skip = ($current_page - 1) * $this->perPage;

        $numPages = ceil($numRows / $this->perPage);

        $prev = $current_page - 1;
        $next = $current_page + 1;

        $hasPrev = $current_page == 1 ? false : true;
        $hasNext = $current_page == $numPages ? false : true;

        $this->search_params = ["skip"=>$skip, "perPage"=>$this->perPage];
        $items = ClientItems::getPaginationItems($this->search_params);

        $minPrice = ClientItems::getMinPrice();
        $maxPrice = ClientItems::getMaxPrice();


        foreach ($items as $item){
            if (!$item['photo']){
                $item['photo'] = "/template/images/noPhoto.png";
            }
        }

        $this->params = ["main_content_path"=>"/views/items/item_index.php", "items"=>$items, "numPages"=>$numPages,
            "current_page"=>$current_page, "hasPrev"=>$hasPrev, "hasNext"=>$hasNext, "prev"=>$prev, "next"=>$next, "minPrice"=>$minPrice, "maxPrice"=>$maxPrice];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionFind(){
        $data = DB::protectData($_POST);
    }
}