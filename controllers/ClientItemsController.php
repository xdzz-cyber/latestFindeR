<?php

/* Here goes model connection */
require_once CLIENT_ROOT . "/model/ClientItems.php";
require_once CLIENT_ROOT . "/model/ClientItemsCategories.php";
class ClientItemsController
{
    private $params = [];
    private $search_params = [];
    private $perPage = 0;

    public function actionClientPagination($current_page, $custom_search_params = []){

        if (isset($_COOKIE['client_search_name']) && !empty($_COOKIE['client_search_name'])){
            $custom_search_params['searchName'] = $_COOKIE['client_search_name'];
        }

        $this->perPage = 4;
        $current_page = intval($current_page);
        $skip = ($current_page - 1) * $this->perPage;

        $this->search_params = ["skip"=>$skip, "perPage"=>$this->perPage];  //, ...$custom_search_params

        foreach ($custom_search_params as $k=>$v){
            $this->search_params[$k] = $v;
        }

        $numRows =  ClientItems::getItemsNumRows($this->search_params);

        $numPages = ceil($numRows / $this->perPage);

        $prev = $current_page - 1;
        $next = $current_page + 1;

        $hasPrev = $current_page == 1 ? false : true;
        $hasNext = $current_page == $numPages ? false : true;

        $items = ClientItems::findItemsByFilters($this->search_params);
        $categories = ClientItemsCategories::getCategories();

        foreach ($items as $item){
            if (!$item['photo']){
                $item['photo'] = "/template/images/noPhoto.png";
            }
        }

        $minPrice = ClientItems::getMinPrice(); /* FIX MAXPRICE AND MINPRICE LATER, SHOULD DO IT FROM JS, USIMG ASYNC CALS TO DB */
        $maxPrice = ClientItems::getMaxPrice();

        $this->params = ["main_content_path"=>"/views/items/item_index.php", "items"=>$items, "categories"=> $categories, "numPages"=>$numPages,
            "current_page"=>$current_page, "hasPrev"=>$hasPrev, "hasNext"=>$hasNext, "prev"=>$prev, "next"=>$next, "minPrice"=>$minPrice, "maxPrice"=>$maxPrice];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionFindItemsByName(){
        $data = DB::protectData($_POST);
        $name = $data['searchName'];

        if (!$name){
            $this->actionClientPagination(1);
        } else {
            $custom_search_params = ["searchName" => $name];
            $this->actionClientPagination(1, $custom_search_params);
        }

        return true;
    }

    public function actionFindItemsByFilters(){
        $data = DB::protectData($_POST);

        $findByCategory = $data['findByCategory'] ?? "";
        $findByDate = $data['findByDate'] ?? "";
        $minPrice = $data['minPrice'] ?? "";
        $maxPrice = $data['maxPrice'] ?? "";

        $custom_search_params = ["findByCategory"=>$findByCategory, "findByDate"=>$findByDate, "maxPrice"=>$maxPrice, "minPrice"=>$minPrice];
        $this->actionClientPagination(1, $custom_search_params);
        return true;
        // LATER DO WITH RANGE OF PRICE
    }

}