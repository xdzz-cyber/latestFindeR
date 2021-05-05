<?php


class DB
{
    public static function protectData($data){
        if (!is_array($data)){
            return htmlentities(trim($data));
        }

        foreach($data as $k=>$v){
            $v = htmlentities(trim($v));
            $data[$k] = $v;
        }

        return $data;
    }

    public static function getConnection(){
        $db_config_params = include __DIR__ . "/../config/db_config_params.php";
        return new PDO("mysql:host={$db_config_params['host']};dbname={$db_config_params['dbname']}", $db_config_params['login'], $db_config_params['pass']);
    }
}