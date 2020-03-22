<?php
session_start();

include_once "config/connection.php";
include_once "objects/expense.php";


$database = new Database();
$db = $database->getConnection();

$expense = new Expense($db);
$expense3 = new Expense($db);
if (isset($_SESSION['user_Id'])) {
      $expense->user_Id = $_SESSION['user_Id'];
      $st = $expense -> getExpense();
      $rows = $st ->fetch(PDO::FETCH_ASSOC);
      $count = 0;
      $stmt = $expense -> countExpense();
      $num_expense = $stmt['num_expense'] > 1 ? $stmt['num_expense']." items" : $stmt['num_expense']." item";
      $total_expense = $stmt['total_expense'] > 0 ? "GH¢ ". $stmt['total_expense'] : "GH¢ ". 0;
        $month = $rows['month_year'];
        $name ="Welcome ". $_SESSION['first_name'];
        $budget = $rows['budget_amount'];
        //$_SESSION['$budget_id'] = $rows['budget_id'];
        $balance = $budget - $stmt['total_expense'] ;
  }

include "header.php";
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
        <div class="col-md col-sm p-5">
            
            <div id="record" class="m">
                <h2 class=" mb-2">Record</h2>
                <form method="GET">                
                    <input required name="expense_name" class="form-control pb-2 pt-2 border-bottom"  type="text" placeholder="Expense Type"><br/>
                    <input required name="cost" class="form-control mb-2 pb-2 pt-2  border-bottom" size="50" type="text" placeholder="cost"><br>
                    <textarea required name="description" class="form-control pb-2 pt-2 border-bottom" width="50" type="textarea" placeholder="Description"></textarea>
                    <br>
                    <input name="save" class="btn btn-primary"  type="submit" value="save">
                </form>            
            </div>
        </div>
  
        <div class="col-md col-sm">
            <div id="review" class="">
                

<?php
                                  
  
?>
                <br>
                <table class="table table-hover" class="p-3">
                    <h3>Update</h3> | <small class="text-warning">Count: <?php echo $num_expense?></small> | <small class="text-warning">Total: <?php echo $total_expense?></small>
<!--                    <input class="form-control" id="myInput" type="text" placeholder="Search Expense...">-->
                    <thead class="thead-dark">
                      <tr>         
                        <th scope="col">#</th>
                        <th scope="col">Expense</th>
                        <th scope="col">Cost(GHS)</th>
                        <th scope="col">Description</th>
                        <th scope="col" >Date Recorded</th>
                        <th scope="col" >Edit</th>  
                      </tr>
                    </thead>
                    <tbody id="myTable" class="thead-dark">
                         
<?php
    
    
    if (isset($_GET['expense_id'])) {
// get the expense to be edited
        
      $count = 0;
      $expense3->expense_id = $_GET['expense_id'];
      $stmt = $expense3 -> getEditExpense();
      
          $count++;
          $expense_id = $stmt['expense_id'];
          $expense_name = $stmt['expense_name'];
          $cost = $stmt['cost'];
          $description = $stmt['description'];
          $created_datetime = $stmt['created_datetime'];
          echo '<tr> 
           <form method="GET">
                <th>'.$count.'</td>
                <td>'.'<input name="expense_name" value="'.$expense_name.'">'.'</td>
                <td>'.'<input name="cost" size="4" value="'.$cost.'">'.'</td>
                <td>'.'<input name="description" height="48" value="'.$description.'">'.'</td>
                <td>'.$created_datetime.'</td>
                <td><button type="submit" class="bg-warning" name="exp_id" value="'.$expense_id.'"><small>Update</small></button></td>
                </tr>
            </form>
                ';
        
        
  }else{
   echo 'hmmmm';
}
 
if (isset($_GET['exp_id'])) {
//updates the expense with the new changes
    
    $expense3->expense_name = $_GET['expense_name'];
    $expense3->cost = $_GET['cost'];
    $expense3->description = $_GET['description'];
    $expense3->expense_id = $_GET['exp_id'];

    $stmt = $expense3 -> putExpense();
    header("location:home.php");
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