<?php
ob_start();
session_start();
$_SESSION['login'] = '';
include_once "header.php";
include_once "config/connection.php";
include_once "objects/user.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$newUser = new User($db);
if (isset($_SESSION['user_Id']) != "") {
// checks if user is logged. if yes ensure home.php is displayed
// checks it remains on the index.php
    header("Location: home.php");
}

?>


<div class="row landing" id="landing">
    <div class="offset-1 col-md-12">
        <div id="login" class="float-right">
            <div class="mr-5 ml- pt-5 pb-5 pl-5 card blue-grey darken-2">
                <h3 class="bg-transparent border-success mb-2">Login</h3>
                <div class="text-success">
                    <form method="post">
                        <?php
                            if (isset($_POST['login'])){
                                
                                //checks login is submitted and checks of emial already exist
                                $email = $_POST['email'];
                                $pssword = $_POST['pssword'];
                                $user->email = $email;
                                $row = $user->getUser();

                            if ($row['pssword'] == $pssword) {
                                
                                //checks if password is correct
                                try {
                                        $_SESSION['user_Id'] = $row['user_Id'];
                                        $_SESSION['first_name'] = $row['first_name'];
                                        $_SESSION['last_name'] = $row['last_name'];
                                        $_SESSION['pssword'] = $row['pssword'];
                                        $_SESSION['login'] = 'login';
                                        header("Location:home.php");
                                
                                     }catch (PDOException $ex) {
                                       echo "";
                                        }
                                    } else {
                                       echo("<small class='text-danger'>Wrong email or password, try again!</small><br>");
                                    }
                              }                          
?>
                        <input required name="email" class="mb-2 mr-5 pb-2 pt-2 pl-4 pr-4 border-bottom" type="email" placeholder="yjbdanquah@gmail.com"><br>
                        <input required name="pssword" class="mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="password" placeholder="password">
                        <div class="bg-transparent border-success">
                            Please login to tracker your expenses
                        </div>
                        <input name="login" class="btn btn-primary" type="submit" value="Login">
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<div class="row landing" id="sign_up">
    <div class="offset-3 col-md-10">
        <div id="login" class="float-right">
            <div class="mr-5 ml- pt-5 pb-5 pl-5 card blue-grey darken-2">
                <h3 class="bg-transparent border-success mb-2">Sign Up</h3>
                <div class="bg-transparent text-success">
                    Sign up here to track your expenses
                    <?php
                       if(isset($_POST['sign_up'])) {
                           
                           // create account for new user
                           $newUser->first_Name = $_POST['first_name'];
                           $newUser->last_Name = $_POST['last_name'];
                           $newUser->email = $_POST['email_address'];
                           $newUser->pssword = $_POST['password'];
                           $newUser->budget_type = $_POST['budget_type'];
                           $newUser->month_year  = $_POST['month_year'];
                           $newUser->budget_amount = $_POST['budget_amount']; //> 0 ? $_POST['budget_amount'] : 0 ;
                           $newUser->budget_period_start = $_POST['budget_period_start'];
                           $newUser->budget_period_end = $_POST['budget_period_end'];
                         
                           $st = $newUser -> createUser();
//                           if ($st) {
//                             echo '<script>alert("Account has been created")</script>';
//                           }
                       }
                    ?>
                </div>
                <div class="text-success">
                    <form method="post">
                       
                        <input required name="first_name" class="mb-2 mr-5 pb-2 pt-2 pl-4 pr-4 border-bottom" type="text" placeholder="First Name"><br>
                
                        <input required name="last_name" class="mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="text" placeholder="Last Name"><br>
                        
                        <input required name="email_address" class="mb-2 mr-5 pb-2 pt-2 pl-4 pr-4 border-bottom" type="email" placeholder="Email Address"><br>
                        
                        <input required name="password" class="mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="password" placeholder="Password"><br>
                        
                        <input  name="budget_amount" class="mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="number" placeholder="Initial Budget"><br>
                        
                        <div class="form-group">
                        <select required name="budget_type" class="form-control mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" id="">
                          <option selected disabled value="0">Select Budget Type</option>
                          <option value="Monthly">Monthly</option>
                          <option value="Yearly">Yearly</option>
                        </select>
                        </div><br>
                        
                        <input  name="month_year" class="mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="text" placeholder="Which Month?"><br>
                        
                        <input  name="budget_period_start" class="mb-2 mr-0 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="date" placeholder="Start Date?" min="2020-01-01" max="2050-12-31">Start Date<br>
                         
                        <input  name="budget_period_end" class="mb-2 mr-0 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="date" placeholder="End Date?" min="2020-01-01" max="2050-12-31">End Date<br>

                        <input name="sign_up" class="btn btn-primary" type="submit" value="submit">
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
