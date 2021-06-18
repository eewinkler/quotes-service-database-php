<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this code absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Ethan Winkler
//  
session_start (); // Not needed until a future iteration

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();

if (isset ( $_GET ['todo'] ) && $_GET ['todo'] === 'getQuotes') {
    $arr = $theDBA->getAllQuotations();
    unset($_GET ['todo']);
    echo getQuotesAsHTML ( $arr );
}

if (isset ( $_POST ['update'] ) && $_POST ['update'] === 'increase') {
    $arr = $theDBA->addOne($_POST ["ID"]);
    unset($_POST ['update']);
    header("Location: view.php");
}

if (isset ( $_POST ['update'] ) && $_POST ['update'] === 'decrease') {
    $arr = $theDBA->subOne($_POST ["ID"]);
    unset($_POST ['update']);
    header("Location: view.php");
}

if (isset ( $_POST ['update'] ) && $_POST ['update'] === 'delete') {
    $arr = $theDBA->deleteOne($_POST ["ID"]);
    unset($_POST ['update']);
    header("Location: view.php");
}

if (isset ( $_POST ['logout'] )) {
    unset($_SESSION["user"]);
    unset($_POST ['logout']);
    header("Location: view.php");
}

if (isset ( $_POST ['author'] ) && isset ( $_POST ['quote'] )) {
    if(!empty( $_POST ['author'] ) && (!empty( $_POST ['quote'] ))) {
    $arr = $theDBA->addQuote($_POST ['quote'], $_POST ['author']);
    unset($_POST ['author']);
    unset($_POST ['quote']);
    }
    header("Location: view.php");
}

if (isset ( $_POST ['username'] ) && isset ( $_POST ['password'] )) {  //register
    //if(( $_POST ['username'] != null) && (( $_POST ['password'] != null))) {
        $arr = $theDBA->verifyUsername($_POST ['username']);
        if ($arr === false) {
            $arr = $theDBA->addUser($_POST ['username'], $_POST ['password']);
            unset($_POST ['username']);
            unset($_POST ['password']);
            header("Location: view.php");  
        }
        if ($arr === true) {
            //header("Location: register.php");  
            //echo "Account name taken";
            $_SESSION["error"] = "Account name taken";
            header("Location: register.php");  
        }
    //}
    //$_SESSION["error"] = "Blank spaces found";
    //header("Location: register.php");
}

if (isset ( $_GET ['username'] ) && isset ( $_GET ['password'] )) {    //login
    //if(!empty( $_GET ['username'] ) && (!empty( $_GET ['password'] ))) {
        $arr = $theDBA->verifyCredentials($_GET ['username'], $_GET ['password']);
        if ($arr === true) {
            $_SESSION["user"] = ($_GET ['username']);
            unset($_GET ['username']);
            unset($_GET ['password']);
            header("Location: view.php");    
        }
        if ($arr === false) {
            //error stuff
            //echo "Invalid account/password";
            $_SESSION["log"] = "Invalid";
            header("Location: login.php");
        }
    //}
    //header("Location: login.php");
}

function getQuotesAsHTML($arr) {
    // TODO 6: Many things. You should have at least two quotes in 
    // table quotes. layout each quote using a combo of PHP and HTML 
    // strings that includes HTML for buttons along with the actual 
    // quote and the author, ~15 PHP statements. This function will 
    // be the most time consuming in Quotes 1. You will
    // need to add css rules to styles.css.  
    $result = '';
    foreach ($arr as $quote) {
        $result .= '<div class="container" id="' . $quote['id'] . '">';
        $result .= '"' . $quote ['quote'] . '"';
        $result .= '<p class="author">&nbsp;&nbsp;--' . $quote ['author'] . '<br></p>';
        $result .= '<form action="controller.php" method="post">';
        $result .= '<input type="hidden" name="ID" value="' . $quote['id'] . '">&nbsp;&nbsp;&nbsp;';
        $result .= '<button name="update" value="increase">+</button>';
        $result .= '&nbsp;<span id="rating"> ' . $quote['rating'] . '</span>&nbsp;&nbsp;';
        $result .= '<button name="update" value="decrease">-</button>&nbsp;&nbsp;';
        if (isset($_SESSION['user'])) {
            $result .= '<button name="update" value="delete">Delete</button>';
        }
        $result .= '</form></div>';       
    }
    
    return $result;
}
?>