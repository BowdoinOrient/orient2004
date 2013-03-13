<?php
$authenticated = true;
$closed = false;
?>

<?php
include("../start.php");
include("polls.php");

if ($_POST['submit']) {
	$required = array();
	$questions = array();
	$questions[] = "classyear";
	$questions[] = "sex";
	$questions[] = "orientation";
	$questions[] = "typesofbowdoinrelationships";
	$questions[] = "frequentlyengaged";
	$questions[] = "alcohol";
	$questions[] = "relationshipsatbowdoin";
	$questions[] = "lackofexperience";
	$questions[] = "bowdoindatingscene";
	$questions[] = "othersatisfied";
	$questions[] = "relationshipnow";
	$questions[] = "whynotnow";
	$questions[] = "wantrelationship";
	$questions[] = "everbeenaskedondate";
	$questions[] = "everaskedondate";
	$questions[] = "toonervous";
	$questions[] = "toomuchtime";
	$questions[] = "pressure";
	$required[] = "classyear";
	$required[] = "sex";
	$required[] = "orientation";
	enterResults("Dating 08", "dating08.php", $required, $questions, $authenticated);
}

startPoll("dating08.php", $closed, $authenticated);
startcode("The Bowdoin Orient - Polls", false, false, $articleDate, $issueNumber, $volumeNumber);

$status = $_GET['status'];
if ($status == "missing") {
	$error = "Please fill out all required fields.";
}

