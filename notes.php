<html><head><title>
cesine - biblio - notes
</title></head>
<?php
//$color1="#bb9988";
//purple $color=array("#333377","#333355");		//purple
$color=array("#8F8F94","#660000","#E6E6EB");		//grey & burgundy
echo "<body 	bgcolor=$color[0]
		text=white>";

/*PAGE INFO
FILENAME: index.php
AUTHOR: cesine
CREATION DATE: sun Nov 2 2003
PURPOSE: access biblio database, used to store notes and texts that i have read
DETAILS: 	-display forms to input new notes, texts and keywords
		-display all notes, texts and keywords
		-add or change notes, texts and keywords
IMPLEMENTATION:	-function to display a form that that gets its info from the database, if new columns are
		 they will be displayed in order they are in the database, with their column names
		-the first entry in a table must be the ID and primary key
		-the most important entry must have the same name as the table, it will be displayed in a row
		 folowing the details.
		-function to display the
			-column heading,
			-form to input new entry (from the displayForm function)
			-display info from the database in this form:
				+------------------------------+
				|ID|detail|detail|detail|detail|
				+------------------------------+
				|# |notevalue..................|
				+------------------------------+
TASKS:	(look in the page for the title of the task to find out where to put the info :)
031102a	-figure out how to make input fields the same size as the columns of the table organizing it
031102b	-figure out how to get the keywordID and textID to display the value of biblio.keyword(keywordIDvalue)
		ex: if the keywordID is 3, display the keyword value for number3 for example, "computer"
*/

$host = "localhost";
$user = "kata";
$password = "notthepassword";

$filename ="notes.php";
$database = "biblio";
$table="note";
$today = date("y-m-d H:i:s D");
$tableBorder="0";
$connection = mysql_connect($host,$user,$password)
        or die ("sorry the mysql connection didnt work");
$dbOpen = mysql_select_db($database,$connection)
        or die ("sorry couldnt open the biblio database");
?>


<?php
//echo $_GET[first]     ;
if ($_GET[first]==no){
//get the names of the columns into an array
        $hold=mysql_query("SELECT * FROM $table", $connection);
        $row=mysql_fetch_row($hold);
        $numberOfColumns=sizeof($row);
        $numberOfColumns=$numberOfColumns-1;            //to add last w/out ,
        $fields="";     //variable to hold column names
        $values="";
        for ($cell=0;$cell<$numberOfColumns;$cell++){
                $colName = mysql_field_name($hold, $cell);
                $fields = $fields." ".$colName." , ";
                $colValue = $_POST[$colName];
                if ($colName=="noteDate"){
                        $colValue=$today;
                }
                $values = $values." \" ".$colValue." \" , ";
        }//end for loop
                $colName = mysql_field_name($hold, $cell);
                $fields = $fields." ".$colName;         //adds last w/out ,
                $colValue = $_POST[$colName];
                $values = $values." \" ".$colValue." \" ";

        $inserted = mysql_query ("INSERT INTO $table ($fields) VALUES ($values)", $connection);
        if ($inserted ==1)
		echo "Entry has been added<p>\n";
}
?>





<?php
//main program
echo "<center><table border=$tableBorder>";
displayHeadings($connection,$table,$tableBorder,$color);
displayForm($connection,$filename,$table,$tableBorder,$color);
echo "</table>";



//display table of old entries
echo "<table border=$tableBorder>";
displayHeadings($connection,$table,$tableBorder,$color);
//displayForm($connection,$filename,$table,$tableBorder,$color2);
displayEntries($connection,$table,$tableBorder,$color);
echo "</table>";
//displayTable($connection,keyword,$tableBorder);
//end main program
?>

<?php
//DECLARATION OF FUNCTIONS

//$table=name of table to draw from
//$userRow=an array to hold user specified order of columns
//$color=an array of colors to use for the page
function displayUserHeadings($connection,$table,$userRow,$colspan,$rowspan,$color){
	$wholeTable = mysql_query("SELECT * FROM $table", $connection);
	$colHeadings = $wholeTable;
	$row = mysql_fetch_row($colHeadings);
	if (!($userRow == ""))						//if there is a userspecified row
			$row = $userRow;
	$numberOfColumns = sizeof($row);
	if (!$colspan)
		$colspan = array_fill(0,$numberOfColumns,"1");
	if (!$rowspan)
		$rowspan = array_fill(0,"$numberOfColumns","1");

	echo "<tr valign=top align=center bgcolor=$color[1]>\n";
	for ($cell=0; $cell<$numberOfColumns; $cell++){
		if (!($userRow == ""))
			$colName = $userRow[$cell];				//starts at 1(skips "ID")
		else
			$colName = mysql_field_name($colHeadings, $cell);
		if ($colName == $table)
			;//do nothing
		else
			echo "<td colspan=$colspan[$cell] rowspan=$rowspan[$cell]><font size=2>",$colName, "</td>\n";
	}//end for
	echo "</tr>\n";
}//end display userdefined headings


