<?php
include("currentsurvey.php");

if ($_GET['action'] == 'current' || $_GET['status'] == '') {
	$currentPoll = $currentSurvey;
	header("Location: $currentPoll");
}
include("../start.php");
$status = $_GET['status'];
if ($status == "alreadytaken") {
	$error = "You have already taken this survey, and only one response is allowed per individual.";
}
if ($status == "success") {
	$error = "Thank you for taking our survey.  Results will be published in an upcoming issue of the <i>Orient</i>.  In the meantime, feel free to check out the latest Bowdoin news, features, A&E, sports, and opinions on our <a href='http://orient.bowdoin.edu/orient'>main site</a>.";
}
if ($status == "closed") {
	$error = "Thank you for your interest, but this survey has closed.  Feel free to check out the latest Bowdoin news, features, A&E, sports, and opinions on our <a href='http://orient.bowdoin.edu/orient'>main site</a>.";
}
if ($status == "error") {
	$error = "There was an error processing your survey answers.  Please <a href='index.php?action=current'>try again</a>.";
}
if ($status == "unauthorized") {
	$error = "You are not authorized to view this page.";
}
startcode("The Bowdoin Orient - Polls", false, false, $articleDate, $issueNumber, $volumeNumber);
?>


<h2>Orient Polls</h2>

<p><?php echo $error; ?></p>

<?php
include("../stop.php");
?>