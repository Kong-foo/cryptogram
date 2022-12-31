<!DOCTYPE html>
<html>
<head>

</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="submit" value="update daily" name="updaily">
<input type="submit" value="update monthly" name="upmonthly">
<input type="submit" value="update yearly" name="upyearly">
<br>
<span>modify daily:</span>
<br>
<input type="text" name="moddaily" value="<?php
$datafile = fopen("daily.txt", "c+") or die("unable to open file.");
fread($datafile, 2);
$dailytext = fread($datafile, filesize($dataname) - 2);
echo $dailytext;
fclose($datafile);
?>">
<input type="submit">
<br>
<span>modify monthly:</span>
<br>
<input type="text" value="">
<input type="submit">
<br>
<span>modify yearly:</span>
<br>
<input type="text" value="">
<input type="submit">
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST['updaily'])) {
$runthisscript = 1;
include("daily.php");
}

if ($_POST['moddaily'] != <?php echo $dailytext ?>) {
alert("you modified daily text.");
}

}
?>


</body>
</html>
