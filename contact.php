<?php
include("template/top.php");
$title = "Contact Us";
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
	<div class='span-16 information'>
		<h2 class='articlesection'>Contact Us</h2>
		
		<div class='information infospecial'>
			<h3 class='articletitle'>Mailing Address</h3>
				<p>The Bowdoin Orient <br />
					 6200 College Station <br />
					Brunswick, ME 04011-8462</p>
				
			<h3 class='articletitle'>Telephone</h3>
				<p>Phone: (207) 725-3300 <br />
				Business Phone: (207) 725-3053</p>
		
			<h3 class='articletitle'>Email</h3>
				<table class='emailtable'>
					<tr>
						<td>General Inquiries/Subscriptions:</td>
						<td><a href='mailto: orient@bowdoin.edu'>orient@bowdoin.edu</a></td>
					</tr>
					<tr>
						<td>Business/Advertising Inquiries:</td>
						<td><a href='mailto: orientads@bowdoin.edu'>orientads@bowdoin.edu</a></td>
					</tr>
					<tr>
						<td>Website questions/comments:</td>
						<td><a href='mailto: orientweb@bowdoin.edu'>orientweb@bowdoin.edu</a></td>
					</tr>
					<tr>
						<td>Letters to the editor:</td>
						<td><a href='letters.php'>Send a letter to the editor</a></td>
					</tr>
				</table>
		</div>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>