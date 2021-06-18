<!-- Author: Ethan Winkler -->

<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 
 session_start();
?>
<h1>Register</h1>

<form class="reg" name="register" method="post" action="controller.php">

<input type="text" id="username" name="username" placeholder="Username" required><br><br>
<input type="password" id="password" name="password" placeholder="Password" required><br><br>
<input type="submit" value="Submit"><br><br>

<div id="error" style="font-size: 14pt;">
<?php 
if (isset($_SESSION["error"])) {
    echo "Account name taken";
    unset($_SESSION["error"]);
}
?>
</div>

</form>

</body>