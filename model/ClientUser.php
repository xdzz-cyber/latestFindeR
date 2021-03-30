<?php


class ClientUser
{
    public static function userRegistration($data)
    {
        $db = DB::getConnection();
        $query = "insert into users(email,password,registration_date,photo) values(?,?,(select CURDATE()), ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$data['userEmail'], hash("sha256", $data['userPassword']), $data['userPhoto']]);

        if($stmt){
            return true;
        }
        return false;
    }

    public static function userAlreadyExists($data){
        $db = DB::getConnection();
        $query = "select * from users where email = ? and password = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$data['userEmail'], hash("sha256",$data['userPassword'])]);

        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
    }
}