?>
<link rel="stylesheet" href="wufoo.css" type="text/css" />
<div id="container">
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript">
		questionsAnswered = new Array();
		startNum = 0;

		function addQuestion(n) {
			questionsAnswered[n.getAttribute("name")] = 1;
			if ($("[name=otherissue]")[0].value) {
				startNum = -1;
			}
		}

		function checkOther() {
			if ($("[value=Specify]")[0].checked) {
				if (!$("[name=otherissue]")[0].value) {
					alert("Please specify the issue that is most important to you.");
					return false;
				}
			}
			return true;
		}

		function checkAnswers() {
			num = startNum;
			for (i in questionsAnswered) {
				console.log(i);
				num++;
			}
			if (num < 11) {
				alert("You have only answered " + num + " of the 11 questions. Please complete the rest of them.\n\nIf this number is incorrect, please refresh the page.");
				return false;
			}
			if ($("[value=Specify]")[0].checked) {
				if (!$("[name=otherissue]")[0].value) {
					alert("Please specify the issue that is most important to you.");
					return false;
				}
			}
			return true;
		}
	</script>
	<h1 id="logo"><a>2008 Dating and Relationships Survey</a></h1>

	<form id="form1" class="wufoo topLabel" autocomplete="off"
	enctype="multipart/form-data" method="post">

	<div class="info">
		<div>
		<p>
		Currently signed in as <?php echo $_SESSION['username']; ?>. Not you? <a href="logout.php">Log out</a>.</p>
		<p id="errorp" class="error"><?php echo $error; ?></p>
		</div>
	</div>

	<ul>

		<li id="foli1" class=" ">
			<label class="desc" id="title2" for="classyear">
				Class Year
				<span id="req_2" class="req">*</span>
			</label>
			<div class="column">
				<input id="radioDefault_2" name="classyear" type="hidden" value="" tabindex="1" />
				<input id="classyear_0" name="classyear" type="radio" class="field radio" value="2009" tabindex="1" />
				<label class="choice" for="classyear_0">2009</label>
				<input id="classyear_1" name="classyear" type="radio" class="field radio" value="2010" tabindex="1" />
				<label class="choice" for="classyear_1">2010</label>
				<input id="classyear_2" name="classyear" type="radio" class="field radio" value="2011" tabindex="1" />
				<label class="choice" for="classyear_2">2011</label>
				<input id="classyear_3" name="classyear" type="radio" class="field radio" value="2012" tabindex="1" />
				<label class="choice" for="classyear_3">2012</label>
			</div>
		</li>


		<li id="foli2" class=" ">
			<label class="desc" id="title4" for="sex">
				Sex
				<span id="req_4" class="req">*</span>
			</label>
			<div class="column">
				<input id="radioDefault_4" name="sex" type="hidden" value="" tabindex="1" />
				<input id="sex_0" name="sex" type="radio" class="field radio" value="Male"  tabindex="1" />
				<label class="choice" for="sex_0">Male</label>
				<input id="sex_1" name="sex" type="radio" class="field radio" value="Female"  tabindex="1" />
				<label class="choice" for="sex_1">Female</label>
			</div>
		</li>


		<li id="foli3" class=" ">
			<label class="desc" id="title5" for="orientation">
				Sexual Orientation
				<span id="req_5" class="req">*</span>
			</label>
			<div class="column">
				<input id="radioDefault_5" name="orientation" type="hidden" value="" tabindex="1" />
				<input id="orientation_0" name="orientation" type="radio" class="field radio" value="Exclusively heterosexual"  tabindex="1" />
				<label class="choice" for="orientation_0">Exclusively heterosexual</label>
				<input id="orientation_1" name="orientation" type="radio" class="field radio" value="Predominantly heterosexual"  tabindex="1" />
				<label class="choice" for="orientation_1">Predominantly heterosexual</label>
				<input id="orientation_2" name="orientation" type="radio" class="field radio" value="Bisexual"  tabindex="1" />
				<label class="choice" for="orientation_2">Bisexual</label>
				<input id="orientation_3" name="orientation" type="radio" class="field radio" value="Predominantly homosexual"  tabindex="1" />
				<label class="choice" for="orientation_3">Predominantly homosexual</label>
				<input id="orientation_4" name="orientation" type="radio" class="field radio" value="Exclusively homosexual"  tabindex="1" />
				<label class="choice" for="orientation_4">Exclusively homosexual</label>
			</div>
		</li>

		<li id="foli4" class=" ">
			<label class="desc" id="title21" for="typesofbowdoinrelationships">
				What types of interactions have you had with other Bowdoin students? Check all that apply.
			</label>
			<div class="column">
			<input id="typesofbowdoinrelationships_0" name="typesofbowdoinrelationships[]" type="checkbox" class="field checkbox" value="None"  tabindex="1" />
				<label class="choice" for="typesofbowdoinrelationships_0">None</label>
				<input id="typesofbowdoinrelationships_1" name="typesofbowdoinrelationships[]" type="checkbox" class="field checkbox" value="One night hook-up"  tabindex="1" />
				<label class="choice" for="typesofbowdoinrelationships_1">One night hook-up (anything from kissing to having sex)</label>
				<input id="typesofbowdoinrelationships_2" name="typesofbowdoinrelationships[]" type="checkbox" class="field checkbox" value="Multiple hook-ups with the same person, but no relationship"  tabindex="1" />
				<label class="choice" for="typesofbowdoinrelationships_2">Multiple hook-ups with the same person, but no relationship</label>
				<input id="typesofbowdoinrelationships_3" name="typesofbowdoinrelationships[]" type="checkbox" class="field checkbox" value="Going out on one date with someone you are not already in a relationship with"  tabindex="1" />
				<label class="choice" for="typesofbowdoinrelationships_3">Going out on one date with someone you are not already in a relationship with</label>
				<input id="typesofbowdoinrelationships_4" name="typesofbowdoinrelationships[]" type="checkbox" class="field checkbox" value="Going out on multiple dates with someone you are not already in a relationship with"  tabindex="1" />
				<label class="choice" for="typesofbowdoinrelationships_4">Going out on multiple dates with someone you are not already in a relationship with</label>
				<input id="typesofbowdoinrelationships_5" name="typesofbowdoinrelationships[]" type="checkbox" class="field checkbox" value="Committed relationship of any length of time"  tabindex="1" />
				<label class="choice" for="typesofbowdoinrelationships_5">Committed relationship of any length of time</label>
				<input id="typesofbowdoinrelationships_6" name="typesofbowdoinrelationships[]" type="checkbox" class="field checkbox" value="Casual/open relationship"  tabindex="1" />
				<label class="choice" for="typesofbowdoinrelationships_6">Casual/open relationship</label>
			</div>
