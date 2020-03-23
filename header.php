<?php
//error_reporting(0);
ob_start();
  global $month;
  global $name;
  global $budget;
  global $balance;
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <title>Expense|Tracker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="shortcut icon" href="img/favicon.ico" /> 
    <!-- Bootstrap CSS -->    
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/materialize.min.css">

    <link rel="stylesheet" href="css/css/alertify.min.css">
    <link rel="stylesheet" href="css/css/themes/default.min.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <a class="navbar-brand" href="index.php"><span class="text-warning"><img width="150" src="img/expense_tracker_logo_small1.png" alt=""></span></a>
        <button name="login" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

    
 <?php 
    if(isset($_SESSION['user_Id'])!="") {
   echo '<div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto ">
              <li class="nav-item dropdown active mb-0">
                <a class="nav-link dropdown-toggle mb-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">'.$name.'</a>
                <div class="dropdown-menu mt-0">
                  <a class="dropdown-item" href="budget.php">Budget</a>
                  <a class="dropdown-item" href="profile.php">Profile</a>
                  <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php?logout">Logout</a>
                </div>
              </li>
       <!--       <li class="nav-item active ">
                <a class="nav-link text-white" href="#">'.$name.'<span class="sr-only">(current)</span></a>
              </li> -->
              <li class="nav-item ">
                <a class="nav-link text-white" href="#">Month: '.$month.'</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="budget.php">Budget: GH¢'.$budget.'</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="#">Bal: GH¢'.$balance.'</a>
              </li>
            </ul>
    <span class="navbar-text">
 
             <a href="logout.php?logout"><input class="btn btn-primary" value="Logout" type="button"></a>';
      
       }else {
    echo'   
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item ">
                    <a class="nav-link" href="#"><span onclick="myFunction()" class="text-white">Sign up</span> <span class="text-info">| </span> <span class="lab">Track your expenses and budget</span><span class="sr-only">(current)</span></a>
                  </li>
                </ul>
                <span class="navbar-text">  
                  <input  id="sign" onclick="myFunction()" class="btn btn-primary" value="Sign Up" type="button">
                </span>';  
         }
            
?>
    </span>
  </div>
</nav>
    
      
      
      
  <div class="container">
    <div class="row">
        <div class="col-md-12">
           

            
          </div>  
            
    </div>