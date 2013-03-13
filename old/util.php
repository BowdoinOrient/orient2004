<?php
function removeText($theString, $stuffToRemove) {

	$a = explode($stuffToRemove, $theString);
	$b = implode("", $a);
	return $b;

}
function removeLastWord($theString) {
	$a = explode(" ", $theString);
	array_pop($a);
	$b = implode(" ", $a);
	return $b;
}
?>