<?php

# Get next Friday's date.  
$sqlQuery = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL ID DAY), '%Y-%m-%d') AS DATE FROM `days` WHERE DATE_FORMAT(DATE_ADD(NOW(), INTERVAL ID DAY), '%W') ='Friday' LIMIT 0, 30"; 

# Connect to DB.
mysql_connect("teddy","orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

$result = mysql_query ($sqlQuery);
if ($row = mysql_fetch_array($result)) {
	$nextfriday = $row["DATE"];
}
else {
	$nextfriday = "2000-01-01";
}

?>
<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>

<table bgcolor="CCCCCC" cellpadding="1" width="100%"><tr><td>
<font class="textbold">&nbsp;Add a related document</font><tr><td></table>

<FORM method="POST" action="documentform.php">
  <table cellspacing=0 cellpadding=5>
    <tr> 
      <td valign="top"> <table cellspacing=0 cellpadding=2>
    <tr> 
      <td valign="top">Issue Date: </td>
      <td valign="top"> 
		<SELECT name="date">
         	<?php 
		$sqlQuery = "select issue_date from issue";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
		$issueDate2 = $row["issue_date"];
		?>
         	 <OPTION 
		<?php if ($issueDate2 == $nextfriday) { ?>
		selected
		<?php } ?>

		value="<?php echo $issueDate2 ?>"><?php echo $issueDate2 ?></OPTION>


          	<?php
		}
		?>
        	</SELECT>
      </td>
    </tr>
    <tr> 
      <td valign="top">Section: </td>
      <td valign="top"><SELECT name="section">
          <?php 

$sqlQuery = "select id, name from section where id < 6 order by order_flag";

$res = mysql_query ($sqlQuery);

while ($row = mysql_fetch_array($res)) {
	$sectionID = $row["id"];
	$sectionName = $row["name"];

?>
          <OPTION value="<?php echo $sectionID ?>"><?php echo $sectionName ?></OPTION>
          <?php
}
?>
        </SELECT></td>
    </tr>
    <tr> 
      <td valign="top"> Article Priority: </td>
      <td valign="top"> <SELECT name="priority">
          <?php
for($i = 1; $i < 30; ++$i) {
?>
          <OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          <?php
}
?>
        </SELECT> </td>
  </tr>

    <tr> 
      <td valign="top"> Label: </td>
      <td valign="top"> <input type="text" name="label" size="40"> </td>
    </tr>

    <tr> 
      <td valign="top"> Filename: </td>
      <td valign="top"> <input type="text" name="filename" size="40"> <font class="smalltext">(example: doc2.pdf)</font></td>
    </tr>

        </table>
        
      </td>
    </tr>
  </table>
  <p><INPUT type="submit" name="adddocument" value="Add Related Document">
</p>
</FORM>
</BODY>
</HTML>