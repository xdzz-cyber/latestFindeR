<?php

require_once CLIENT_ROOT . "/model/ClientItems.php";
class ClientPagesShowController
{
    public function actionAboutPage(){
        $this->params = ["main_content_path"=>"/views/about/about.php"];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionContactPage(){
        $this->params = ["main_content_path"=>"/views/contact/contact.php"];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionSingleItemPage($id){
        $id = DB::protectData($id);
        $item = ClientItems::getItemById($id);
        $this->params = ["main_content_path"=>"/views/singleItem/singleItem.php", "item"=>$item];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }
}