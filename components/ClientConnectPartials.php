<?php


trait ClientConnectPartials
{
    public static function clientConnectParts($params){
        require_once CLIENT_ROOT . "/template/partials/header.php";
        if(!isset($_COOKIE['email'])){
            $filename = isset($params['loginPage']) ? "/views/login/login.php" : "/views/registration/registration.php";
            require_once CLIENT_ROOT . $filename;
        } else{
            require_once CLIENT_ROOT . $params['main_content_path'];
        }
        require_once CLIENT_ROOT . "/template/partials/footer.php";
    }
}