function displayUserForm($connection,$table,$userRow,$values,$colspan,$rowspan,$color){
	$wholeTable = mysql_query("SELECT * FROM $table", $connection);
	$colHeadings = $wholeTable;
	$row = mysql_fetch_row($wholeTable);
	if ($userRow){							//if there is a userspecified row
			$row = $userRow;
	}//end if
	$numberOfColumns = sizeof($row);
	if (!$colspan)
		$colspan = array_fill(0,$numberOfColumns,"1");
	if (!$rowspan)
		$rowspan = array_fill(0,"$numberOfColumns","1");
        if (!$values)
		$values = array_fill(0,$numberOfColumns,"");


	echo "<tr align=center valign=top>\n";

	for ($cell=0; $cell<$numberOfColumns; $cell++){			//cell=0 to include the first unit
		if (!($userRow == ""))
			$colName = $userRow[$cell];			//starts at 1(skips "ID")
		else
			$colName = mysql_field_name($colHeadings, $cell);
		$sizeOfInput=strlen($colName);

		if ($colName == $table)
					;//do nothing
		elseif ($colName==keywords){
			echo "<td colspan=$colspan[$cell] rowspan=$rowspan[$cell]>";
			$row = mysql_fetch_row($wholeTable);
			for ($cell2=0; $cell2<=$numberOfColumns; $cell2++){		//for all headings
				$colName = mysql_field_name($colHeadings, $cell2);
				if (ereg("keywordID*",$colName))
					echo "<input
						type='text'
						name='$colName'
						value='$values[$colName]'
						size='$sizeOfInput'><br>\n";
			}//end for
			echo "</td>\n";
		}//end if
		else{
			if (ereg("source",$colName))
                     		$sizeOfInput=80;

			echo "<td colspan=$colspan[$cell] rowspan=$rowspan[$cell]><input
				type='text'
				name='$colName'
				value='$values[$colName]'
				size='$sizeOfInput'></td>\n";
		}//end ifs
	}//end for
	echo "</tr>\n";
}//end display user defined form

function displaySubmitAndMainCell ($connection,$table,$values,$colspan,$color){
	//if (!$colspan)
	//	$colspan = array(1,4);									//will always be 4 no matter how many columns there are if hte user doesnt specifiy a value
	echo "<tr valign=top>";
	echo "<td colspan=$colspan[0]>
		<select name='submit$table'>
		<option value='add$table'><font size=2>Add
		<option value='change$table'>Change
		<option value='remove$table'>Remove
		<option value='checked$table'>Checked
		</select><br>\n
		<font size=4>$table: \n
		<input
		type='submit'
		value='OK'></td>\n";
	echo "<td colspan=$colspan[1]>
		<textarea rows=1 wrap=soft
		name='$table'
		cols=80>$values[$table]</textarea></td>\n";
	echo "</tr>\n";
}//end display submit and main cell
/////////////////////////////////////////////////////userdefined form and headings/////////////////////


function displayForm($connection,$filename,$table,$tableBorder,$color)
{
        $hold=mysql_query("SELECT * FROM $table", $connection);
        $row=mysql_fetch_row($hold);                                    //row to print later
        $numberOfColumns=sizeof($row);                                  //gets the size of the row array
	$colspan=$numberOfColumns-3;

        echo "<tr align=center valign=top><form action='$filename?first=no' method='post'>\n";
	$keywordCell="";
        for ($cell=0;$cell<$numberOfColumns;$cell++){
                $colName = mysql_field_name($hold, $cell);              //dont know why its hold instead of row
                @$prevColName = mysql_field_name($hold,($cell-1));      //an error but works so i turned off w/@
                @$nextColName = mysql_field_name($hold,($cell+1));      //an error but works so i turned off w/@
		$sizeOfInput=strlen($colName);				//031102a find a way to get width of column
		if ($colName == $table)                                 //always name important column after table
                        ;
                elseif (ereg("keywordID*",$colName)){
		        $keywordCell= $keywordCell."<input
                                type='text'
                                name='$colName'
                                value=''
                                size='$sizeOfInput'><br>\n";
		}//end else to make one cell of all keywords
		else
                        echo "	<td><input
				type='text'
				name='$colName'
				value=''
				size='$sizeOfInput'></td>\n";		//031102a
        }//end for loop to make the form details

	echo "<td rowspan=2>$keywordCell</td></tr><tr valign=top bgcolor=$color[1]>\n
		<td colspan=2 align=right><font size=5><b>
		$table:<br><center>
		<select name='submit'>
			<option value='add'>Add
			<option value='change'>Change
			<option value='remove'>Remove
		</select>
		<input	type='submit' value='OK'></td><td colspan=$colspan>
		<textarea rows=3 wrap=soft  name='$table' value='' cols=60/*031102a*/ ></textarea></td>\n
		</tr></form>\n";
}//end displayForm

