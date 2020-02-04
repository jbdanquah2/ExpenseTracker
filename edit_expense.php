<?php
session_start();
include "header.php";
include_once "config/connection.php";
include_once "objects/expense.php";


$database = new Database();
$db = $database->getConnection();

$expense = new Expense($db);

if (isset($_GET['save'])) {
    $expense_name = $_GET['expense_name'];
    $cost = $_GET['cost'];
    $description = $_GET['description'];
    
    $p = $expense -> postExpense($expense_name,$cost,$description,$_SESSION['user_Id']);
    
    if ($p) {
         header("Location:home.php");
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
                                  
  if (isset($_SESSION['user_Id'])) {
      $count = 0;
      $stmt = $expense -> countExpense($_SESSION['user_Id']);
      $num_expense = $stmt['num_expense'] > 1 ? $stmt['num_expense']." items" : $stmt['num_expense']." item";
      $total_expense = $stmt['total_expense'] > 0 ? "GH¢ ". $stmt['total_expense'] : "GH¢ ". 0;;
  }
?>
                <br>
                <table class="table table-hover" class="p-3">
                    <h3>Review</h3> | <small class="text-warning">Count: <?php echo $num_expense?></small> | <small class="text-warning">Total: <?php echo $total_expense?></small>
                    <input class="form-control" id="myInput" type="text" placeholder="Search Expense...">
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
      $expense_id = $_GET['expense_id'];
      $count = 0;
      $stmt = $expense -> getEditExpense($expense_id);
      
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
    $expense_name = $_GET['expense_name'];
    $cost = $_GET['cost'];
    $description = $_GET['description'];
    $expense_id = $_GET['exp_id'];

    $stmt = $expense -> putExpense($expense_id,$expense_name,$cost,$description);
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