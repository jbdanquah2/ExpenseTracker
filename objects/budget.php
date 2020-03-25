<?php

class Budget {

private $conn;
public $expense_name;
public $cost;
public $description;
public $user_Id;
public $budget_id;
public $expense_id;



    public function __construct($db){
        $this->conn = $db;
//        echo " i'm also connected";
    }
    

}