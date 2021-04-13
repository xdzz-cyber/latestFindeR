<?php


class ClientRouter
{
    public $routes = [];

    public function __construct()
    {
        $this->routes = include (CLIENT_ROOT . "/config/routes.php");
    }

    public function getURI(){
        $URI = $_SERVER['REQUEST_URI'];
        return ltrim($URI,"/");
    }

    public function run(){
        $URI = $this->getURI();

        foreach ($this->routes as $pattern => $path){
            if (preg_match("~$pattern~", $URI)){

                /* Update basket items counter whenever we reload page */

                /* */

                $internal_data =  preg_replace("~$pattern~", $path, $URI);

                $sliced_data = explode("/",$internal_data);

                $sliced_data = array_filter($sliced_data, function ($el){
                    return $el !== "client";
                });

                $controllerName = ucfirst(array_shift($sliced_data) . "Controller");

                $actionName = "action" .  ucfirst(array_shift($sliced_data));

                $controllerFile = CLIENT_ROOT . "/controllers/$controllerName.php";

                if (file_exists($controllerFile)){
                    $params = $sliced_data;
                    include_once ($controllerFile);
                    $controllerObj = new $controllerName;
                    $result = call_user_func_array([$controllerObj,$actionName],$params);

                    if ($result){
                        break;
                    }
                }
            }
        }

    }
}