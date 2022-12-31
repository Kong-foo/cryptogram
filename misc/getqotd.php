<?php

function encipher($string) {
$exceptions = [',', '!', ':', ' ', "\'", '[', ']', '.', '"', ';', "\n", "\/"];
for ($i = 0; $i < 10; $i++) array_push($exceptions, chr($i+48));
$arr = array();
$newchars = array();
for ($i = 0; $i < strlen($string); $i++) {
if (in_array($string[$i], $arr) == false && in_array($string[$i], $exceptions)==false) array_push($arr, $string[$i]);
}
for ($i = 0; $i < count($arr); $i++) {
do {
$c = rand(65, 90); 
}
while (in_array($c, $newchars));
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
$site = 'file:///home/void/cryptogram/Wikiquote_Quote of the day - Wikiquote.mhtml';
/*$curlhandle = curl_init("http://en.wikiquote.org");
$fp = fopen("wiki/Wikiquote:Quote_of_the_day");
curl_setopt($curlhandle, CURLOPT_FILE, $fp);
curl_setopt($curlhandle, CURLOPT_HEADER, 0);
curl_setopt($curlhandle, CURLOPT_RETURNTRANSFER,true);
$html = curl_exec($curlhandle);
echo $html;
curl_close($curlhandle);*/
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

$text = <<<'EOT'
In his arms, my lady lay asleep, wrapped in a veil.
He woke her then and trembling and obedient
She ate that burning heart out of his hand;
Weeping I saw him then depart from me.
Chapter I, First Sonnet (tr. Mark Musa)


EOT;
$finaltext = "";
$c = 0;
for ($i = 0, $s=strlen($text); $i < $s && $c<=1; $i++) {
$finaltext[$i] = $text[$i];
if (($text[$i] =='.' && $text[$i-1]!='.') || $text[$i] == '?')$c++;
}

echo encipher($finaltext) . "\n";

?>
