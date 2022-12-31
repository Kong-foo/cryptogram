<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cryptograms</title>
<style>
.cell {
width:12px;
margin-right:5px;
font-family: ariel;
}
.cell:focus{
background-color:gray;
color:transparent;
}
#ciphertext, .ciphermore {
letter-spacing:11px;
width:120%;
text-align: center;
font-family: monospace, monospace;
display:block;
font-weight:lighter;
}

table {
border-collapse: separate;
text-indent: initial;
border-spacing:2px;
}

td {
display:table-cell;
}

#parent {
white-space: nowrap;
float:left;
margin-right:12px;
}

</style>
</head>
<body>

<?php


$dataname = "daily.txt";
$dateformat = "d";



$exceptions = [',', '!', ':', ' ', "\'", '[', ']', '.', '"', ';', "\/", "\n", "\r", "—", "(", ")", "~"];
function encipher($string) {
GLOBAL $exceptions;
for ($i = 0; $i < 10; $i++) array_push($exceptions, chr($i+48));
$arr = array();
$newchars = array();
str_replace(array("\r", "\n"), ' ', $string);
for ($i = 0; $i < strlen($string); $i++) {
if (in_array($string[$i], $arr) == false && in_array($string[$i], $exceptions)==false) array_push($arr, $string[$i]);
}
$x = 0;
for ($i = 0; $i < count($arr); $i++) {
do {
$c = rand(65, 90); 
}
while (in_array($c, $newchars) && ($x++)<1000);
$newchars[$i] = $c;
}
//string[strpos($string, $arr[1])] = $newchars[1];
for ($n = 0; $n < count($newchars); $n++) {
for ($i = 0; $i < strlen($string); $i++) {
if ($string[$i] == $arr[$n]) $string[$i] = chr($newchars[$n]);
}
}
return $string;
}

$site = 'http://wikiquote.org/wiki/Wikiquote:Quote_of_the_day';
//$site = 'file:///home/void/cryptogram/Wikiquote_Quote of the day - Wikiquote.mhtml';
/*$curlhandle = curl_init("http://en.wikiquote.org");
$fp = fopen("wiki/Wikiquote:Quote_of_the_day");
curl_setopt($curlhandle, CURLOPT_FILE, $fp);
curl_setopt($curlhandle, CURLOPT_HEADER, 0);
curl_setopt($curlhandle, CURLOPT_RETURNTRANSFER,true);
$html = curl_exec($curlhandle);
echo $html;
curl_close($curlhandle);
*/
$text = "there was an error!";
function getquote() {
GLOBAL $site;
GLOBAL $text;
$html = file_get_contents($site);
$matches = array();
$mat = '/(?s)<td>(.+)<\/td><\/tr>/i';
preg_match($mat, $html, $matches);
$text = $matches[1];
$text = str_replace('</td>', '', $text);
$text = str_replace('<br>', '', $text);
$text = preg_replace('/<td.+>/', '', $text);
$text = preg_replace('/<\/a>/', '', $text);
$text = preg_replace('/(?s)<a.+?>/', '', $text);
$text = preg_replace('/<\/tr>/', '', $text);
$text = preg_replace('/(?s)<\/tbody>.+/', '', $text);
$text = preg_replace('/<tr>/', '', $text);
}

/*$text = <<<'EOT'
In his arms, my lady lay asleep, wrapped in a veil.
He woke her then and trembling and obedient
She ate that burning heart out of his hand;
Weeping I saw him then depart from me.
Chapter I, First Sonnet (tr. Mark Musa)
EOT;
*/


$datafile = fopen($dataname, "c+") or die("unable to open file.");

$today = date($dateformat,time());
$savedday = fread($datafile, 2);
if ($savedday == false || $savedday <= 1 || $today != $savedday) {
$finaltext = "";
$encrtext = "";
$c = 0;
getquote();
for ($i = 0, $s=strlen($text); $i < $s && $c<=1; $i++) {
$finaltext[$i] = $text[$i];
if (($text[$i] =='.' && $text[$i-1]!='.') || $text[$i] == '?')$c++;
}
$finaltext = strtolower($finaltext);
fseek($datafile, 0, SEEK_SET);
fwrite($datafile, $today);
fwrite($datafile, $finaltext);
ftruncate($datafile, strlen($finaltext)+2);
}
else {
$finaltext = fread($datafile, filesize($dataname) - 2);

}

fclose($datafile);



$encrtext = encipher($finaltext);

if ($runthisscript) die();
?>


<div id="parent">
<table border="0" cellspacing="2" cellpadding="0">
<tbody id="tb">

</tr>
</tbody>
</table>
</div>
<script>
function setCharAt(str,index,chr) {
    if(index > str.length-1) return str;
    return str.substring(0,index) + chr + str.substring(index+1);
}

