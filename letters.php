<?php
include("template/top.php");
$title = "The Bowdoin Orient - Send a Letter to the Editor";
startPage();
?>

<!-- Side Links (3 blocks) -->
<div class='span-3 menudiv'>
	<?php include("template/mainlinks.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/otherlinks.php"); ?>
</div>

<!-- The rest of the page is to the right of the link bar -->
<div class='span-21 last'>
	<div class='span-16 letters information'>
		<h2 class='articlesection'>Send a Letter to the Editor</h2>
		
			<h3 class='articletitle'>Letter Requirements</h3>
			<ol>
				<li>Letters should be recieved by 7:00 p.m. on the Wednesday of the week of publication.</li>
				<li>Letters must be signed. We will not publish unsigned letters.</li>
				<li>Letters should not exceed 200 words.</li>
			</ol>
			
			<h3 class='articletitle'>Ways to send a letter to the editor</h3>
			<ol>
				<li>Fill out our online <a href='#' onclick='rs("ss", "sendletter.php", 700, 600); return false;'>letter submission form</a>.</li>
				<li>Email a letter to the <a href='mailto:orientopinion@bowdoin.edu'>opinion editor</a> in Microsoft Word format.</li>
			</ol>
			
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>