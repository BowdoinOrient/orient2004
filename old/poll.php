<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("Title Here", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->

<?php
include_once "/studorgs/www/htdocs/orient/poll/booth.php";
echo $php_poll->poll_process("newest");
?>



<!-- Stop -->

<?php
include("stop.php");
?>