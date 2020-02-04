<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <title>Expense Tracker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="app-logo mt-2"><small>Expense Tracker</small></h1>
<?php
           if($_SESSION['login'] == 'login') {
            echo'  <a href="logout.php?logout"><input class="btn btn-primary" value="Logout" type="button"></a>';
      
           }else {
             echo'  <input id="sign" onclick="myFunction()" class="btn btn-primary" value="Sign Up" type="button">';  
           }
            
?>
            
          </div>  
            
    </div>