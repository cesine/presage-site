
<?php 
$filename="{$_SERVER['PHP_SELF']}";
$today = date("y-m-d H:i:s D");
$table= "address"
?>

<form action=<?php echo "$filename?table=$table"?> method=post>
<table><tr><td>        
Current Address:
</td><td>
</td></tr><tr><td>
Num: (leave null)
</td><td>
<input size=20 name=num><br>
</td></tr><tr><td>
Street:
</td><td>
<input size=20 name=street><br>
</td></tr><tr><td>
Town:
</td><td>
<input size=20 name=town><br>
</td></tr><tr><td>
City:
</td><td>
<input size=20 name=city><br>
</td></tr><tr><td>
Province:
</td><td>
<input size=20 name=province><br>
</td></tr><tr><td>
Code:
</td><td>
<input size=20 name=code><br>
</td></tr><tr><td>
Country:
</td><td>
<input size=20 name=country><br>
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
<INPUT type=submit value=Next>
</td></tr><tr><td>

</td></tr></table>
</form>