function encipher(string) {
let arr = [];
let newchars = [];
for (let i = 0; i < string.length; i++) {
if (arr.indexOf(string[i]) < 0 && string[i] != ',' && string[i] != '!' && string[i] != ' ' && string[i] != '\'') arr.push(string[i]);
}
for (let i = 0; i < arr.length; i++) {
do {
c = String.fromCharCode(Math.floor(Math.random() * 26) + 65); }
while (newchars.indexOf(c) >= 0);
newchars[i] = c;
}
string[string.indexOf(arr[1])] = newchars[1];
for (let n = 0; n < newchars.length; n++) {
for (let i = 0; i < string.length; i++) {
if (string.charAt(i) == arr[n]) string= setCharAt(string, i, newchars[n]);
}
}
return string;
}

let phrase = `<?php echo $finaltext?>`;
let ciphtext = `<?php echo $encrtext; ?>`;
//let ciphid = document.getElementById("ciphertext");
let ciphmore = [];
let inp = [];
let td = [];
let tr = [];
let index = 0;


let i = 0;
let exceptions = <?php echo json_encode($exceptions);?>;
for (let g = 0; index < ciphtext.length; g++) {
let n = 8; while (ciphtext[index+n] && ciphtext[index+(++n)] != " " && ciphtext[index+n] != "\f" && ciphtext[index+n] != "\r" && ciphtext[index+n] != "\n");
if (ciphtext.length - index <= 8) n = ciphtext.length - index;
tr[g] = document.createElement("tr");
for (let i = 0; i < n; i++) {
td[index] = document.createElement("td");
ciphmore[index] = document.createElement("h2");
ciphmore[index].innerHTML = ciphtext[index];
ciphmore[index].classList.add("ciphermore");
td[index].appendChild(ciphmore[index]);
if (i == 0 && ciphtext[index] == " ") { index++; continue;}
inp[index] = document.createElement("input");
inp[index].maxLength = 1;
inp[index].onfocus = highlightall;
inp[index].classList.add("cell");
td[index].appendChild(inp[index]);
if (ciphtext[index] == " ") inp[index].style.visibility="hidden";
td[index].valign="top";
td[index].align="center";


if (exceptions.indexOf(ciphtext[index]) >= 0) inp[index].style.visibility = 'hidden';
if (ciphtext[index] == "\n") inp[index].parentElement.style.display = "none";


tr[g].appendChild(td[index]);
//if (ciphmore[index].innerHTML == " " && typeof(inp[index]) !== 'undefined') inp[index].style.color = 'red';
index++;
}
document.getElementById("tb").appendChild(tr[g]);
}

var container = document.getElementsByClassName("cell");

for (let i = 0; i < container.length; i++) {
container[i].onkeydown = function(e) {
if (e.keyCode >= 65 && e.keyCode < 122 || e.keyCode == 8) {
e.srcElement.value = String.fromCharCode(e.keyCode);
if (e.srcElement.parentElement.nextElementSibling) {
let next = e.srcElement.parentElement.nextElementSibling.children[1];
//while (next.style.visibility == "hidden" && next.parentElement.nextElementSibling) next = next.parentElement.nextElementSibling.children[1];
for (let g = 0; g < container.length; g++) if (e.srcElement.parentElement.children[0].innerHTML == container[g].parentElement.children[0].innerHTML) container[g].value = e.srcElement.value;

while (next.value.charCodeAt(0) >= 65 || next.style.visibility=="hidden") {
if (nextt=next.parentElement.nextElementSibling) next = nextt.children[1];
else if (nextt=next.parentElement.parentElement.nextElementSibling) next = nextt.children[0].children[1];
else break;
}
if (next.value < 65) next.value = " ";
next.focus();
}
else if ((nextr=e.srcElement.parentElement.parentElement.nextElementSibling)) {
let nextt=nextr.children[0].children[1];
for (let g = 0; g < container.length; g++) if (e.srcElement.parentElement.children[0].innerHTML == container[g].parentElement.children[0].innerHTML) container[g].value = e.srcElement.value;
if (nextt.value < 65)
nextt.value = " ";
else {
while (nextt.value.charCodeAt(0) >= 65 || nextt.style.visibility=="hidden") {
if (nextt=nextt.parentElement.nextElementSibling) nextt = nextt.children[1];
else if (nextt=nextt.parentElement.parentElement.nextElementSibling) nextt = nextt.children[0].children[1];
else break;
}
}
nextt.focus();
}
}
}
}

function check() {
let n = 0;
let wrong = 0;
for (let i = 0; i < container.length; i++) {
if ((phrase[n] == " " || phrase[n] == ".") && !(container[i-1].parentElement.nextElementSibling)) n++;
if (container[i].value.toLowerCase() != phrase[n] && container[i].style.visibility!="hidden") {container[i].style.backgroundColor = "red";wrong++}
else container[i].style.backgroundColor = "white";
n++
}
if (wrong == 0) for (let i = 0; i < container.length; i++) container[i].style.backgroundColor = "green";
}

function highlightall(x) {
let letter = x.target.parentElement.children[0].innerHTML;
for (let i = 0; i < container.length; i++) {
let lettern = container[i].parentElement.children[0].innerHTML;
if (lettern == letter) container[i].style.backgroundColor="#B0B0B0";
else container[i].style.backgroundColor="white";
}
}
</script>
<button onclick="check()">check</button>
</body>
</html>
