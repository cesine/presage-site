<?php
#this file writes all values for _POST to a text file, if the variable "table" has been passed in by the url. the data is tab delimited


$filename="{$_SERVER['PHP_SELF']}";
$today = date("y-m-d H:i:s D");
$table= "$_GET[table]";

#if table is defined then proces the _POST variable
if ($_GET[table]){

#echo "gets first is $_GET[first]\n";

#echo "posts firstname is $_POST[firstName]\n";
#echo "$_POST[userid]\n";

#	$array = array("1","2","3");
#	foreach ($_POST as $key => $value) {
#		echo "$key: $value<br/>\n";
#	}#endforeach
	$outputfile="newdata/$table.txt";
	$output = fopen($outputfile , "a" );
	if (!$output){
		echo "Outputfile could not be opened for writing. Information was not saved.";
	}else{
		#echo "User information will be saved in $outputfile";
	}#endif

	#print userinfo as tab delimited text file                             
	echo "<p>\n";
	foreach ($_POST as $key => $value) {
		#echo "$value\t";
		$toprint="$value\t";
		fwrite ($output , $toprint);
	}#foreach
	echo "\n";
	$toprint="\n";
	fwrite($output, $toprint);
	fclose($output);
}
?>

