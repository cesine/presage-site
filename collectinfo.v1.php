<html>

<?php 
$filename="{$_SERVER['PHP_SELF']}";
$today = date("y-m-d H:i:s D");

?>
<form action=<?php echo "$filename?first=no"?> method=post>
<table><tr><td>        
Num: (leave null)
</td><td>
<INPUT size=1 name=num><br>
</td></tr><tr><td>
Id:
</td><td>
<INPUT size=16 name=id><br>
</td></tr><tr><td>
Password:
</td><td>
<INPUT size=20 name=password><br>
</td></tr><tr><td>
First Name:
</td><td>
<INPUT size=16 name=firstName><br>
</td></tr><tr><td>
Father's Name:
</td><td>
<input size=16 name=fathersName><br>
</td></tr><tr><td>
Last Name:
</td><td>
<input size=16 name=lastName><br>
</td></tr><tr><td>
Gender:
</td><td>
<select name=gender>
<option value=m>M
<option value=f>F
</select><br>
</td></tr><tr><td>
Birthdate YYYY-MM-DD:
</td><td>
<input size=20 name=birthdate><br>
</td></tr><tr><td>
Email:
</td><td>
<input size=50 name=email><br>
</td></tr><tr><td>
Home Phone:
</td><td>
<input size=20 name=homePhone><br>
</td></tr><tr><td>
Work Phone:
</td><td>
<input size=20 name=workPhone><br>
</td></tr><tr><td>
Fax Number:
</td><td>
<input size=20 name=fax><br>
</td></tr><tr><td>
Cell Phone:
</td><td>
<input size=20 name=cellPhone><br>
</td></tr><tr><td>
Current Address:
</td><td>
<input size=20 name=currentAddress><br>
</td></tr><tr><td>
Permanent Address:
</td><td>
<input size=20 name=permanentAddress><br>
</td></tr><tr><td>
Create Date:
</td><td>
<input size=20 name=createDate value="<?php echo $today?>"><br>
</td></tr><tr><td>
Cancel Date: (leave null)
</td><td>
<input size=20 name=cancelDate><br>
</td></tr><tr><td>
Notes:
</td><td>
<input type=text name=modifiedNotes><br>
</td></tr><tr><td>
<INPUT type=submit value=Submit>
</td></tr><tr><td>

</td></tr></table>
</form>

<?php
if ($_GET[first]==no){

#echo"gets first is $_GET[first]\n";

#echo "posts firstname is $_POST[firstName]\n";
#echo "$_POST[userid]\n";

#	$array = array("1","2","3");
	foreach ($_POST as $key => $value) {
		echo "$key: $value<br/>\n";
	}#endforeach
	$outputfile="users/newdata.txt";
	$output = fopen($outputfile , "a" );
	if (!$output){
		echo "User '$_POST[userid]' already exists, no information saved. Please try to submit the information again with a differnt username.";
	}else{
		echo "User information will be saved in $outputfile";
	}#endif

	#print userinfo as tab delimited text file                             
        foreach ($_POST as $key => $value) {
		echo "$value\t";
		$toprint="$value\t";
		fwrite ($output , $toprint);
	}#foreach
	echo "\n";
	$toprint="\n";
	fwrite($output, $toprint);
	fclose($output);
}
?>
</html>
