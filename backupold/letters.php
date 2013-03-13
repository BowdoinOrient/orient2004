<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Send a letter to the editors", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->

<font class="pagetitle">Send a letter to the editor</font>

<p><font class="textbold">Letter requirements</font>

<font class="text"><ol>
<li>Letters should be recieved by 7:00 p.m. on the Wednesday of the week of publication.</li>
<li>Letters must be signed. We will not publish unsigned letters.</li>
<li>Letters should not exceed 200 words.</li>
</ol></font>

<p><font class="textbold">Ways to send a letter to the editor</font>

<font class="text"><ol>
<li>Fill out our online <a href='javascript: rs("ss","/orient/sendletter.php",700,600);'>letter submission form</a>.</li>
<li>Email a letter to the <a href="mailto:orientopinion@bowdoin.edu">opinion editor</a> in Microsoft Word format.</li>
</ol></font>



			
<!-- Stop -->

<?php
include("stop.php");
?>