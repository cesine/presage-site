<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>Presage Institute - Faculty</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<LINK href="presage.css" type=text/css rel=stylesheet>
<META content="MSHTML 5.50.4731.2200" name=GENERATOR></HEAD>
<BODY>
<DIV id=wrapper>

<?php
include "top.inc";
?>


<table border=0 width=100%><tr valign=top><td>

<?php
include "side.inc";
?>

</td><td>
<!--Main cell-->
<?php
$host = "localhost";
$user = "kata";
$password = "notthepassword";

$database = "presage";
$table = "faculty";

$today = date("y-m-d H:i:s D");
$connection = mysql_connect($host,$user,$password)
        or die ("Sorry the mysql connection didnt work.");
?>
<?php
phpinfo(); ?>
<br>

<table border=0 cellpadding=0 cellspacing=0><tr valign=top><td height=100% widt
