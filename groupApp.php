<?php
// File: groupApp.php
// Name: Cory Stoner
// Email: corys1@umbc.edu
// Class: CMSC 331
// Instructor: Lupoli
// Description: Shows options for days available for group advising
?>

<html>
<head>
<!-- Format background and border for page -->
<style>
#header {
	background-color:yellow;
	border: 10px solid black;
	padding:10px;
	color:black;
	text-align:center;
	font-size: 40px;
}
#section {
	border: 10px solid black;
	padding:30px;
	height: 700px;
	text-align:center;
	font-size: 40px;
}
</style>
</head>
<body>
<div id="header">
<h1>UMBC Student Advising</h1>
</div>

<div id = "section">
<u>Group Advising</u><br><br>

<form method="post" action="timesGroup.php">

<!-- Group advising is only offered 3 days per week -->
Day:
<select style="font-size: 28pt" name='groupDay'>
<option value='2015-03-23'>Monday, March 23</option>
<option value='2015-03-25'>Wednesday, March 25</option>
<option value='2015-03-27'>Friday, March 27</option>
<option value='2015-03-30'>Monday, March 30</option>
<option value='2015-04-01'>Wednesday, April 1</option>
<option value='2015-04-03'>Friday, April 3</option>

</select><br><br>

<input type="submit" style="font-size: 28pt" value="See Times"><br>
</form>

<form action="appOption.php">
<input type="submit" style="font-size: 28pt" value="Previous">
</form>

</div>
</body>
</html>