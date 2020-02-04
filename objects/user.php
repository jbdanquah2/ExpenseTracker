<?php

class User {

private $conn;


    public function __construct($db){
        $this->conn = $db;
//        echo " i'm also connected";
    }

public function createUser($first_name,
                           $last_name,
                           $email,                     
                           $pssword)
{

    try{

    $stmt = $this->conn->prepare("SELECT email FROM user WHERE email=:email");
    $stmt->bindparam(":email",$email);
       $stmt->execute();
        if ($stmt->rowCount() > 0) {
             echo "<span class='text-danger mb-0 ml-2'>Username or email already exist - </span>";
            return false;
        }else{

            $statement = $this->conn->prepare(
            "INSERT INTO user(first_name,last_name, email, pssword) VALUES (:first_name,:last_name,:email,:pssword);

            ");

            $statement->bindparam(":first_name",$first_name);
            $statement->bindparam(":last_name",$last_name);
            $statement->bindparam(":email",$email);
            $statement->bindparam(":pssword",$pssword);

            $statement->execute();

        return true;

        }
    }catch (PDOException $ex){
        echo "Sorry unable to register. Please again";
    return false;
    }
}




public function getUser($email){

    try{

        $statement = $this->conn->prepare("SELECT user_Id,first_name,last_name,email,pssword, status FROM user WHERE email=:email AND status ='Active'");
        $statement->execute(array(":email"=>$email));
        $dataRows = $statement->fetch(PDO::FETCH_ASSOC);

    return $dataRows;

    } catch (PDOException $ex){
        echo $ex->getMessage();
    }
}

public function updateUser($userName, $newPssword){
  $stmt = $this->conn->prepare("UPDATE app_user SET pssword=:newPssword WHERE userName=:userName");
  $stmt->bindParam(":userName",$userName);
  $stmt->bindParam(":newPssword",$newPssword);
  $stmt->execute();
return true;
}

public function updateUserStatus($userName, $userStatus){
  $stmt = $this->conn->prepare("UPDATE app_user SET userStatus=:userStatus WHERE userName=:userName");
  $stmt->bindParam(":userName",$userName);
  $stmt->bindParam(":userStatus",$userStatus);
  $stmt->execute();
return true;
}


}


?>