<!-- 			<p class="instruct" id="instruct21"><small>"Hook-up" defined as anything from kissing to having sex.</small></p> -->
		</li>


		<li id="foli5" class=" ">
			<label class="desc" id="title121" for="frequentlyengaged">
				Of the types of interactions listed, which ones make up the majority of your romantic/sexual experiences at Bowdoin? Check all that apply.
			</label>
			<div class="column">
				<input id="frequentlyengaged_0" name="frequentlyengaged[]" type="checkbox" class="field checkbox" value="None"  tabindex="1" />
				<label class="choice" for="frequentlyengaged_0">None</label>
				<input id="frequentlyengaged_1" name="frequentlyengaged[]" type="checkbox" class="field checkbox" value="One night hook-up (anything from kissing to having sex)"  tabindex="1" />
				<label class="choice" for="frequentlyengaged_1">One night hook-up (anything from kissing to having sex)</label>
				<input id="frequentlyengaged_2" name="frequentlyengaged[]" type="checkbox" class="field checkbox" value="Multiple hook-ups with the same person, but no relationship"  tabindex="1" />
				<label class="choice" for="frequentlyengaged_2">Multiple hook-ups with the same person, but no relationship</label>
				<input id="frequentlyengaged_3" name="frequentlyengaged[]" type="checkbox" class="field checkbox" value="Going out on one date with someone you are not already in a relationship with"  tabindex="1" />
				<label class="choice" for="frequentlyengaged_3">Going out on one date with someone you are not already in a relationship with</label>
				<input id="frequentlyengaged_4" name="frequentlyengaged[]" type="checkbox" class="field checkbox" value="Going out on multiple dates with someone you are not already in a relationship with"  tabindex="1" />
				<label class="choice" for="frequentlyengaged_4">Going out on multiple dates with someone you are not already in a relationship with</label>
				<input id="frequentlyengaged_5" name="frequentlyengaged[]" type="checkbox" class="field checkbox" value="Committed relationship of any length of time"  tabindex="1" />
				<label class="choice" for="frequentlyengaged_5">Committed relationship of any length of time</label>
				<input id="frequentlyengaged_6" name="frequentlyengaged[]" type="checkbox" class="field checkbox" value="Casual/open relationship"  tabindex="1" />
				<label class="choice" for="frequentlyengaged_6">Casual/open relationship</label>
			</div>
		</li>
		
		<li id='foli6' class=' '>
			<label class='desc' id='title199' for='alcohol'>
				How often does alcohol significantly influence your decision to hook up with somebody at Bowdoin (outside of a relationship)?
			</label>
			<div class='column'>
				<input id='radioDefault_199' name='alcohol' type='hidden' value='' tabindex="1" />
				<input id='alcohol_0' name='alcohol' type='radio' class='field radio' value='Always' tabindex="1" />
				<label class='choice' for='alcohol_0'>Always</label>
				<input id='alcohol_1' name='alcohol' type='radio' class='field radio' value='Usually' tabindex="1" />
				<label class='choice' for='alcohol_1'>Usually</label>
				<input id='alcohol_2' name='alcohol' type='radio' class='field radio' value='Sometimes' tabindex="1" />
				<label class='choice' for='alcohol_2'>Sometimes</label>
				<input id='alcohol_3' name='alcohol' type='radio' class='field radio' value='Rarely' tabindex="1" />
				<label class='choice' for='alcohol_3'>Rarely</label>
				<input id='alcohol_4' name='alcohol' type='radio' class='field radio' value='Never' tabindex="1" />
				<label class='choice' for='alcohol_4'>Never</label>
				<input id='alcohol_5' name='alcohol' type='radio' class='field radio' value='N/A' tabindex="1" />
				<label class='choice' for='alcohol_5'>I haven't hooked up with anyone at Bowdoin/I have only hooked up with someone I am in relationship with.</label>
		</li>

		<li id="foli7" class=" ">
			<label class="desc" id="title19" for="relationshipsatbowdoin">
				How many committed relationships have you had at Bowdoin with other Bowdoin students?
			</label>
			<div class="column">
				<input id="radioDefault_19" name="relationshipsatbowdoin" type="hidden" value="" tabindex="1" />
				<input id="relationshipsatbowdoin_0" name="relationshipsatbowdoin" type="radio" class="field radio" value="0"  tabindex="1" />
				<label class="choice" for="relationshipsatbowdoin_0">0</label>
				<input id="relationshipsatbowdoin_1" name="relationshipsatbowdoin" type="radio" class="field radio" value="1"  tabindex="1" />
				<label class="choice" for="relationshipsatbowdoin_1">1</label>
				<input id="relationshipsatbowdoin_2" name="relationshipsatbowdoin" type="radio" class="field radio" value="2-3"  tabindex="1" />
				<label class="choice" for="relationshipsatbowdoin_2">2-3</label>
				<input id="relationshipsatbowdoin_3" name="relationshipsatbowdoin" type="radio" class="field radio" value="4 or more"  tabindex="1" />
				<label class="choice" for="relationshipsatbowdoin_3">4 or more</label>
			</div>
		</li>


		<li id="foli8" class=" ">
			<label class="desc" id="title17" for="lackofexperience">
				If you haven't dated/been in a relationship, do you worry about your lack of experience?
			</label>
			<div class="column">
				<input id="radioDefault_17" name="lackofexperience" type="hidden" value="" tabindex="1" />
				<input id="lackofexperience_0" name="lackofexperience" type="radio" class="field radio" value="Yes"  tabindex="1" tabindex="1" />
				<label class="choice" for="lackofexperience_0">Yes</label>
				<input id="lackofexperience_1" name="lackofexperience" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="lackofexperience_1">No</label>
			</div>
		</li>



		<li id="foli9" class=" ">
			<label class="desc" id="title2" for="bowdoindatingscene">
				How satisfied are you with the dating scene at Bowdoin? ("Dating scene" encompasses all romantic/sexual interactions)
			</label>
			<div class="column">
				<input id="radioDefault_2" name="bowdoindatingscene" type="hidden" value="" tabindex="1" />
				<input id="bowdoindatingscene_0" name="bowdoindatingscene" type="radio" class="field radio" value="Very satisfied"  tabindex="1" />
				<label class="choice" for="bowdoindatingscene_0">Very satisfied</label>
				<input id="bowdoindatingscene_1" name="bowdoindatingscene" type="radio" class="field radio" value="Satisfied"  tabindex="1" />
				<label class="choice" for="bowdoindatingscene_1">Satisfied</label>
				<input id="bowdoindatingscene_2" name="bowdoindatingscene" type="radio" class="field radio" value="Indifferent"  tabindex="1" />
				<label class="choice" for="bowdoindatingscene_2">Indifferent</label>
				<input id="bowdoindatingscene_3" name="bowdoindatingscene" type="radio" class="field radio" value="Unsatisfied"  tabindex="1" />
				<label class="choice" for="bowdoindatingscene_3">Unsatisfied</label>
				<input id="bowdoindatingscene_4" name="bowdoindatingscene" type="radio" class="field radio" value="Very unsatisfied"  tabindex="1" />
				<label class="choice" for="bowdoindatingscene_4">Very unsatisfied</label>
			</div>
		</li>


		<li id="foli10" class=" ">
			<label class="desc" id="title4" for="othersatisfied">
				How satisfied do you think other Bowdoin students are with the dating scene?
			</label>
			<div class="column">
				<input id="radioDefault_4" name="othersatisfied" type="hidden" value="" tabindex="1" />
				<input id="othersatisfied_0" name="othersatisfied" type="radio" class="field radio" value="Very satisfied"  tabindex="1" />
				<label class="choice" for="othersatisfied_0">Very satisfied</label>
				<input id="othersatisfied_1" name="othersatisfied" type="radio" class="field radio" value="Satisfied"  tabindex="1" />
				<label class="choice" for="othersatisfied_1">Satisfied</label>
				<input id="othersatisfied_2" name="othersatisfied" type="radio" class="field radio" value="Indifferent"  tabindex="1" />
				<label class="choice" for="othersatisfied_2">Indifferent</label>
				<input id="othersatisfied_3" name="othersatisfied" type="radio" class="field radio" value="Unsatisfied"  tabindex="1" />
				<label class="choice" for="othersatisfied_3">Unsatisfied</label>
				<input id="othersatisfied_4" name="othersatisfied" type="radio" class="field radio" value="Very unsatisfied"  tabindex="1" />
				<label class="choice" for="othersatisfied_4">Very unsatisfied</label>
			</div>
		</li>


		<li id="foli11" class=" ">
			<label class="desc" id="title5" for="relationshipnow">
				Are you in a relationship right now?
			</label>
			<div class="column">
				<input id="radioDefault_5" name="relationshipnow" type="hidden" value="" tabindex="1" />
				<input id="relationshipnow_0" name="relationshipnow" type="radio" class="field radio" value="Yes"  tabindex="1" />
				<label class="choice" for="relationshipnow_0">Yes</label>
				<input id="relationshipnow_1" name="relationshipnow" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="relationshipnow_1">No</label>
			</div>
		</li>


		<li id="foli12" class=" ">
			<label class="desc" id="title16" for="whynotnow">
				If not, why not? (check all that apply)
			</label>
			<div class="column">
				<input id="whynotnow_0" name="whynotnow[]" type="checkbox" class="field checkbox" value="Don&#039;t have time"  tabindex="1" />
				<label class="choice" for="whynotnow_0">Don't have time</label>
				<input id="whynotnow_1" name="whynotnow[]" type="checkbox" class="field checkbox" value="Not interested in anyone"  tabindex="1" />
				<label class="choice" for="whynotnow_1">Not interested in anyone</label>
				<input id="whynotnow_2" name="whynotnow[]" type="checkbox" class="field checkbox" value="Interested in someone who is not interested in me"  tabindex="1" />
				<label class="choice" for="whynotnow_2">Interested in someone who is not interested in me</label>
				<input id="whynotnow_3" name="whynotnow[]" type="checkbox" class="field checkbox" value="Interested in someone but have not pursued him/her"  tabindex="1" />
				<label class="choice" for="whynotnow_3">Interested in someone but have not pursued him/her</label>
			</div>
		</li>


		<li id="foli13" class=" ">
			<label class="desc" id="title9" for="wantrelationship">
				If you are single, would you like to be in a relationship?
			</label>
			<div class="column">
				<input id="radioDefault_9" name="wantrelationship" type="hidden" value="" tabindex="1" />
				<input id="wantrelationship_0" name="wantrelationship" type="radio" class="field radio" value="Yes"  tabindex="1" />
				<label class="choice" for="wantrelationship_0">Yes</label>
				<input id="wantrelationship_1" name="wantrelationship" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="wantrelationship_1">No</label>
				<input id="wantrelationship_2" name="wantrelationship" type="radio" class="field radio" value="Unsure"  tabindex="1" />
				<label class="choice" for="wantrelationship_2">Unsure</label>
			</div>
		</li>


		<li id="foli14" class=" ">
			<label class="desc" id="title6" for="everbeenaskedondate">
				Have you ever been asked out on a date by Bowdoin student?
			</label>
			<div class="column">
				<input id="radioDefault_6" name="everbeenaskedondate" type="hidden" value="" tabindex="1" />
				<input id="everbeenaskedondate_0" name="everbeenaskedondate" type="radio" class="field radio" value="Yes"  tabindex="1" />
				<label class="choice" for="everbeenaskedondate_0">Yes</label>
				<input id="everbeenaskedondate_1" name="everbeenaskedondate" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="everbeenaskedondate_1">No</label>
			</div>
		</li>


		<li id="foli15" class=" ">
			<label class="desc" id="title6" for="everaskedondate">
				Have you ever asked anyone out on a date at Bowdoin?
			</label>
			<div class="column">
				<input id="radioDefault_6" name="everaskedondate" type="hidden" value="" tabindex="1" />
				<input id="everaskedondate_0" name="everaskedondate" type="radio" class="field radio" value="Yes"  tabindex="1" />
				<label class="choice" for="everaskedondate_0">Yes</label>
				<input id="everaskedondate_1" name="everaskedondate" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="everaskedondate_1">No</label>
			</div>
		</li>


		<li id="foli16" class=" ">
			<label class="desc" id="title12" for="toonervous">
				Have you ever wanted to ask someone out at Bowdoin but been too nervous?
			</label>
			<div class="column">
				<input id="radioDefault_12" name="toonervous" type="hidden" value="" tabindex="1" />
				<input id="toonervous_0" name="toonervous" type="radio" class="field radio" value="Yes"  tabindex="1" />
				<label class="choice" for="toonervous_0">Yes</label>
				<input id="toonervous_1" name="toonervous" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="toonervous_1">No</label>
			</div>
		</li>


		<li id="foli17" class=" ">
			<label class="desc" id="title11" for="toomuchtime">
				Have you ever NOT pursued someone and/or ended a relationship at Bowdoin because it was too much of a time commitment?
			</label>
			<div class="column">
				<input id="radioDefault_11" name="toomuchtime" type="hidden" value="" tabindex="1" />
				<input id="toomuchtime_0" name="toomuchtime" type="radio" class="field radio" value="Yes"  tabindex="1" />
				<label class="choice" for="toomuchtime_0">Yes</label>
				<input id="toomuchtime_1" name="toomuchtime" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="toomuchtime_1">No</label>
			</div>
		</li>


		<li id="foli18" class=" ">
			<label class="desc" id="title13" for="pressure">
				Do you feel pressure to date or be in a relationship?
			</label>
			<div class="column">
				<input id="radioDefault_13" name="pressure" type="hidden" value="" tabindex="1" />
				<input id="pressure_0" name="pressure" type="radio" class="field radio" value="Yes"  tabindex="1" />
				<label class="choice" for="pressure_0">Yes</label>
				<input id="pressure_1" name="pressure" type="radio" class="field radio" value="No"  tabindex="1" />
				<label class="choice" for="pressure_1">No</label>
			</div>
		</li>



		<p>
		Please answer all required questions (marked with a red asterisk). Once you submit this form, you will not be able to revise your answers.
		</p>
		<li class="buttons">
		<input id="saveForm" name='submit' class="btTxt" type="submit" value="Submit" tabindex="1" />
		</li>

	</ul>
	<p><small>If you are having any problems, please e-mail Mary Helen Miller at <a href="mailto:mmiller2@bowdoin.edu">mmiller2@bowdoin.edu</a>.</small></p>
	</form>
</div>

<?php
include("../stop.php");
?>