<?php
session_start();

if(!isset($_SESSION['user_Id']))
{
header("Location: index.php");
}
else if(isset($_SESSION['user_Id'])!="")
{
header("Location: home.php");
}

if(isset($_GET['logout']))
{
session_destroy();
unset($_SESSION['user_Id']);
unset($_SESSION['first_name']);
unset($_SESSION['last_name']);
unset($_SESSION['email']);
unset($_SESSION['pssword']);
unset($_SESSION['login']);
header("Location: index.php");
}
?>
