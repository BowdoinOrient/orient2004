<?php 
$authenticated = false;
$closed = false;
?>

<?php
include("../start.php");
include("polls.php");


startPoll("election08.php", $closed, $authenticated);
startcode("The Bowdoin Orient - Polls", false, false, $articleDate, $issueNumber, $volumeNumber);

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
			alert("You have only answered " + num + " of the 11 questions.  Please complete the rest of them.\n\nIf this number is incorrect, please refresh the page.");
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
<h1 id="logo"><a>2008 Election Survey</a></h1>

<form id="form1" class="wufoo topLabel" autocomplete="off"
	enctype="multipart/form-data" method="post">

<div class="info">
	<h2>Orient Election Survey</h2>
	<div>
	<p id="errorp" class="error"><?php echo $error; ?></p>
	</div>
</div>

<ul>

	<li id="foli160" class="  ">
	<label class="desc" id="title160" for="Field170">
		Are you a current Bowdoin student of voting age and an American citizen?
				
			</label>
	
	<div class="column">
				   <input id="Field170_1"
		 		  		name="student" 
	   		class="field radio" type="radio" 
			tabindex="1"
			 
	   		value="Y" />
		<label class="choice" for="Field170_1">Yes</label>
				   <input id="Field170_2"
		 		  		name="student" 
	   		class="field radio" type="radio" 
			tabindex="2"
			 
	   		value="N" />
		<label class="choice" for="Field170_2">No</label>
			</div>
	
			<p class="instruct " id="instruct170"><small>If you are a Bowdoin student currently studying abroad, select "Yes" if you are eligible to vote.</small></p>	
	
</li>	
	<li id="foli105" class="  ">
	<label class="desc" id="title105" for="Field105">
		Sex
				
			</label>
	
	<div class="column">
				   <input id="Field105_1"
		 		  		name="gender" 
	   		class="field radio" type="radio" 
			tabindex="1"
			 
	   		value="M" />
		<label class="choice" for="Field105_1">Male</label>
				   <input id="Field105_2"
		 		  		name="gender" 
	   		class="field radio" type="radio" 
			tabindex="2"
			 
	   		value="F" />
		<label class="choice" for="Field105_2">Female</label>
			</div>
	
	
	
</li>

