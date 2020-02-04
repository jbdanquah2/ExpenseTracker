<?php

class Expense {

private $conn;


    public function __construct($db){
        $this->conn = $db;
//        echo " i'm also connected";
    }

public function postExpense($expense_name, $cost, $description, $user_Id){

    try{


        $statement = $this->conn->prepare(
        "INSERT INTO expense(expense_name,cost, description, user_Id) VALUES (:expense_name,:cost, :description, :user_Id);");

        $statement->bindparam(":expense_name",$expense_name);
        $statement->bindparam(":cost",$cost);
        $statement->bindparam(":description",$description);
        $statement->bindparam(":user_Id",$user_Id);

        $statement->execute();

return true;

    }catch (PDOException $ex){
        echo "Sorry unable to save. Please again";
return false;
    }
}
    
public function getExpense($user_Id){

    try{

        $statement = $this->conn->prepare("SELECT expense_id,expense_name, cost, description, user_Id, DATE_FORMAT(created_datetime, '%D %b, %Y') as created_datetime FROM expense WHERE user_Id = :user_Id ORDER BY DATE_FORMAT(created_datetime, '%D %b,%Y')  desc;");
        $statement->execute(array(":user_Id"=>$user_Id));
        //$dataRows = $statement->fetch(PDO::FETCH_ASSOC);

return $statement;

        } catch (PDOException $ex){
        echo $ex->getMessage();
        }
}  

public function getEditExpense($expense_id){

    try{

        $statement = $this->conn->prepare("SELECT expense_id,expense_name, cost, description, user_Id, DATE_FORMAT(created_datetime, '%D %b, %Y') as created_datetime FROM expense WHERE expense_id = :expense_id ORDER BY DATE_FORMAT(created_datetime, '%D %b,%Y')  desc;");
        $statement->execute(array(":expense_id"=>$expense_id));
        $dataRows = $statement->fetch(PDO::FETCH_ASSOC);

return $dataRows;

        } catch (PDOException $ex){
        echo $ex->getMessage();
        }
    } 

public function countExpense($user_Id) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) AS 'num_expense', SUM(cost) AS 'total_expense' FROM expense WHERE User_Id = :user_Id;");
            $stmt -> execute(array(":user_Id" => $user_Id));
            $dataRows = $stmt->fetch(PDO::FETCH_ASSOC);
    return $dataRows;
        } catch (PDOException $ex){
            echo $ex->getMessage();
        }
    }

public function putExpense($expense_id,$expense_name,$cost,$description) {
    try {
        $stmt = $this->conn->prepare("UPDATE expense SET expense_name = :expense_name, cost = :cost , description = :description WHERE expense_id = :expense_id;");
        $stmt -> bindParam(":expense_id",$expense_id);
        $stmt -> bindParam(":expense_name",$expense_name);
        $stmt -> bindParam(":cost",$cost);
        $stmt -> bindParam(":description",$description);

        $stmt -> execute();
        return true;
    }catch(PDOException $ex) {
        echo $ex->getMessage();
    }
    
}
    
}


?>

