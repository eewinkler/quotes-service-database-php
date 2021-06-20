<?php

session_start ();//session start so that account information can be stored into a session

//Name: Ethan Winkler
//This file is used to test the functionality of the Database Adaptor file. Not essential to the program's functionality.

include 'DatabaseAdaptor.php';//include database adaptor

$theDBA = new DatabaseAdaptor(); //make new database adaptor
$theDBA->startFromScratch(); //uses initialization function
$arr = $theDBA->getAllQuotations();//loads quotes
assert(empty($arr));  //test array is empty to starts
$arr = $theDBA->getAllUsers();//loads users
assert(empty($arr)); //test array is empty to start

$theDBA->addUser("Sammi", "1234");//add dummy user
$theDBA->addUser("Chris", "abcd");//add dummy user
$theDBA->addUser("Gabriel", "abc123");//add dummy user
$arr = $theDBA->getAllUsers();//load user array

//tests loaded users are present and with correct IDs
assert($arr[0]['username'] === 'Sammi');
assert($arr[0]['id'] == 1);  
assert($arr[1]['username'] === 'Chris');
assert($arr[1]['id'] == 2);
assert($arr[2]['username'] === 'Gabriel');
assert($arr[2]['id'] == 3);

//tests that users are in the database with their correct passwords
assert($theDBA->verifyCredentials('Sammi', '1234'));
assert($theDBA->verifyCredentials('Chris', 'abcd'));
assert($theDBA->verifyCredentials('Gabriel', 'abc123'));
assert(! $theDBA->verifyCredentials('Huh', '1234'));
assert(! $theDBA->verifyCredentials('Sammi', 'xyz'));

//add dummy quotes
$theDBA->addQuote('one', 'A');
$theDBA->addQuote('two', 'B');
$theDBA->addQuote('three', 'C');
$arr = $theDBA->getAllQuotations();//load quote array

//tests quote variables
assert(count($arr) == 3);
assert($arr[0]['quote'] === 'one');
assert($arr[0]['author'] === 'A');
assert($arr[0]['rating'] == 0);   
assert($arr[0]['flagged'] == 0);
assert($arr[1]['quote'] === 'two');
assert($arr[1]['author'] === 'B');
assert($arr[1]['rating'] == 0);
assert($arr[1]['flagged'] == 0);

//tests consistancy of database
assert($arr[2]['id'] == 3);
assert($arr[2]['author'] === 'C');
assert($arr[2]['quote'] === 'three');

?>
