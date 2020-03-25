<?php

class Expense {

private $conn;
public $expense_item_name;
public $cost;
public $description;
public $user_Id;
public $budget_id;
public $expense_id;
public $expense_item_id;



    public function __construct($db){
        $this->conn = $db;
//        echo " i'm also connected";
    }

public function postExpense(){

    try{
        $statement = $this->conn->prepare(
        "INSERT INTO expense(expense_item_id, cost, description, user_Id) VALUES (:expense_item_id,:cost, :description, :user_Id);
        ");
        
        $statement->bindparam(":expense_item_id",$this->expense_item_id);
        $statement->bindparam(":cost",$this->cost);
        $statement->bindparam(":description",$this->description);
        $statement->bindparam(":user_Id",$this->user_Id);
//        $statement->bindparam(":budget_id",$this->budget_id);
        $statement->execute();

return true;

    }catch (PDOException $ex){
        echo $ex->getMessage();
return false;
    }
}
    
public function getExpense(){

    try{
        $statement = $this->conn->prepare("SELECT DISTINCT
            e.user_id,
            e.expense_id,
            e.expense_item_id,
            e.cost,
            e.description,
            ei.expense_item_name,
            ei.expense_item_desc,
            DATE_FORMAT(e.created_datetime, '%D %b, %Y') AS created_datetime,
            b.budget_id,
            b.budget_type,
            b.month_year,
            b.budget_amount
        FROM
            expense e
                JOIN
            expense_item ei ON ei.expense_item_id = e.expense_item_id
                JOIN
            budget b ON b.user_id = e.user_id
        WHERE
            e.user_id = :user_Id
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

        $statement = $this->conn->prepare("SELECT 
            expense_id,
            expense_item_name,
            cost,
            description,
            user_Id,
            DATE_FORMAT(e.created_datetime, '%D %b, %Y') AS created_datetime
        FROM
            expense e
                JOIN
            expense_item ei ON ei.expense_item_id = e.expense_item_id
        WHERE
            expense_id =:expense_id;");
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
            WHERE
                e.user_id = :user_Id;");
            $stmt -> execute(array(":user_Id" => $this->user_Id));
            $dataRows = $stmt->fetch(PDO::FETCH_ASSOC);
    return $dataRows;
        } catch (PDOException $ex){
            echo $ex->getMessage();
        }
    }

public function putExpense() {
    try {
        $stmt = $this->conn->prepare("UPDATE expense SET cost = :cost , description = :description WHERE expense_id = :expense_id;");
        $stmt -> bindParam(":expense_id",$this->expense_id);
//        $stmt -> bindParam(":expense_name",$this->expense_name);
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
    
public function getExpenseItems(){

    try{
        $statement = $this->conn->prepare("SELECT 
            ei.expense_item_id,
            ei.expense_item_name,
            ei.expense_item_desc,
            b.budget_id,
            b.user_id,
            b.budget_type,
            b.month_year,
            b.budget_amount,
            b.budget_period_start,
            b.budget_period_end,
            b.created_datetime
        FROM
            expense_item ei 
        JOIN budget_line_item bli on bli.expense_item_id = ei.expense_item_id
        JOIN budget b on b.budget_id = bli.budget_id
        WHERE b.user_id =:user_Id
        ORDER BY  ei.expense_item_id desc;");
        $statement->execute(array(":user_Id"=>$this->user_Id));
        //$dataRows = $statement->fetch(PDO::FETCH_ASSOC);

return $statement;

        } catch (PDOException $ex){
        echo $ex->getMessage();
        }
}  
}
?>

