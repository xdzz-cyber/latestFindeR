<?php

/* Here goes model for client user */
require_once CLIENT_ROOT . "/model/ClientUser.php";
class ClientUserController
{
    private $params = [];
    private $search_params = [];

    public function actionClientRegistration(){
        $this->params = ["main_content_path"=>"/views/registration/registration.php", "registrationPage"=>true];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionClientRegistrationResult(){
        $data = DB::protectData($_POST);
        $error = "";
        $user_id = 0;
//        if ($_FILES['userPhoto']['error'] == 0){
//            $filenameTMP = $_FILES['userPhoto']['tmp_name'];
//            $filename = $_FILES['userPhoto']['name'];
//            move_uploaded_file($filenameTMP, CLIENT_ROOT . "/template/images/{$filename}");
//            $data['userPhoto'] = $filename;
//        } else{
//            $data['userPhoto'] = "noPhoto.png";
//        }


        if(ClientUser::userAlreadyExists($data)){
            $error = "User with given credentials already exists";
        } else if($user_id = ClientUser::userRegistration($data)){
            setcookie("client_id", $user_id, time() + 60 * 60 * 24, "/");
            setcookie("client_email", $data['userEmail'], time() + 60 * 60 * 24, "/");
        } else{
            $error = "Wrong credentials. Please, try again";
        }

        if (!$error){
            header("location: ../clientUser/showClientItemsTable");
        } else{
            $this->params = ["main_content_path"=>"/views/registration/registration.php", "error"=>$error, "registrationPage"=>true];
            ClientConnectPartials::clientConnectParts($this->params);
        }


        return true;
    }

    public function actionClientLogin(){
        $this->params = ["main_content_path"=>"/views/login/login.php", "loginPage"=>true];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionClientLoginResult(){
        $data = DB::protectData($_POST);
        if(ClientUser::userAlreadyExists($data)){
            $user_id = ClientUser::findUserByCredentials($data)['client_id'];
            setcookie("client_id", $user_id, time() + 60 * 60 * 24, "/");
            setcookie("client_email", $data['userEmail'], time() + 60 * 60 * 24, "/");
            header("location: ../clientUser/showClientItemsTable");
        } else{
            $error = "Wrong credentials";
            $this->params = ["main_content_path"=>"/views/login/login.php", "error"=>$error, "loginPage"=>true];
            ClientConnectPartials::clientConnectParts($this->params);
        }
        return true;
    }

    public function actionShowClientItemsTable(): bool
    {
        //$user_id = isset($_COOKIE['client_id']) ? $_COOKIE['client_id'] :  0;
        $this->params = ["main_content_path"=>"/views/basket/showClientItemsTable.php"];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionLogout(){
        setcookie("client_email", "", time() - 7200, "/");
        setcookie("client_id", "", time() - 7200, "/");
        $_COOKIE = [];
        header("location: ../clientItems/clientPagination/1");
        return true;
    }

}