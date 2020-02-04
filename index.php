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

if (isset($_SESSION['user_Id']) != "") {
    header("Location: home.php");
}

?>


<div class="row landing" id="landing">
    <div class="offset-3 col-md-10">
            <div id="login"class="float-right">
                <div class="mr-5 ml- pt-5 pb-5 pl-5 card">
                     <h2 class="bg-transparent border-success mb-2">Login</h2>
                    <div class="text-success">
                        <form method="post">
<?php
    if (isset($_POST['login'])){
    $email = $_POST['email'];
    $pssword = $_POST['pssword'];
   
    $row = $user->getUser($email);
    
    if ($row['pssword'] == $pssword) {
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
            <div id="login"class="float-right">
                <div class="mr-5 ml- pt-5 pb-5 pl-5 card">
                    <h2 class="bg-transparent border-success mb-2">Sign Up</h2>
                    <div class="bg-transparent text-success">
                                Sign up here to track your expenses
<?php
  
 if(isset($_POST['sign_up'])) {
     $first_Name = $_POST['first_name'];
     $last_Name = $_POST['last_name'];
     $email_address = $_POST['email_address'];
     $password = $_POST['password'];
     
    $stmt = $user -> createUser($first_Name,$last_Name,$email_address,$password);
 }
?>
                            </div>
                    <div class="text-success">
                        <form method="post">
                            <input required name="first_name" class="mb-2 mr-5 pb-2 pt-2 pl-4 pr-4 border-bottom" type="text" placeholder="First Name"><br>
                            <input required name="last_name" class="mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="text" placeholder="Last Name"><br>
                            <input required name="email_address" class="mb-2 mr-5 pb-2 pt-2 pl-4 pr-4 border-bottom" type="email" placeholder="Email Address"><br>
                            <input required name="password" class="mb-2 mr-5 p-2 pb-2 pt-2 pl-4 pr-4 border-bottom" type="password" placeholder="Password"><br>
                            
                            <input name="sign_up" class="btn btn-primary" type="submit" value="Submit">
                        </form> 
                       
                        
                    </div>
            </div>
        </div>
    </div>
</div>
  
 <?php
include "footer.php";
?>