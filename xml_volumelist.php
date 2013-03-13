<?php 
	
	header("Content-Type: application/xml; charset=UTF-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';

	include("dbconnect.php");
	include("getcurrentdate.php");
	
?>

<orient>
	
	<?php
	
	$volumes_result = mysql_query("
		select `id`, `numeral` from volume
	");
	
	while($volume = mysql_fetch_assoc($volumes_result))
	{
	
	?>
		
	<volume id="<?=$volume["id"]?>">
		<numeral><?=$volume["numeral"]?></numeral>
	</volume>
	
	<?php
	}
	?>
	
</orient>