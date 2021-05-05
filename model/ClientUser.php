<?php

require_once __DIR__ . "/../components/DB.php";

class ClientUser
{

    public static function userRegistration($data)
    {
        $db =   DB::getConnection();
        $query = "insert into clients(client_name, client_email, client_phone, client_address, client_notes, client_password) values(:userName, :userEmail, :userPhone, :userAddress, :userNotes, :userPassword)";
        $stmt = $db->prepare($query);
        $stmt->execute([":userName" => $data['userName'] , ":userEmail" => $data['userEmail'], ":userPhone" => $data['userPhone'], ":userAddress" => $data['userAddress'], ":userNotes" => $data['userNotes'] ,":userPassword" => hash("sha256", $data['userPassword'])]);

        if($stmt){
            return $db->lastInsertId();
        }
        return false;
    }

    public static function userAlreadyExists($data): bool
    {
        $db = DB::getConnection();
        $query = "select * from clients where client_email = :clientEmail and client_password = :clientPassword";
        $stmt = $db->prepare($query);
        $stmt->execute([":clientEmail" => $data['userEmail'], ":clientPassword" => hash("sha256",$data['userPassword'])]) or die(print_r($stmt->errorInfo(), true));
        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
    }

    public static function findUserByCredentials($data)
    {
        $db = DB::getConnection();
        $query = "select client_id from clients where client_email = ? and client_password = ?";
        list($userEmail, $userPassword) = array_values($data);
        $stmt = $db->prepare($query);
        $stmt->execute([$userEmail, hash("sha256", $userPassword)]) or die(print_r($stmt->errorInfo(), true));
        if ($stmt){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public static function findUserById($id){
        $db = DB::getConnection();
        $query = "select * from clients where client_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]) or die(print_r($stmt->errorInfo(),true));
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    public static function findUserByEmail($email){
        $db = DB::getConnection();
        $query = "select * from clients where client_email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]) or dir(print_r($stmt->errorInfo(),true));
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    public static function changeUserPassword($id, $newPassword){
        $db = DB::getConnection();
        $query = "update clients set client_password = ? where client_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$newPassword,$id]) or die(print_r($stmt->errorInfo(),true));
        return !!$stmt;
    }
}