function displayHeadings($connection,$table,$tableBorder,$color)
{
	//get entries
	$hold=mysql_query("SELECT * FROM $table", $connection);
	$row=mysql_fetch_row($hold);					//row to print later
	$numberOfColumns=sizeof($row);					//gets the size of the row array
	$colspan=$numberOfColumns-3;

	//make a table to organize the output
	echo "<table border=$tableBorder><tr valign=top bgcolor=$color[1] align=center>
		<td>ID</td>";						//must make first column the ID

	//for loop to make the column headings
	for ($cell=1;$cell<$numberOfColumns;$cell++){

		//************this section takes the main value out of the details row*******
		$colName = mysql_field_name($hold, $cell);		//dont know why its hold instead of row
		@$prevColName = mysql_field_name($hold,($cell-1));	//an error but works so i turned off w/@
		@$nextColName = mysql_field_name($hold,($cell+1));      //an error but works so i turned off w/@
		if ($colName == $table)					//always name important column after table
			echo "";					//do nothing ";
                //************this section takes the main value out of the details row*******

		//***************this section puts all keywords into one cell**************
		//elseif (ereg("keywordID*", $colName) and (!ereg("keywordID*", $prevColName)) )
		//	echo "<td>", $colName;
                //elseif (ereg("keywordID*", $colName) and (!ereg("keywordID*", $nextColName)) )
                //      echo " ", $colName, "</td>";
                //elseif (ereg("keywordID*", $colName))
                //      echo " ", $colName;
                //***************this section puts all keywords into one cell**************
 		elseif (ereg("keywordID*",$colName))
			;
		else
			echo "<td><font size=2>",$colName , "</td>";
	}//end for loop to make the column headings
	echo "<td width=100>keywords</td></tr>";
}// end function to display headings

function dislayTextHeadingsAndForm($connection,$tableBorder,$color){//display both mixed together
	//1-9[r|c]fieldName (numberspanned of rows or columns)OB
	$row1headAndForm=array("ID","authorFirst","publishDate","startDate","finishDate","5rkeywords");
	$row2headAndForm=array("3rsubmit","authorLast","publisher","2csource");
	$row3form=array("4c$table");

//	<td colspan=$colspan rowspan=$rowspan>$colName</td>

//	<td colspan=$colspan rowspan=$rowspan>
//	<input
//		type='text'
//		name='$colName'
//		value=''
//		size='$sizeOfInput'></td>\n";'

}// end function to display headings


function displayEntries($connection,$table,$tableBorder,$color){//display existing entries in order of ID
	$hold=mysql_query("SELECT * FROM $table", $connection);	//get hold again cause lost its first member
	$colspan=5;
	while ($row= mysql_fetch_row($hold) ){
		$numberOfColumns = sizeof($row);
		echo "<tr valign=top>";
		$keywordCell="";
		//for loop to print details of an entry
		for ($cell=0;$cell<sizeof($row);$cell++){
                	$colName = mysql_field_name($hold, $cell);
	                $cellValue =$row[$cell];
			if ($colName == $table)
				$mainValue = $row[$cell];		//send the value to be used later
			elseif (ereg(".*(t|T)itle*",$colName))
				echo "<td><b>",$cellValue,"</td>\n";
			//elseif (ereg(".*filename*",$colName))
                        //       echo "<td><a href='$cellValue' target=top>$cellValue</a></td>\n";
			elseif (ereg(".*ID*",$colName) and !(ereg(".*$table",$colName)) ){//replace all IDs with corresponding value 031102b
				if (ereg(".*keyword*",$colName))
					$replace="keyword";
				elseif (ereg(".*text*",$colName))
					$replace="text";		//add other databases here ina elseif statement
				//no else stament for the moment (no logical default that i can thinkof)
				//$cellValue="";//mysql_query("SELECT * FROM keyword WHERE keywordID=1 LIMIT 1", $connection);
				if ($replace=="keyword")
					$keywordCell=$keywordCell.$cellValue." ";//save the keyword for later
				else
					echo "<td>$cellValue</td>";
			}//end elseif
			else
				echo "<td>",$cellValue,"</td>\n";
		}//end for loop to print details of an entry

		//print main value of an entry:
		echo "<td><font size=1>$keywordCell</td></tr>\n
		<tr><td></td><td colspan=$colspan>",$mainValue,"</td>\n
                <tr height=1 bgcolor=$color[2]><td colspan=$numberOfColumns></td></tr>\n";

	}//end while to print existing entries in order of ID
	echo "</tr></table><p>";
}//end function displayTable
?>
</body>
</html>
