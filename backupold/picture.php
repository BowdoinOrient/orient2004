<?php
include("start.php");
# but don't call startcode.

$page = $_GET["page"];
if(strcmp($page, "") == 0) {
	$page = 1;
}

# need photo filename.  
if($pictureWindow == true) {
$sqlQuery = "
	select
		p.large_filename,
		p.caption,
		a.name as photographer,
		p.credit,
		a.id
	from
		photo p,
		author a
	where
		p.photographer = a.id and
		p.article_date = '$date' and
		(
		(
		p.article_priority = '$priority' and
		p.article_section = '$section' and
		p.article_section != 0 
		)
		or 
		(
		$section = 0 and
		p.article_section = 0 and
		p.feature = 'y' and
		p.feature_section = '$featureSection'
		)
		)
	order by
		p.article_photo_priority
";
}

elseif(strcmp($slideshowID, "") != 0) {
$sqlQuery = "
	select
		p.large_filename,
		p.caption,
		a.name as photographer,
		p.credit,
		a.id
	from
		photo p,
		author a
	where
		p.photographer = a.id and
		p.article_date = '$date' and
		p.slideshow_id = '$slideshowID'
	order by
		p.slideshow_photo_priority
";
}

elseif($photographerWindow == true) {
$sqlQuery = "

	SELECT p.large_filename,
       		p.caption,
       		a.name AS photographer,
       		p.credit,
       		p.article_date,
		a.id
	FROM author a,
		photo p
	WHERE 
   		(
      			(p.photographer = a.id)
   		and 
      			(p.photographer = '$photographerID')
   		)
	ORDER BY p.article_date DESC
";
}

else { // all photos from issue
$sqlQuery = "
	select
		p.large_filename,
		p.caption,
		a.name as photographer,
		p.credit,
		a.id
	from
		photo p,
		author a
	where
		p.photographer = a.id and
		p.article_date = '$date' and
		p.slideshow_id = '0'
";
}


$res = mysql_query($sqlQuery);

$numberOfRows = mysql_num_rows($res);

# data verification. make sure page is in range. should never get here.  
if($page > $numberOfRows || $page < 1) { $page = 1; }


for($i = 1; $i < $page; ++$i) {
	mysql_fetch_array($res);
}

if($row = mysql_fetch_array($res)) {

	$photo = $row["large_filename"];
	$photographerID = $row["id"];
	$caption = $row["caption"];
	$photographer = $row["photographer"];
	if(strcmp($photographer, "") != 0) {
		$photographer = "$photographer, Bowdoin Orient";
		$photographerlink = true;
	}
	$credit = $row["credit"];
	$articlephotodate = $row["article_date"];

	$photoCredit = "$photographer$credit";



}

$nextPage = $page + 1;
$previousPage = $page - 1;
$showNextPage = true;
$showPreviousPage = true;
if($page == $numberOfRows) {
	$showNextPage = false;
}


if($page == 1) {
	$showPreviousPage = false;
}

if($pictureWindow == true) {
	$thisPageLink = "picturewindow.php";
}
elseif($slideshowWindow == true) {
	$thisPageLink  = "slideshowwindow.php";
}
else {
	$thisPageLink  = "photographerwindow.php";
}


#set links.


	$nextPageLink = "$thisPageLink?photographerid=$photographerID&slideshowid=$slideshowID&featuresection=$featureSection&section=$section&date=$date&id=$priority&page=$nextPage";
	$previousPageLink = "$thisPageLink?photographerid=$photographerID&slideshowid=$slideshowID&featuresection=$featureSection&section=$section&date=$date&id=$priority&page=$previousPage";




?>

<!-- probably want to start and stopify this page too.  for slideshows and so on. -->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>The Bowdoin Orient - Pictures</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="picture.css" rel="stylesheet" type="text/css">
</head>

<body leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">


  
<div align="center"> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#003366">
    <tr>
      <td height="50"><div align="center"><img src="images/minilogo.jpg" align="middle"></div></td>
    </tr>
  </table>

<table width="100%" border="0" cellpadding="0" cellspacing="5">
<tr><td><div align="right"><font class="closewindow"><a href="javascript:void(window.close())" class="closewindow">Close 
            Window</a></font></div></td></tr></table>



  <div align="center"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><div align="center"><font class="picturenav">
<?php
if($showPreviousPage == true) {
?>
<a class="picturenav" href="<?php echo $previousPageLink ?>">&lt;&lt; 
            Previous Picture</a> | 
<?php
}
?>
<?php if($numberOfRows != 1) { ?>
<?php echo $page ?> of <?php echo $numberOfRows ?>
<?php } ?>
<?php 
if($showNextPage == true) {
?>
 | <a class="picturenav" href="<?php echo $nextPageLink ?>">Next 
            Picture &gt;&gt;</a>
<?php
}
?>
</font></div></td>
      </tr>
    </table>

  </div>




  <table class="picturetable" width="1" border="0" cellspacing="0" cellpadding="0">
<tr> 

  <table width="1" border="0" cellspacing="0" cellpadding="0">

      <tr> 
      <td height="20"></td>
    </tr>
    <tr> 
    <tr> 
      <td>

<div align="center">


<?php

if($photographerWindow == true) { ?>

	<img src="images/<?php echo "$articlephotodate/$photo" ?>" border="1">
<?php
}


else { ?>

	<img src="images/<?php echo "$date/$photo" ?>" border="1">
<?php
}

?>





</div></td>
    </tr>









    <tr> 
      <td><div align="right">

	<?php
	if($photographerlink == true) {
	?>

	<a class="photocredit" href="/orient/authorpage.php?authorid=<?php echo $photographerID ?>" target="_blank">

	<?php
	}
	?>

	<font class="photocredit"><?php echo $photoCredit ?></font>

	<?php
	if($photographerlink == true) {
	?>

	</a>

	<?php
	}
	?>

	</div></td>
    </tr>
    <tr> 
      <td height="3"></td>
    </tr>





    <tr> 
      <td align="right"><font class="photodate">Published: 


<?php

if($photographerWindow == true) {

echo $articlephotodate;

}

else {

echo $articleDate;

}

?>

	</font></td>
    </tr>

    <tr> 
      <td height="3"></td>
    </tr>


    <tr> 
      <td><font class="photocaption"><?php echo $caption ?></font></td>
    </tr>


    <tr> 
      <td height="25"></td>
    </tr>


  </table>

</tr>
</table>




</div>
</body>
</html>
