<?php
// File: deleteApp.php
// Name: Cory Stoner
// Email: corys1@umbc.edu
// Class: CMSC 331
// Instructor: Lupoli
// Description: removes the student's appointment from the table

//start sessio to access variables
session_start();
?>

<html>
<head>
<!-- Background and border format for page -->
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

<form action="appOption.php">

<?php
//Common object to execute mysql
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

//retrieves student ID from session
$id = $_SESSION['idNum'];

//variable to hold the type of appointment the student has
$appointment = $_POST['appointment'];

//deletes the appointment from the table specified by the type
$sql = "delete from `$appointment` where `StudentID`='$id'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
//updates student's Appointment field to show that the student no longer has an appointment
$sql = "update `StudentInfo` set `Appointment`=NULL where `ID`='$id'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

echo "Your appointment has been successfully deleted.<br><br>";
echo "You may now return to the selection page and sign up for a new appointment.<br><br>";
?>
</form>

<form action="appOption.php">
<input type="submit" style="font-size: 28pt" value="Return">
</form>

</div>
</body>
</html>