<li id="foli114" 
		class="  ">
	
		
	<label class="desc" id="title114" for="Field114">
		Class year
				
			</label>
	
	<div class="column">
		
	
				   <input id="Field114_1"
		 		  		name="year" 
	   		class="field radio" type="radio" 
			tabindex="3"
			 
	   		value="2012" />
		<label class="choice" for="Field114_1">First year ('12)</label>
				   <input id="Field114_2"
		 		  		name="year" 
	   		class="field radio" type="radio" 
			tabindex="4"
			 
	   		value="2011" />
		<label class="choice" for="Field114_2">Sophomore ('11)</label>
				   <input id="Field114_3"
		 		  		name="year" 
	   		class="field radio" type="radio" 
			tabindex="5"
			 
	   		value="2010" />
		<label class="choice" for="Field114_3">Junior ('10)</label>
				   <input id="Field114_4"
		 		  		name="year" 
	   		class="field radio" type="radio" 
			tabindex="6"
			 
	   		value="2009" />
		<label class="choice" for="Field114_4">Senior ('09)</label>
				   <input id="Field114_5"
		 		  		name="year" 
	   		class="field radio" type="radio" 
			tabindex="7"
			 
	   		value="2008" />
		<label class="choice" for="Field114_5">'08 or beyond</label>
			</div>
	
	
	
</li><li id="foli108" 
		class="  ">
	
		
	<label class="desc" id="title108" for="Field108">
		Party registration
				
			</label>
	
	<div class="column">	
				   <input id="Field108_1"
		 		  		name="party" 
	   		class="field radio" type="radio" 
			tabindex="8"
			 
	   		value="Rep" />
		<label class="choice" for="Field108_1">Republican</label>
				   <input id="Field108_2"
		 		  		name="party" 
	   		class="field radio" type="radio" 
			tabindex="9"
			 
	   		value="Dem" />
		<label class="choice" for="Field108_2">Democrat</label>
				   <input id="Field108_3"
		 		  		name="party" 
	   		class="field radio" type="radio" 
			tabindex="10"
			 
	   		value="Ind" />
		<label class="choice" for="Field108_3">Independent</label>
				   <input id="Field108_4"
		 		  		name="party" 
	   		class="field radio" type="radio" 
			tabindex="11"
			 
	   		value="Unregistered" />
		<label class="choice" for="Field108_4">I am not registered with a party</label>
			</div>
	
			<p class="instruct " id="instruct108"><small>If you are registered with a third party, select "Independent."
			<br />
			<br />If you are registered to vote, but not with a party, then select "I am not registered with a party."
			<br />
			<br /> If you are not yet registered with a party, but plan to do so, select with whom you plan on registering.
			<br />
			<br /> Finally, if you are not registered to vote, nor plan on registering, select "I am not registered with a party."
			</small></p>
	
	
</li><li id="foli109" 
		class="  ">
	
		
	<label class="desc" id="title109" for="Field109">
		In what state are you registered to vote?
				
			</label>
	
	<div class="column">
	
				   <input id="Field109_1"
		 		  		name="state" 
	   		class="field radio" type="radio" 
			tabindex="12"
			 
	   		value="Maine" />
		<label class="choice" for="Field109_1">Maine</label>
				   
				   <input id="Field109_3"
		 		  		name="state" 
	   		class="field radio" type="radio" 
			tabindex="14"
			 
	   		value="Other" />
		<label class="choice" for="Field109_3">Other state</label>
				   <input id="Field109_4"
		 		  		name="state" 
	   		class="field radio" type="radio" 
			tabindex="15"
			 
	   		value="Don't Know" />
		<label class="choice" for="Field109_4">I do not know</label>
				   <input id="Field109_5"
		 		  		name="state" 
	   		class="field radio" type="radio" 
			tabindex="16"
			 
	   		value="Not Registered" />
		<label class="choice" for="Field109_5">I am not registered to vote</label>
			</div>
		<p class="instruct " id="instruct109"><small>If you are not yet registered to vote, but plan to do so, in which state do you plan on registering?</small></p>

	
	
</li><li id="foli117" 
		class="  ">
	
		
	<label class="desc" id="title117" for="Field117">
		Do you plan to vote in the presidential election this fall?
				
			</label>
	
	<div class="column">
				   <input id="Field117_1"
		 		  		name="voting" 
	   		class="field radio" type="radio" 
			tabindex="17"
			 
	   		value="5" />
		<label class="choice" for="Field117_1">I am guaranteed to vote</label>
				   <input id="Field117_2"
		 		  		name="voting" 
	   		class="field radio" type="radio" 
			tabindex="18"
			 
	   		value="4" />
		<label class="choice" for="Field117_2">I will likely vote</label>
				   <input id="Field117_3"
		 		  		name="voting" 
	   		class="field radio" type="radio" 
			tabindex="19"
			 
	   		value="3" />
		<label class="choice" for="Field117_3">I may vote</label>
				   <input id="Field117_4"
		 		  		name="voting" 
	   		class="field radio" type="radio" 
			tabindex="20"
			 
	   		value="2" />
		<label class="choice" for="Field117_4">I will probably not vote</label>
				   <input id="Field117_5"
		 		  		name="voting" 
	   		class="field radio" type="radio" 
			tabindex="21"
			 
	   		value="1" />
		<label class="choice" for="Field117_5">I will not vote</label>
			</div>
		<p class="instruct " id="instruct117"><small>If you have already voted, select "I am guaranteed to vote."</small></p>
	

</li>

<li id="foli1" 
		class="  ">
	
		
	<label class="desc" id="title1" for="Field1">
		For whom do you plan on voting this fall for President of the United States?
				
			</label>
	
	<div class="column">
				   <input id="Field1_1"
		 		  		name="candidate" 
	   		class="field radio" type="radio" 
			tabindex="22"
			 
	   		value="John McCain" />
		<label class="choice" for="Field1_1">John McCain (R)</label>
				   <input id="Field1_2"
		 		  		name="candidate" 
	   		class="field radio" type="radio" 
			tabindex="23"
			 
	   		value="Barack Obama" />
		<label class="choice" for="Field1_2">Barack Obama (D)</label>
				   <input id="Field1_3"
		 		  		name="candidate" 
	   		class="field radio" type="radio" 
			tabindex="24"
			 
	   		value="Bob Barr" />
		<label class="choice" for="Field1_3">Bob Barr (I)</label>
				   <input id="Field1_4"
		 		  		name="candidate" 
	   		class="field radio" type="radio" 
			tabindex="25"
			 
	   		value="Ralph Nader" />
		<label class="choice" for="Field1_4">Ralph Nader (I)</label>
				   <input id="Field1_5"
		 		  		name="candidate" 
	   		class="field radio" type="radio" 
			tabindex="26"
			 
	   		value="Other" />
		<label class="choice" for="Field1_5">Other</label>
				   <input id="Field1_6"
		 		  		name="candidate" 
	   		class="field radio" type="radio" 
			tabindex="27"
			 
	   		value="Undecided" />
		<label class="choice" for="Field1_6">Undecided</label>
				   <input id="Field1_7"
		 		  		name="candidate" 
	   		class="field radio" type="radio" 
			tabindex="28"
			 
	   		value="Not Voting" />
		<label class="choice" for="Field1_7">I am not planning on voting</label>
			</div>
		<p class="instruct " id="instruct117"><small>If you have already voted, select the candidate for whom you voted.</small></p>
	
	
</li>

<li id="foli118" 
		class="  ">
	
		
	<label class="desc" id="title118" for="Field118">
		How closely have you followed the presidential election?
				
			</label>
	
	<div class="column">
				   <input id="Field118_1"
		 		  		name="following" 
	   		class="field radio" type="radio" 
			tabindex="29"
			 
	   		value="3" />
		<label class="choice" for="Field118_1">Very closely: I read (or watch on TV) election coverage almost everyday</label>
				   <input id="Field118_2"
		 		  		name="following" 
	   		class="field radio" type="radio" 
			tabindex="30"
			 
	   		value="2" />
		<label class="choice" for="Field118_2">Somewhat closely: I read (or watch on TV) election coverage a few times a week</label>
				   <input id="Field118_3"
		 		  		name="following" 
	   		class="field radio" type="radio" 
			tabindex="31"
			 
	   		value="1" />
		<label class="choice" for="Field118_3">Not closely: I rarely read (or watch on TV) election coverage</label>
			</div>
	
	
	
</li>

<li id="foli120" 
		class="  ">
	
		
	<label class="desc" id="title120" for="Field120">
		What issue in the presidential race is most important to you this year?
				
			</label>
	
	<div class="column">
				   <input id="Field120_1"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="32"
			 
	   		value="Abortion" />
		<label class="choice" for="Field120_1">Abortion</label>
				   <input id="Field120_2"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="33"
			 
	   		value="Economy" />
		<label class="choice" for="Field120_2">Economy</label>
				   <input id="Field120_3"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="34"
			 
	   		value="Education" />
		<label class="choice" for="Field120_3">Education</label>
				   <input id="Field120_4"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="35"
			 
	   		value="Energy/oil" />
		<label class="choice" for="Field120_4">Energy/oil</label>
				   <input id="Field120_5"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="36"
			 
	   		value="Environment" />
		<label class="choice" for="Field120_5">Environment</label>
				   <input id="Field120_6"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="37"
			 
	   		value="Foreign affairs (including Iraq War)" />
		<label class="choice" for="Field120_6">Foreign affairs (including Iraq War)</label>
				   <input id="Field120_7"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="38"
			 
	   		value="Guns" />
		<label class="choice" for="Field120_7">Guns</label>
				   <input id="Field120_8"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="39"
			 
	   		value="Health care" />
		<label class="choice" for="Field120_8">Health care</label>
				   <input id="Field120_9"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="40"
			 
	   		value="Homeland security" />
		<label class="choice" for="Field120_9">Homeland security</label>
				   <input id="Field120_10"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="41"
			 
	   		value="Immigration" />
		<label class="choice" for="Field120_10">Immigration</label>
				   <input id="Field120_11"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="42"
			 
	   		value="LGBT issues" />
		<label class="choice" for="Field120_11">LGBT issues</label>
				   <input id="Field120_12"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="43"
			 
	   		value="Social security" />
		<label class="choice" for="Field120_12">Social security</label>
				   <input id="Field120_13"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="44"
			 
	   		value="Taxes" />
		<label class="choice" for="Field120_13">Taxes</label>
				   <input id="Field120_14"
		 		  		name="issue" 
	   		class="field radio" type="radio" 
			tabindex="45"
			 
	   		value="Specify" />
		<label class="choice" for="Field120_14">Other (please specify) </label>
		<input id="Field121_" name="otherissue" class="field text" type="text" tabindex="46" />
			</div>
	
	
	
</li>

<li id="foli1" 
		class="  ">
	
		
	<label class="desc" id="title1" for="Field130">
		For whom do you plan on voting this fall for Maine's contested United States Senate seat?
				
			</label>
	
	<div class="column">
				   <input id="Field130_3"
		 		  		name="senate" 
	   		class="field radio" type="radio" 
			tabindex="24"
			 
	   		value="Susan Collins" />
		<label class="choice" for="Field130_3">Susan Collins (R)</label>
				   <input id="Field130_4"
		 		  		name="senate" 
	   		class="field radio" type="radio" 
			tabindex="25"
			 
	   		value="Tom Allen" />
		<label class="choice" for="Field130_4">Tom Allen (D)</label>
				   <input id="Field130_5"
		 		  		name="senate" 
	   		class="field radio" type="radio" 
			tabindex="26"
			 
	   		value="Other" />
		<label class="choice" for="Field130_5">Other</label>
				   <input id="Field130_6"
		 		  		name="senate" 
	   		class="field radio" type="radio" 
			tabindex="27"
			 
	   		value="Undecided" />
		<label class="choice" for="Field130_6">Undecided</label>
				   <input id="Field130_1"
		 		  		name="senate"
	   		class="field radio" type="radio" 
			tabindex="22" 
			 
	   		value="Not Registered" /> 
		<label class="choice" for="Field130_1">I am not registered in Maine</label>
				   <input id="Field130_2"
		 		  		name="senate"
	   		class="field radio" type="radio" 
			tabindex="23"
			 
	   		value="Not Voting" />
		<label class="choice" for="Field130_2">I am registered in Maine, but I am not planning on voting in this race</label>
			</div>
		<p class="instruct " id="instruct117"><small>If you have already voted, select the candidate for whom you voted.</small></p>	
	
	
</li>

<li id="foli1" 
		class="  ">
	
		
	<label class="desc" id="title1" for="Field140">
		For whom do you plan on voting this fall for Maine's First Congressional District United States House of Representatives seat?
				
			</label>
	
	<div class="column">
				   <input id="Field140_3"
		 		  		name="house" 
	   		class="field radio" type="radio" 
			tabindex="24"
			 
	   		value="Charlie Summers" />
		<label class="choice" for="Field140_3">Charlie Summers (R)</label>
				   <input id="Field140_4"
		 		  		name="house" 
	   		class="field radio" type="radio" 
			tabindex="25"
			 
	   		value="Chellie Pingree" />
		<label class="choice" for="Field140_4">Chellie Pingree (D)</label>
				   <input id="Field140_8" name="house" class="field radio" type="radio" tabindex="27" value="Bobby Mills" />
		<label class="choice" for="Field140_8">Bobby Mills (I)</label>
				   <input id="Field140_5"
		 		  		name="house" 
	   		class="field radio" type="radio" 
			tabindex="26"
			 
	   		value="Other" />
		<label class="choice" for="Field140_5">Other</label>
				   <input id="Field140_6"
		 		  		name="house" 
	   		class="field radio" type="radio" 
			tabindex="28"
			 
	   		value="Undecided" />
		<label class="choice" for="Field140_6">Undecided</label>
						   <input id="Field140_1"
		 		  		name="house" 
	   		class="field radio" type="radio" 
			tabindex="22"
			 
	   		value="Not Registered" />
		<label class="choice" for="Field140_1">I am not registered in Maine</label>
				   <input id="Field140_2"
		 		  		name="house" 
	   		class="field radio" type="radio" 
			tabindex="23"
			 
	   		value="Not Voting" />
		<label class="choice" for="Field140_2">I am registered in Maine, but I am not planning on voting in this race</label>
			</div>
		<p class="instruct " id="instruct117"><small>If you have already voted, select the candidate for whom you voted.</small></p>	
	
	
</li>
	<p>
	All questions are required.  Once you submit this form, you will not be able to revise your answers.
	</p>
	<p><b>
	Please note that this poll has closed.  This page is purely for historical purposes, and you cannot take this particular poll anymore.
	</b></p>
	<li class="buttons">
		<input onclick="return checkOther();" id="saveForm" disabled='disabled' name='submit' class="btTxt" type="submit" value="Submit" />
	</li>
				
</ul>
</form>
</div>

<?php
include("../stop.php");
?>