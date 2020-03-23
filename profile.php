<?php
session_start();
include_once "config/connection.php";
include_once "objects/expense.php";

// get db connection and create db object
$database = new Database();
$db = $database->getConnection();

// create expense objects
$expense = new Expense($db);
$expense2   = new Expense($db);


  if (isset($_SESSION['user_Id'])) {
      
//gets budget, budget type, 
//total expense, count of expense...
      
      $expense2 ->user_Id = $_SESSION['user_Id'];
      $st = $expense2 -> getExpense();
      $rows = $st ->fetch(PDO::FETCH_ASSOC);
      $count = 0;
      $stmt = $expense2 -> countExpense();
      $num_expense = $stmt['num_expense'] > 1 ? $stmt['num_expense']." items" : $stmt['num_expense']." item";
      $total_expense = $stmt['total_expense'] > 0 ? "GH¢ ". $stmt['total_expense'] : "GH¢ ". 0;
        $month = $rows['month_year'];
        $name ="Welcome ". $_SESSION['first_name'];
        $budget = $rows['budget_amount'];
        $_SESSION['budget_id'] = $rows['budget_id'];
        $balance = $budget - $stmt['total_expense'] ;
  }

//includes the header file
include "header.php";


if (isset($_SESSION['user_Id']) == "") {
// checks if logged in else return to index/login page
    header("Location: index.php");
}




if (isset($_GET['save'])) {
    
//inserts new expense record to db
    
    $expense->expense_name = $_GET['expense_name'];
    $expense->cost = $_GET['cost'];
    $expense->description = $_GET['description'];
    $expense->budget_id = $_SESSION['budget_id'];
    $expense->user_Id = $_SESSION['user_Id'];
    
     $p = $expense -> postExpense();
    
    if ($p) {
         header("Location:home.php");
    }else {
        echo 'nope!!';
    }
   
    
}
?>

<div class="row" id="home">
        <div class="col-md col-sm p-5 ">
            
            <div id="record" class="position-fixed">
                <h3 class=" mb-2">Profile</h3>
               
            </div>
        </div>
  
        <div class="col-md col-sm">
            <div id="review" class="">
                <br>
                <table class="table table-hover" class="p-3">
                    <h3>Edit Profile</h3> 
                    
                </table>
            </div>
        </div>
    </div>

 <?php
include "footer.php";
?>