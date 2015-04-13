<?php 
// File: appOption.php
// Name: Cory Stoner
// Email: corys1@umbc.edu
// Class: CMSC 331
// Instructor: Lupoli
// Description: Displays the options for appointment types the student can pick

//start session to save variables
session_start(); 
?>
<html>
<head>
<!-- Format for page color and border -->
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
	height: 1000px;
	padding:30px;
	text-align:center;
	font-size: 40px;
}
#boxed {
	border: 1px solid black;
	width: 600px;
}
</style>
</head>
<body>

<!-- Page banner -->
<div id = "header">
<h1>UMBC Student Advising</h1>
</div>

<div id = "section">

<?php

//create Common class to execute mysql queries
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

//retrieves student's ID from the session
$id = $_SESSION['idNum'];

//checks if the student already has an appointmetn
$sql = "select * from `StudentInfo` where `ID` = '$id'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);

$appointment = $row[4];
?>

<!-- Displays individual and group advising options -->
<?php if($appointment == NULL) : ?>

<center>
<div id="boxed">
Select this option for single appointments.<br><br>
<form method="post" action="singleApp.php">
<input type="submit" style="font-size: 28pt" value="Single">
</form>
<div>
</center><br>

<center>
<div id="boxed">
Select this option for group adivising with up to 10 students.<br><br>
<form method="post" action="groupApp.php">
<input type="submit" style="font-size: 28pt" value="Group">
</form>
</div>
</center><br>

<form action="index.php">
<input type="submit" style="font-size: 28pt" value="Log-out">
</form>

<!-- Displays delete option if an appointment is already scheduled -->
<?php else : ?>
<u>Appointment Details</u><br><br>
<?php

//retrieves appointment type from database
$sql = "select `Appointment` from `StudentInfo` where `ID`='$id'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);
$appointment = $row[0];

//retrieves appointment date from database
$sql = "select `Date` from `$appointment` where `StudentID`='$id'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);

//formats mysql date into a more readable version
$date = $row[0];
$formatDate = date("M d, Y", strtotime($date));

//retrieves appointment time from database
$sql = "select `Time` from `$appointment` where `StudentID`='$id'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);
$time = $row[0];
//convert military time to standard for display
$formatTime = date('h:i A', strtotime($time));

?>

<center>
<div id="boxed">
Advisor: <?php echo $appointment."<br>"; ?>
   Date: <?php echo $formatDate."<br>"; ?>
   Time: <?php echo $formatTime."<br>"; ?>
</div>
</center><br>

You can only have one appointment. To get sign-up for a different option, 
please delete your existing appointment<br><br>

<!-- Log-out of scheduler -->
<form action="index.php">
<input type="submit" style="font-size: 28pt" value="Log-out">
</form>

<!-- students must delete existing appointments to create a new one -->
<form method="post" action="deleteApp.php">
<input type="hidden" value="<?php echo $appointment; ?>" name="appointment">
<input type = "submit" style="font-size: 28pt" value="Delete Appointment" name="update">
</form>

<?php endif; ?>

</div>
</body>
</html>