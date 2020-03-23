<?php

class Expense {

private $conn;
public $expense_name;
public $cost;
public $description;
public $user_Id;
public $budget_id;
public $expense_id;



    public function __construct($db){
        $this->conn = $db;
//        echo " i'm also connected";
    }

public function postExpense(){

    try{
        $statement = $this->conn->prepare(
        "INSERT INTO expense(expense_name, cost, description, user_Id) VALUES (:expense_name,:cost, :description, :user_Id);
         set @eid = last_insert_id();
         INSERT INTO expense_budget(expense_id, budget_id) VALUES(@eid, :budget_id);
        ");
        
        $statement->bindparam(":expense_name",$this->expense_name);
        $statement->bindparam(":cost",$this->cost);
        $statement->bindparam(":description",$this->description);
        $statement->bindparam(":user_Id",$this->user_Id);
        $statement->bindparam(":budget_id",$this->budget_id);
        $statement->execute();

return true;

    }catch (PDOException $ex){
        echo $ex->getMessage();
return false;
    }
}
    
public function getExpense(){

    try{
        $statement = $this->conn->prepare("SELECT 
            e.expense_id,
            b.budget_amount,
            b.budget_id,
            b.month_year,
            e.expense_name,
            e.cost,
            e.description,
            e.user_Id,
            DATE_FORMAT(e.created_datetime, '%D %b, %Y') AS created_datetime
        FROM
            expense e
                JOIN
            expense_budget eb ON eb.expense_id = e.expense_id
                JOIN
            budget b ON b.budget_id = eb.budget_id
        WHERE
            user_Id = :user_Id
        ORDER BY expense_id DESC;");
        $statement->execute(array(":user_Id"=>$this->user_Id));
        //$dataRows = $statement->fetch(PDO::FETCH_ASSOC);

return $statement;

        } catch (PDOException $ex){
        echo $ex->getMessage();
        }
}  

public function getEditExpense(){

    try{

        $statement = $this->conn->prepare("SELECT expense_id,expense_name, cost, description, user_Id, DATE_FORMAT(created_datetime, '%D %b, %Y') as created_datetime FROM expense WHERE expense_id = :expense_id ORDER BY DATE_FORMAT(created_datetime, '%D %b,%Y')  desc;");
        $statement->execute(array(":expense_id"=>$this->expense_id));
        $dataRows = $statement->fetch(PDO::FETCH_ASSOC);

return $dataRows;

        } catch (PDOException $ex){
        echo $ex->getMessage();
        }
    } 

public function countExpense() {
        try {
            $stmt = $this->conn->prepare("SELECT 
                COUNT(*) AS 'num_expense', SUM(cost) AS 'total_expense'
            FROM
                expense e
                    JOIN
                expense_budget eb ON e.expense_id = eb.expense_id
            WHERE
                e.User_Id = :user_Id;");
            $stmt -> execute(array(":user_Id" => $this->user_Id));
            $dataRows = $stmt->fetch(PDO::FETCH_ASSOC);
    return $dataRows;
        } catch (PDOException $ex){
            echo $ex->getMessage();
        }
    }

public function putExpense() {
    try {
        $stmt = $this->conn->prepare("UPDATE expense SET expense_name = :expense_name, cost = :cost , description = :description WHERE expense_id = :expense_id;");
        $stmt -> bindParam(":expense_id",$this->expense_id);
        $stmt -> bindParam(":expense_name",$this->expense_name);
        $stmt -> bindParam(":cost",$this->cost);
        $stmt -> bindParam(":description",$this->description);

        $stmt -> execute();
        return true;
    }catch(PDOException $ex) {
        echo $ex->getMessage();
    }
    
}
    
public function deleteExpense() {
    try {
        $stmt = $this->conn->prepare("
        DELETE FROM expense_budget WHERE expense_id = :expense_id;
        DELETE FROM expense WHERE expense_id = :expense_id;
        ");
        
        $stmt -> bindParam(":expense_id", $this->expense_id);
        $stmt->execute();
        return true;
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
  }
    
}


?>

