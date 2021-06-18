<?php
// This class has a constructor to connect to a database. The given
// code assumes you have created a database named 'quotes' inside MariaDB.
//
// Call function startByScratch() to drop quotes if it exists and then create
// a new database named quotes and add the two tables (design done for you).
// The function startByScratch() is only used for testing code at the bottom.
// 
// Authors: Rick Mercer and Ethan Winkler
//
//session_start ();

class DatabaseAdaptor {
  private $DB; // The instance variable used in every method below
  // Connect to an existing data based named 'first'
  public function __construct() {
    $dataBase ='mysql:dbname=quotes;charset=utf8;host=127.0.0.1';
    $user ='root';
    $password =''; // Empty string with XAMPP install
    try {
        $this->DB = new PDO ( $dataBase, $user, $password );
        $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) {
        echo ('Error establishing Connection');
        exit ();
    }
  }
    
// This function exists only for testing purposes. Do not call it any other time.
public function startFromScratch() {
  $stmt = $this->DB->prepare("DROP DATABASE IF EXISTS quotes;");
  $stmt->execute();
       
  // This will fail unless you created database quotes inside MariaDB.
  $stmt = $this->DB->prepare("create database quotes;");
  $stmt->execute();

  $stmt = $this->DB->prepare("use quotes;");
  $stmt->execute();
        
  $update = " CREATE TABLE quotations ( " .
            " id int(20) NOT NULL AUTO_INCREMENT, added datetime, quote varchar(2000), " .
            " author varchar(100), rating int(11), flagged tinyint(1), PRIMARY KEY (id));";       
  $stmt = $this->DB->prepare($update);
  $stmt->execute();
                
  $update = "CREATE TABLE users ( ". 
            "id int(6) unsigned AUTO_INCREMENT, username varchar(64),
            password varchar(255), PRIMARY KEY (id) );";    
  $stmt = $this->DB->prepare($update);
  $stmt->execute(); 
}
    

// ^^^^^^^ Keep all code above for testing  ^^^^^^^^^


/////////////////////////////////////////////////////////////
// Complete these five straightfoward functions and run as a CLI application


    public function getAllQuotations() {
        $stmt = $this->DB->prepare( "SELECT * FROM quotations ORDER BY rating DESC" );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllUsers(){
        $stmt = $this->DB->prepare( "SELECT * FROM users" );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addQuote($quote, $author) {
        $quo = htmlspecialchars($quote);
        $auth = htmlspecialchars($author); 
        //$stmt = //$this->DB->prepare( "INSERT INTO quotations (added, quote, author, rating, flagged) VALUES (now(), '" . $quote . "', '" . $author . "', 0, 0)" );
        $stmt = $this->DB->prepare( "INSERT INTO quotations (added, quote, author, rating, flagged) VALUES (now(), :bind_quote, :bind_author, 0, 0)" );
        $stmt->bindParam (':bind_quote', $quo );
        $stmt->bindParam (':bind_author', $auth );
        $stmt->execute();
        #return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addUser($accountname, $psw){
        $psh = htmlspecialchars($psw); 
        $acc = htmlspecialchars($accountname); 
        $pswh = password_hash($psh, PASSWORD_DEFAULT);
        $stmt = $this->DB->prepare( "INSERT INTO users (username, password) VALUES (:bind_acc, :bind_psw)" );
        $stmt->bindParam (':bind_acc', $acc );
        $stmt->bindParam (':bind_psw', $pswh );
        $stmt->execute();
        #return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   
    
    public function addOne($id){
        $idd = htmlspecialchars($id); 
        //$stmt = $this->DB->prepare( "UPDATE quotations SET rating=rating+1 WHERE id=" . $id . "" );
        $stmt = $this->DB->prepare( "UPDATE quotations SET rating=rating+1 WHERE id=:bind_name" );
        $stmt->bindParam (':bind_name', $idd );
        $stmt->execute();
        #return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function subOne($id){
        $idd = htmlspecialchars($id); 
        //$stmt = $this->DB->prepare( "UPDATE quotations SET rating=rating-1 WHERE id=" . $id . "" );
        $stmt = $this->DB->prepare( "UPDATE quotations SET rating=rating-1 WHERE id=:bind_name" );
        $stmt->bindParam (':bind_name', $idd );
        $stmt->execute();
        #return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function deleteOne($id){
        $idd = htmlspecialchars($id); 
        $stmt = $this->DB->prepare( "DELETE FROM quotations WHERE id=:bind_name" );
        $stmt->bindParam (':bind_name', $idd );
        $stmt->execute();
        #return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifyUsername($accountName) {
        $acc = htmlspecialchars($accountName); 
        $stmt = $this->DB->prepare( "SELECT username FROM users WHERE username = :bind_name" );
        $stmt->bindParam (':bind_name', $acc );
        $stmt->execute();
        if (count($stmt->fetchAll(PDO::FETCH_ASSOC)) != 0) {
            return true;
        }
        else {
            return false;
        }
    }
    
    
     public function verifyCredentials($accountName, $psw){
         $acc = htmlspecialchars($accountName); 
         $psh = htmlspecialchars($psw); 
         //$stmt = $this->DB->prepare( "SELECT username, password FROM users WHERE username = :bind_acc AND password = :bind_psw" );
         $stmt = $this->DB->prepare( "SELECT password FROM users WHERE username = :bind_acc" );
         $stmt->bindParam (':bind_acc', $acc );
         $stmt->execute();
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         if (password_verify($psh, $result["password"])) {
             return true;
         }
         else {
             return false;
         }
     }
        


}  // End class DatabaseAdaptor

//$theDBA = new DatabaseAdaptor();
//$theDBA->addQuote('one', 'A');
//$theDBA->addQuote('two', 'B');
//$theDBA->addQuote('three', 'C');

?>
