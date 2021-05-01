<?php


trait ClientConnectPartials
{
    private static string $path = "";

    public static function clientConnectParts($params)
    {

        require_once CLIENT_ROOT . "/template/partials/header.php";

        if (isset($params['loginPage'])) {
            isset($_COOKIE['client_email']) ?  self::$path = "/views/basket/showClientItemsTable.php" : self::$path = "/views/login/login.php";
            require_once CLIENT_ROOT . self::$path;
            //require_once CLIENT_ROOT . "/views/basket/showClientItemsTable.php" : require_once CLIENT_ROOT . "/views/login/login.php";
        } elseif (isset($params['registrationPage'])) {
            isset($_COOKIE['client_email']) ?  self::$path = "/views/basket/showClientItemsTable.php" : self::$path = "/views/registration/registration.php";
            require_once CLIENT_ROOT . self::$path;
        } else {
            require_once CLIENT_ROOT . $params['main_content_path'];
        }

        require_once CLIENT_ROOT . "/template/partials/footer.php";
    }
}


//if(!isset($_COOKIE['client_email'])){
//    $filename = isset($params['loginPage']) ? "/views/login/login.php" : "/views/registration/registration.php";
//    require_once CLIENT_ROOT . $filename;
//}