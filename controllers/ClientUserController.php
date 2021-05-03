<?php

/* Here goes model for client user */
require_once CLIENT_ROOT . "/model/ClientUser.php";
/* Autoload*/
require_once CLIENT_ROOT .  '/vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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

    public function actionForgetUserPassword(){
        $this->params = ["main_content_path"=>"/views/login/forgetUserPassword.php"];
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionForgetUserPasswordResult(){
        $data = DB::protectData($_POST);
        $user_id = ClientUser::findUserByEmail($data['userEmail'])['client_id'];
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ ."/../");
        $dotenv->load();

        $mail = new PHPMailer(true);

        try {
            //Server settings             //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = getenv("EMAIL");                     //SMTP username
            $mail->Password   = getenv("EMAIL_PASSWORD");                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom(getenv("EMAIL"), 'Mailer');
            $mail->addAddress($data['userEmail']);     //Add a recipient
            $mail->addReplyTo('info@example.com', 'Information');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = "Click <b><a href=\"http://mvcshoplatest/clientUser/restorePassword/{$user_id}\">here</a></b> to restore your password";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
            $mail->clearAllRecipients();

            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }

    }

    public function actionCheckForgetUserPasswordResult(){
        $this->params = ["main_content_path"=>"/views/login/forgetUserPasswordResult.php"];
        if ($this->actionForgetUserPasswordResult()){
            $this->params["info"] = "Check your email for link to update your password.";
        } else{
            $this->params["info"] = "Error happened. Please, try again.";
        }
        ClientConnectPartials::clientConnectParts($this->params);
        return true;
    }

    public function actionRestorePassword($id){
        if (!isset($_POST['send']) && (empty($_POST['newPassword']) || empty($_POST['newPasswordRepeat']) || empty($id))){
            $this->params = ["main_content_path"=>"/views/login/restorePasswordPage.php", "user_id"=>$id, "info"=>"Please, enter new password."];
            ClientConnectPartials::clientConnectParts($this->params);
            return true;
        } else{
            $data = DB::protectData($_POST);
            $client_email = ClientUser::findUserById($id)['client_email'];
            if (ClientUser::changeUserPassword($id,hash("sha256",$data['newPassword']))){
                setcookie("client_id", $id, time() + 60 * 60 * 24, "/");
                setcookie("client_email", $client_email, time() + 60 * 60 * 24, "/");
                header("location: ../showClientItemsTable");
                return true;
            } else{
                $this->params = ["main_content_path"=>"/views/login/restorePasswordPage.php", "user_id"=>$id, "info"=>"Wrong credentials. Please, try again."];
                ClientConnectPartials::clientConnectParts($this->params);
                return true;
            }
        }
    }
}