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
                <h5 class=" mb-2">Record Budget</h5>
                <form method="GET">                
                    <input required name="expense_name" class="form-control pb-2 pt-2 border-bottom"  type="text" placeholder="Expense Type"><br/>
                    <input required name="cost" class="form-control mb-2 pb-2 pt-2  border-bottom" size="50" type="text" placeholder="Budget"><br>
                    <textarea required name="description" class="form-control pb-2 pt-2 border-bottom" width="50" type="textarea" placeholder="Item Description"></textarea>
                    <br>
                    <input name="save" class="btn btn-primary"  type="submit" value="save">
                </form>            
            </div>
        </div>
  
        <div class="col-md col-sm">
            <div id="review" class="">
                
                <br>
                <table class="table table-hover" class="p-3">
                    <h5>Review Budget</h5> | <span class="text-warning">Count: <?php echo $num_expense?></span> | <span class="text-warning">Total: <?php echo $total_expense?></span>
                    <input class="form-control" id="myInput" type="text" placeholder="Search Budget...">
                    <thead class="thead-dark">
                      <tr>         
                        <th scope="col">#</th>
                        <th scope="col">Expense</th>
                        <th scope="col">Budget (GH¢)</th>
                        <th scope="col">Actual</th>
                        <th scope="col">Over Budget</th>
                        <th scope="col">Under Budget</th>  
                      </tr>
                    </thead>
                    <tbody id="myTable" class="thead-dark">
                         
<?php
    if (isset($_SESSION['user_Id'])) {
//check if user is logged in and then
//loads all expense recorded by the user if any
        
      $count = 0;
      $expense2 ->user_Id = $_SESSION['user_Id'];
    
      $stmt = $expense2 -> getExpense();
      $stmt2 = $expense2 -> countExpense();    
        $num_exp = $stmt2['num_expense'];
      while($rows = $stmt ->fetch(PDO::FETCH_ASSOC)) {
          $count++;
          
          $expense_id = $rows['expense_id'];
          $expense_name = $rows['expense_name'];
          $cost = $rows['cost'];
          $description = $rows['description'];
          $created_datetime = $rows['created_datetime'];
                  echo '<tr> 
                  
                  <th>'.$count.'</td>
                  
                        <td>'.$expense_name.'</td>
                        <td>'.$cost.'</td>
                        <td>'.$description.'</td>
                        <td>'.$created_datetime.'</td>
                        <td><a href="edit_expense.php?expense_id='.$expense_id.'"><button type="button" class="bg-warning" name="expense_id" value="'.$expense_id.'"<><small>Update</small></button></a>
                        
                        <button onclick="askDelete('.$expense_id.','.$num_exp.')" type="button" class="bg-warning" name="expense_id" value="'.$expense_id.'"<><small>Delete..</small></button>
                        </td>
                        </tr>
                        ';
        
        }
  }else{
   echo 'hmmmm';
}
                    

 if (isset($_GET['deleteExpense'])) {
 //checks and delete expense with confirmation from user
     $expense->expense_id = $_GET['deleteExpense'];
     
         $stmt = $expense->deleteExpense();
    
 }

?>
                                      
                   </tbody>
                </table>
            </div>
        </div>
    </div>

 <?php
include "footer.php";
?>