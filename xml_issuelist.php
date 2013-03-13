<?php 
	
	header("Content-Type: application/xml; charset=UTF-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';

	include("dbconnect.php");
	include("getcurrentdate.php");

	$volume = $_GET["volume"];
	
?>

<volume>
	<volumenumber><?=$volume?></volumenumber>
	
	<?php
	
	$volume_result = mysql_query("
		select
			date_format(issue.issue_date, '%b %e, %Y') as date,
			issue.issue_number,
			volume.numeral
		from issue
		inner join volume on issue.volume_id = volume.id
		where volume.numeral = '".$volume."'
	");
	
	while($issue = mysql_fetch_assoc($volume_result))
	{
	
	?>
		
	<issue id="<?=$issue["issue_number"]?>">
		<date><?=$issue["date"]?></date>
	</issue>
	
	<?php
	}
	?>
	
</volume>