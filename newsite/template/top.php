<?php
// Internet Explorer 6 cannot display pages correctly.
$ie6 = "MSIE 6.0";
if (strpos($_SERVER['HTTP_USER_AGENT'], $ie6) !== false) {
	$pieces = split("/", $_SERVER['SCRIPT_URL'], 3);
	$path = $pieces[2];
	$url = "http://orient.bowdoin.edu/orient/old/$path";
	header("Location: $url");
}

include("../dbconnect.php");
include("../util.php");
include("../getcurrentdate.php");

$date = mysql_real_escape_string($_GET['date']);
$section = mysql_real_escape_string($_GET['section']);
$priority = mysql_real_escape_string($_GET['id']);
$authorID =  mysql_real_escape_string($_GET['authorid']);
$seriesID = mysql_real_escape_string($_GET['seriesid']);
$featureSection = mysql_real_escape_string($_GET['featuresection']);

if(strcmp($date, "") == 0)
	$date = $currentDate;

if(strcmp($section, "") == 0)
	$section = 1;

if(strcmp($priority, "") == 0)
	$priority = 1;

include("../issuequery.php");

include("functions.php");

function startPage() {
	global $title, $volumeNumber, $issueNumber, $date, $section, $priority, $articleDate;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title><?php echo $title; ?></title>

  <!-- Framework CSS -->
	<link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">
  <!--[if IE]><link rel="stylesheet" href="../../blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
	
	<!-- Import fancy-type plugin for the sample page. -->
	<link rel="stylesheet" href="css/blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">
	<link rel='stylesheet' href='css/nyroModal.css' type='text/css' media='screen, projection'>
	<link rel='stylesheet' href='css/lightbox.css' type='text/css' media='screen, projection'>
	<link rel="stylesheet" href="css/orient.css" type="text/css" media="screen, projection">
	<script type='text/javascript' src='js/jquery.js'></script>
	<script type='text/javascript' src='js/nyroModal.js'></script>
	<script type='text/javascript' src='js/lightbox.js'></script>
	<script type='text/javascript' src='js/jeditable.js'></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$(".modal").nyroModal();
			$("a.lightbox").lightbox();
			editable();
			setTimeout(setMainDivsEqual, 250);
		});
		
		function setMainDivsEqual() {
			for (var i = 1; i < 6; i++) {
				equalHeight($(".type" + i));
			}

		}
		
		function equalHeight(group) {
			tallest = 0;
			group.each(function() {
				thisHeight = $(this).height();
				if (thisHeight > tallest) {
					tallest = thisHeight;
				}
			});
			group.height(tallest);
		}
		
		function addTerm(term) {
			$("input[name=q]").val($("input[name=q]").val() + " " + term);
		}
		
		function editable() {
			return;
			$('.edit').editable('http://www.example.com/save.php', {
				event: 'dblclick',
				style: " "
			});
			$('.edit_area').editable('http://www.example.com/save.php', { 
				type      : 'textarea',
				cancel    : 'Cancel',
				submit    : 'Save',
				style: "height: 50px;",
				tooltip   : 'Double Click to edit...',
				event	   : 'dblclick'
			});
		}
		function togglebg() {
			if ($('body')[0].getAttribute('bg') == 'white') {
				$('body')[0].style.background = '#657E8D url(http://sethglickman.com/drupal/themes/bowdoin/images/bg-wide.gif) repeat scroll 0 0';
				$('.maincontainer')[0].style.border = "2px solid #516378";
				$('body')[0].setAttribute('bg', 'colored');
			} else {
				$('body')[0].style.background = "#FFF";
				$('.maincontainer')[0].style.border = "2px solid #ccc";
				$('body')[0].setAttribute('bg', 'white');
			}
		}
		function rs(n,u,w,h) 
		{
			remote = window.open(u, n, 'width=' + w + ',height=' + h +',resizable=yes,scrollbars=yes');
			
			if(remote != null) 
			{
				if(remote.opener == null)
					remote.opener = self;
				
				remote.location.href = u;
			}
					
			remote.focus();
		}
		
		function showComments() {
			$("#view-comments").hide("normal");
			$("#comments").show("fast");
		}
		
		function submitComment() {
			username = $("#username").val();
			password = $("#password").val();
			comment = $("#comment").val();
			var url = "ajaxaddcomment.php";
			var ardate = '<?php echo $date; ?>';
			var section = '<?php echo $section; ?>';
			var priority = '<?php echo $priority; ?>';
			var data = {
				"username": username,
				"password": password,
				"comment": comment,
				"id": priority,
				"section": section,
				"date": ardate
			};
			$.post(url, data, commentSubmitted, "text");
			showComments();
		}
		
		function commentSubmitted(data) {
			if (data.substring(0, 9) == "Success: ") {
				// If they've done more than one comment, remove the 'edit' link on the older one, and make it normal.
				if ($("#new-comment")) {
					$("#new-comment").removeClass('newcomment').attr("id","");
					$("#editlink").text("Report").attr("onclick",'reportComment(this); return false;');
				}
				var numbers = data.substring(9);
				commentID = numbers.substring(0,numbers.indexOf(","));
				commentSecret = numbers.substring(numbers.indexOf(",") + 1);
				var commentDiv = document.createElement("div");
				commentDiv.setAttribute("class", "comment hide newcomment");
				commentDiv.setAttribute("id", "new-comment");
				commentDiv.setAttribute("commentid", commentID);
				commentDiv.setAttribute("secret", commentSecret);
				var user = "<p class='bottom'>" + username + "<\/p>";
				user = "<p class='bottom edit'><a href='mailto:" + username + "@bowdoin.edu'>" + username + "<\/a>: (just now)<\/p>";
				var content = "<p class='bottom edit_area'>" + comment + "<\/p>";
				// "<span class='edit-text'><br />Double-click to edit text<\/span><\/p>";
				var editLink = "<a id='editlink' class='commentaction' href='#' onclick='reportComment(this); return false;'>Report<\/a>";
				commentDiv.innerHTML = editLink + user + content;
				hideError();
				$("#nocomments").hide("fast");
				$("#comments").append(commentDiv);
				$("#new-comment").show("normal");
				$("#comment").val("");
				editable();
			} else {
				$("#comment-error").text(data);
				$("#comment-error").show("normal");
			}
		}
		
		function hideError() {
			$("#comment-error").hide("normal");
		}
		
		function reportComment(link) {
			if (!$(link.parentNode).attr("commentid")) {
				return;
			}
			var commentID = $(link.parentNode).attr("commentid");
			$(link.parentNode).text("You have reported this comment.  If deemed offensive, it will be removed.").addClass("reported");
			var url = "ajaxreportcomment.php";
			var data = {
				"commentID": commentID,
				"date": "<?php echo $date; ?>",
				"section": "<?php echo $section; ?>",
				"priority": "<?php echo $priority; ?>"
			}
			$.post(url, data, commentReported, "text");
		}
		
		function removeComment(link) {
			if (!$(link.parentNode).attr("commentid")) {
				return;
			}
			var commentID = $(link.parentNode).attr("commentid");
			$(link.parentNode).addClass("reported");
			var url = "ajaxremovecomment.php";
			var password = prompt("Password");
			var data = {
				"commentID": commentID,
				"date": "<?php echo $date; ?>",
				"section": "<?php echo $section; ?>",
				"priority": "<?php echo $priority; ?>",
				"pwd": password
			}
			$.post(url, data, commentRemoved, "text");
		}
		
		function commentReported(data) {
			return;
		}
		
		function commentRemoved(data) {
			if (data.substring(0, 5) == "Error") {
				alert(data);
				return;
			}
			$("[commentid=" + data + "]").hide("normal");
		}
		
		function editComment(link, secret) {
			var commentDiv = $(link.parentNode);
			var editDiv = $("<?php editCommentForm; ?>");
			editDiv.attr("commentid", commentDiv.attr("commentid"));
			editDiv.attr("secret", commentDiv.attr("secret"));
			var username = commentDiv.children("a").text();
			var email = "";
			if (commentDiv.children("a").attr("href")) {
				email = commentDiv.children("a").attr("href");
			}
			var c = commentDiv.children("p")[1].innerHTML;
			editDiv.children("#editusername").text(username);
			editDiv.children("#editemail").text(email);
			editDiv.children("#editcomment").text(c);
			commentDiv.html(editDiv.html());
		}
		
		function submitEdit() {
			
		}
	</script>
	<script type='text/javascript'>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
	
	
</head>

<body>

<div class='container maincontainer'>

		<p class='bottom'><h1 class='banner-alt'>The Bowdoin Orient</h1><a href='index.php'><img id='banner' src='images/banner.png' alt='The Bowdoin Orient' width='950px' /></a></p>
		
		<!-- Header -->
		<div class="span-8">
			<!-- Google Custom Search -->
			<form action="searchresults.php" id="cse-search-box">
				<div>
					<input type="hidden" name="cx" value="013877420925418038085:puwwqemrwqe" />
					<input type="hidden" name="cof" value="FORID:11" />
					<input type="hidden" name="ie" value="UTF-8" />
					<input type="text" name="q" size="31" />
					<input style="margin-left: 5px;" type="submit" name="sa" value="Search" />
				</div>
			</form>
			<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&lang=en"></script>
		</div>

		<div class="span-7 prepend-9 last">
		  <p class='issueno'><span class='caps'>Volume <?php echo $volumeNumber; ?>, Number <?php echo $issueNumber; ?></span><br />
		  &nbsp;<span class='caps'><?php echo $articleDate; ?></span></p>
		</div>
		
		<hr />
		<!-- End header -->
<?php } ?>