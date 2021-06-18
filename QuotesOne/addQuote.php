<!DOCTYPE html>
<html>
<head>
<title>addQuote</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<h1>Add a Quote</h1>

<form class="addQ" name="addQuote" method="post" action="controller.php">

<textarea id="quote" name="quote" rows="3" placeholder="Enter new quote" required></textarea><br>
<input type="text" id="author" name="author" style="margin-bottom: 14px; margin-top: 7px;" placeholder="Author" required><br>
<input type="submit" value="Add Quote">

</form>

</body>
</html>