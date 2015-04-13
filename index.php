<?php
// File: index.php
// Name: Cory Stoner
// Email: corys1@umbc.edu
// Class: CMSC 331
// Instructor: Lupoli
// Description: Contains input boxes for students to log-in with
//		necessary information

//opens session to store variables
session_start();

//Common instance to execute mysql
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

//blank string to append any error messages to
$errorMsg = "";

//variables to hold the student's information if it is accepted
$fName = $lName = $idNum = "";

//checks if the page has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	//checks if first name was empty
	if(empty($_POST["fName"])){
		$errorMsg .= "<br>First name is required.";
	}
	else{
		$fName = $_POST["fName"];

		//checks if first name is too long or has non-alphabetic characters
		if(strlen($fName) > 25 || ctype_alpha($fName) == false){
			$errorMsg .= "<br>First name can only be letters,
				       and must be less than 25 characters.";
		}
	}
	//checks if last namem was empty
	if(empty($_POST["lName"])){
		$errorMsg .= "<br>Last name is required.";
	}
	else{
		$lName = $_POST["lName"];

		//checks if last name is too long or has non-alphabetic characters
		if(strlen($lName) > 25 || ctype_alpha($lName) == false){
			$errorMsg .= "<br>Last name can only be letters,
				       and must be less than 25 characters.";
		}

	}
	//checks if ID was empty
	if(empty($_POST["idNum"])){
		$errorMsg .= "<br>ID is required.";
	}
	else{
		$idNum = $_POST["idNum"];

		//checks if ID was not equal to 7 characters
		if(strlen($idNum) != 7){
			$errorMsg .= "<br>ID number must be 7 characters in length.";
		}
		//checks if ID has non-alphanumeric characters
		if(ctype_alnum($idNum) == false){
			$errorMsg.= "<br>ID number can only contain letters and numbers.";
		}
	}
	
	//checks if any errors were recorded
	if($errorMsg == ""){
		$major = $_POST["major"];
		
		//inserts the student information into database, ignoring duplicates
		$sql = "insert ignore into StudentInfo (`ID`, `FName`, `LName`, `Major`) 
			values ('$idNum', '$fName', '$lName', '$major')";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		//stores ID as session variable for future use
		$_SESSION['idNum'] = $idNum;

		//redirects to options page
		header('Location: appOption.php');
		exit();
	}
}
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
	height: 1000px;
	padding:30px;
	text-align:center;
	font-size: 40px;
}
</style>

</head>
<body>

<!-- page banner -->
<div id="header">
<h1>UMBC Student Advising</h1>
</div>

<div id = "section">
Log-In<br><br>

<form action='index.php' method='post' name='form1'>
<!-- text fields for log-in -->
First Name <input type='text' style="font-size:28pt" name='fName'><br><br>
Last Name <input type='text' style="font-size:28pt" name='lName'><br><br>
Id Number <input type='text' style="font-size:28pt" name='idNum'><br><br>

<!-- drop-down menu for major -->
Major
<select name='major' style="font-size:28pt">
<option value='cmsc'>CMSC</option>
<option value='cmpe'>CMPE</option>
<option value='enme'>ENME</option>
<option value='ench'>ENCH</option>
</select><br><br>
<input type="submit" style="font-size:28pt" name="submitted" value="Log-In">
</form>

<?php
//prints any errors the page encounters
echo $errorMsg;
?>

</div>
</body>
</html>

