<?php
// File: confirmGroup.php
// Name: Cory Stoner
// Email: corys1@umbc.edu
// Class: CMSC 331
// Instructor: Lupoli
// Description: inserts student's appointment information into Group database

//start session to access variables
session_start();
?>
<html>
<head>
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
	text-align:center;
	font-size: 40px;
	height: 700px;
}
</style>
</head>
<body>

<div id = "header">
<h1>UMBC Student Advising</h1>
</div>

<div id = "section">

<?php
//Common object to execute mysql queries
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

//retrieves user information from session
$id = $_SESSION["idNum"];
$date = $_SESSION["date"];
$time = $_POST["time"];

//uses student information to insert appointment into Group table
$sql = "insert into `Group`(`StudentID`, `Date`, `Time`) values ('$id','$date', '$time')";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

//updates the Appointment field in StudentInfo database to indicate the student
//has a group appointment
$sql = "update `StudentInfo` set `Appointment`='Group' where `ID` = '$id'";
$rs =  $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

?>

You have successfully created an appointment.<br>
You can return and view/delete your appointment or log-out<br><br>
<form action="appOption.php">
<input type="submit" style="font-size: 28pt" value="Return to appointment options."/>
</form>
<form action="index.php">
<input type="submit" style="font-size: 28pt" value="Log-out">
</form>

</div>
</body>
</html>