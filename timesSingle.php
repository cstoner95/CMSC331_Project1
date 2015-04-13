<?php
// File: timesSingle.php
// Name: Cory Stoner
// Email: corys1@umbc.edu
// Class: CMSC 331
// Instructor: Lupoli
// Description: Displays all available times for individual advising
//		with the chosen advisor

session_start();
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
	text-align:center;
	font-size: 40px;
	height: 1000px;
}
</style>
</head>
<body>

<!-- page banner -->
<div id = "header">
<h1>UMBC Student Advising</h1>
</div>

<div id = "section">
<u>Select from the available appointment times for the day.</u><br><br>

<?php
//Common object to execute mysql
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

//array of all possible times for a Mon, Wed, or Fri
$groupDay = array('09:00:00', '09:30:00', '13:00:00', '13:30:00', '14:00:00', 
		    '14:30:00', '15:00:00', '15:30:00');

//array of all possible times for a Tue or Thu
$nonGroupDay = array('09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00', 
		    '12:00:00', '12:30:00', '13:00:00', '13:30:00', '14:00:00', '14:30:00', 
	            '15:00:00', '15:30:00');

//empty array to hold the times that are taken
$takenSlots = array();

//date of the desired appointment
$date = $_POST['singleDay'];
$_SESSION['date'] = $date;

//name of the desired advisor
$adv = $_POST['adv'];
$_SESSION['advisor'] = $adv;

//checks database for all taken appointment times
$sql = "select `Time` from `$adv` where `Date`='$date'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

//creates array of the taken times
while($row = mysql_fetch_row($rs))
{
	foreach ($row as $element)
	{ 
		array_push($takenSlots, $element);	
	}
}

//computes the name of the day
$day = date('D', strtotime($date));

//creates empty array to hold all available sign-up times
$availSlots = array();

//compares taken slots with all possible slots, depending on the day
if($day == 'Tue' || $day == 'Thu'){
	//finds difference between possible times and taken times
	$availSlots = array_diff($nonGroupDay, $takenSlots);
} 
else{
	//finds difference between possible times and taken times
	$availSlots = array_diff($groupDay, $takenSlots);
}

//if there are available times
if(count($availSlots) != NULL){
	//echos form and drop down menu
	echo "<form method='post' action='confirmSingle.php'>";
	echo "<select style='font-size: 28pt' name='time'>";
	//all available times are echoed as a drop-down option
	foreach($availSlots as $element){
		//changes from military to standard time for display
		$standardTime = date('h:i A', strtotime($element));
		echo "<option value=".$element.">".$standardTime."</option>";
	}	
	echo "</select><br><br>";
	echo "<input type='submit' style='font-size: 28pt' value='Sign-Up'>";
	echo "</form>";
}
//if no available times are found
else{
	//prompts user to return to previous page and choose a different day
	echo "All times for this day have been booked.<br>";
	echo "Please return to the previous page and select a new day.<br><br>";
}
?>

<form action="singleApp.php">
<input type="submit" style="font-size: 28pt" value="Previous">
</form>

</div>
</body>
</html>