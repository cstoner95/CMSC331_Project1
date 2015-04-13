<?php
// File: timesGroup.php
// Name: Cory Stoner
// Email: corys1@umbc.edu
// Class: CMSC 331
// Instructor: Lupoli
// Description: Displays all available times for group advising on the given day

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
	height: 700px;
}
</style>
</head>
<body>

<!-- page banner -->
<div id = "header">
<h1>UMBC Student Advising</h1>
</div>

<div id = "section">
<u>Select from the available group appointment times for the day.</u><br><br>

<?php
//Common object to execute mysql
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

//array of possible group advising times
$timeSlots = array('10:00:00', '10:30:00', '11:00:00', '11:30:00', '12:00:00', '12:30:00');

//variable to store date the user wants to schedule on
$date = $_POST['groupDay'];

//stores date in session for future use
$_SESSION['date'] = $date;

//retrieves ID from session
$studentID = $_SESSION['idNum'];

//retrieves all times in group database on the given date
$sql = "select `Time` from `Group` where `Date`='$date'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

//creates empty array to store all taken appointment times
$takenSlots = array();

//appends all times found from the database to $takenSlots
while($row = mysql_fetch_row($rs)){
	foreach ($row as $element)
	{ 			
		array_push($takenSlots, $element);
	}
}

//empty array to hold all available slots
$availSlots = array();

//loops through all possible times for group advising
foreach($timeSlots as $value){

	//counter for each time
	$counter = 0;

	//loops through the taken spots found from the database
	foreach($takenSlots as $element){
		if($element == $value){
			//if the times match, increments counter to signify that a
			//person is signed up for that time
			$counter++;
		}	
	}
	//A max of 10 students can sign up for each group time
	if($counter < 10){
		//if less than 10 people are signed up for the time, appends the time
		//to the array of available times
		array_push($availSlots, $value);
	}
}

//if available times were found
if(count($availSlots) != NULL){

	//creates form and loops through each time in the array
	echo "<form method='post' action='confirmGroup.php'>";
	echo "<select style='font-size: 28pt' name='time'>";

	//echos each time as an option in a drop down menu
	foreach($availSlots as $element){
		//converts from military time to standard for display
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

<form action="groupApp.php">
<input type="submit" style="font-size: 28pt" value="Previous">
</form>

</div>
</body>
</html>