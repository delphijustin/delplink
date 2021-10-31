<?php header("Content-type: text/plain");
$short=str_replace("/","_",$_GET["n"]);
$short=str_replace(".","_",$short);
$short=str_replace("\\","_",$short);
$short=str_replace('"',"_",$short);
$short=str_replace("'","_",$short);
$trys=0;
if(is_dir($short)){
	while(is_dir($short.$trys))$trys++;
	$short .= $trys;
}
echo $short;?>
