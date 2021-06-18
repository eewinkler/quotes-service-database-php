<!-- 
This is the home page for Final Project, Quotation Service. 
It is a PHP file because later on you will add PHP code to this file.

File name quotes.php 
    
Authors: Rick Mercer and Ethan Winkler
-->

<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="showQuotes()">
<?php 
session_start ();
?>

<h1 style="text-align: center; font-family: cursive;">Quotation Service</h1>

<div id="loggedout">
<?php 
if (!isset($_SESSION["user"])) {
    echo '<a href="./register.php" ><button>Register</button></a><br> <a href="./login.php" ><button>Login</button></a>';
}
if (isset($_SESSION["user"])) {
    echo '<a href="./addQuote.php" ><button>Add Quote</button></a><form class="logout" name="logout" method="post" action="controller.php"> <input type="submit" value="Logout" name="logout"><br> </form>';
    echo "Hello " . $_SESSION["user"] . "!";
}
?>
</div>

<hr>

<div id="quotes"></div>

<script>
var element = document.getElementById("quotes");
function showQuotes() {
	//alert('view.php under construction');
	//console.log("check");
	var ajax = new XMLHttpRequest();
		ajax.open("GET", "controller.php?todo=getQuotes", true);
		ajax.send();
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				assignments = ajax.responseText;
				document.getElementById('quotes').innerHTML = assignments;
			}
		} 

} // End function showQuotes

</script>

</body>
</html>