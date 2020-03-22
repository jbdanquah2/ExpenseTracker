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
                           $pssword,$budget_type,$month_year,$budget_amount,$budget_period_start,$budget_period_end){


    $stmt = $this->conn->prepare("SELECT email FROM user WHERE email=:email");
    $stmt->bindparam(":email",$email);
       $stmt->execute();
        if ($stmt->rowCount() > 0) {
             echo "<br><span class='text-danger mb-0 ml-2'>Username or email already exist</span>";
            return false;
        }else{

            $statement = $this->conn->prepare(
            "INSERT INTO user(first_name, last_name, email, pssword) VALUES (:first_name,:last_name,:email,:pssword);
             SET @userId =  LAST_INSERT_ID();
             
             INSERT INTO budget(budget_type, month_year, budget_amount, budget_period_start, budget_period_end)
             VALUES(:budget_type,:month_year,:budget_amount,:budget_period_start,:budget_period_end);
             SET @budgetId =  LAST_INSERT_ID();
             
             INSERT INTO expense (expense_name, cost, description, user_id) 
             VALUES ('test expense', 0, 'expense to test account', @userId);
             SET @expenseId =  LAST_INSERT_ID();

             INSERT INTO expense_budget (expense_id, budget_id)
             VALUES (@expenseId, @budgetId);
            ");
            

            $statement->bindparam(":first_name",$first_name);
            $statement->bindparam(":last_name",$last_name);
            $statement->bindparam(":email",$email);
            $statement->bindparam(":pssword",$pssword);
            $statement->bindparam(":budget_type",$budget_type);
            $statement->bindparam(":month_year",$month_year);
            $statement->bindparam(":budget_amount",$budget_amount);
            $statement->bindparam(":budget_period_start",$budget_period_start);
            $statement->bindparam(":budget_period_end",$budget_period_end);

            $statement->execute();
            
        return true;

        }
return false;
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

