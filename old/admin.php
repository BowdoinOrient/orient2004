<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Staff and Writers", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<h2>Administrative Tasks</h2>
<ul>
<li><a href="editphoto.php">Edit a photo</a></li>
<li><a href="editarticle.php">Edit an article</a></li>
<li><a href="settings.php">Edit Settings</a></li>
<li><a href="new.php">Add new issue</a></li>
</ul>

<?php
include("stop.php");
?>