<?php
session_start();
include_once "config/connection.php";
include_once "objects/expense.php";
$database = new Database();
$db = $database->getConnection();

$expense = new Expense($db);
                                  
  if (isset($_SESSION['user_Id'])) {
      $st = $expense -> getExpense($_SESSION['user_Id']);
      $rows = $st ->fetch(PDO::FETCH_ASSOC);
      $count = 0;
      $stmt = $expense -> countExpense($_SESSION['user_Id']);
      $num_expense = $stmt['num_expense'] > 1 ? $stmt['num_expense']." items" : $stmt['num_expense']." item";
      $total_expense = $stmt['total_expense'] > 0 ? "GH¢ ". $stmt['total_expense'] : "GH¢ ". 0;
        $month = $rows['month_year'];
        $name ="Welcome ". $_SESSION['first_name'];
        $budget = $rows['budget_amount'];
        $_SESSION['budget_id'] = $rows['budget_id'];
        $balance = $budget - $stmt['total_expense'] ;
  }
  
include "header.php";


if (isset($_SESSION['user_Id']) == "") {
    header("Location: index.php");
}




if (isset($_GET['save'])) {
    
    $expense->expense_name = $_GET['expense_name'];
    $expense->cost = $_GET['cost'];
    $expense->description = $_GET['description'];
    $expense->user_Id = $_SESSION['user_Id'];
    $expense->budget_id = $_SESSION['budget_id'];
    
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
                

                <br>
                <table class="table table-hover" class="p-3">
                    <h3>Review</h3> | <small class="text-warning">Count: <?php echo $num_expense?></small> | <small class="text-warning">Total: <?php echo $total_expense?></small>
                    <input class="form-control" id="myInput" type="text" placeholder="Search Expense...">
                    <thead class="thead-dark">
                      <tr>         
                        <th scope="col">#</th>
                        <th scope="col">Expense</th>
                        <th scope="col">Cost(GH¢)</th>
                        <th scope="col">Description</th>
                        <th scope="col" >Date Recorded</th>
                        <th scope="col" >Edit</th>  
                      </tr>
                    </thead>
                    <tbody id="myTable" class="thead-dark">
                         
<?php
    if (isset($_SESSION['user_Id'])) {
      $count = 0;
      $stmt = $expense -> getExpense($_SESSION['user_Id']);
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
                        
                        <button onclick="askDelete('.$expense_id.')" type="button" class="bg-warning" name="expense_id" value="'.$expense_id.'"<><small>Delete..</small></button>
                        </td>
                        </tr>
                        ';
        
        }
  }else{
   echo 'hmmmm';
}

 if (isset($_GET['deleteExpense'])) {
   
     $stmt = $expense->deleteExpense($_GET['deleteExpense']);
     if ($stmt) {         
        
        header("Location: home.php");
        
     }
     echo '<script>Materialize.toast("Expense Deleted", 3000, "rounded");</script>';
 }                   
?>
                                      
                   </tbody>
           
                </table>
<!-- Modal -->
    
            </div>
        </div>
    </div>

 <?php
include "footer.php";
?>