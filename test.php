<?php
$name = "<b>PEak</b>";
$name = "9033024846";


// echo filter_var($name, FILTER_SANITIZE_STRING);


// if($name != strip_tags($name)) {
	// echo "Found";
// } else {
	// echo "False";
// }

if(!is_numeric($name)) {
	echo "Invalid Number";
} else {
	echo "Valid Number";
}
?>