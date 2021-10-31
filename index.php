<?php include 'dlConfig.php';?>
<!doctype html>
<html>
<head>
<title>delplink link shortener and code uploader</title>
  <meta charset="UTF-8">
  <meta name="description" content="delplink linkk shortner and code uploader">
  <meta name="keywords" content="delplink,link shortener,pastebim,pastebim alternative,code uploads,code sharing">
  <meta name="author" content="Justin Roeder">
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous"></script>
<script>
var lastVisitCount="0";
var visitrequest=0;
function startup(){
	<?php 
	if(strlen($_POST["n"])==0&&$_SERVER["SERVER_PORT"]==80&&(1*$_GET["http"])==0){?>
	location.protocol = "https:";<?php }else{?>
	new ClipboardJS('.cbbtn');
	getVisits();<?php }?>
}
var visiturl="";
function getVisits(){
	visitrequest++;
	$.get(visiturl+visitrequest,function(data,status){
		document.getElementById("visits").innerText=data;
		if(data!=lastVisitCount){
			lastVisitCount=data;
			document.getElementById("visitaudio").play();
		}
	});
}
function typeClick(t){
document.getElementById("type"+t).checked = true;
}
</script>
<script src="/delplink.js"></script>
<link rel="stylesheet" href="/delplink.css">
</head>
<body onload="startup()"><tt><pre onclick="logoClick()" id="delplinklogo" title="Click here to upload links or codes">
         _/            _/            _/  _/            _/                                          
    _/_/_/    _/_/    _/  _/_/_/    _/      _/_/_/    _/  _/        _/    _/  _/    _/  _/_/_/_/   
 _/    _/  _/_/_/_/  _/  _/    _/  _/  _/  _/    _/  _/_/            _/_/    _/    _/      _/      
_/    _/  _/        _/  _/    _/  _/  _/  _/    _/  _/  _/        _/    _/  _/    _/    _/         
 _/_/_/    _/_/_/  _/  _/_/_/    _/  _/  _/    _/  _/    _/  _/  _/    _/    _/_/_/  _/_/_/_/      
                      _/                                                        _/                 
                     _/                                                    _/_/                    
</pre></tt><audio id="visitaudio">
<source src="/visit.ogg" type="audio/ogg">
<source src="/visit.mp3" type="audio/mpeg">
<source src="/visit.wav" type="audio/wave">
</audio>
<?php if(strpos($_POST["w"],"'")!==false||strpos($_POST['w'],'"')!==false)
{die("links cannot have qoutes</body></html>");}
if($_POST['t']>0){?><span id="visits"></span> visit(s)<br><?php }
$deletefile="delete-".sha1("delete".var_export($_POST,true).var_export($_SERVER,true)).".php";
$pageowner=dechex(crc32("editor".var_export($_POST,true).var_export($_SERVER,true)));
function createWWW($URL){
	return '<?php $count=(1*file_get_contents("count.txt"))+1;file_put_contents("count.txt",$count);header("Location: '.$URL.'");/* '.$_SERVER["REMOTE_ADDR"].' */?>';
}
switch($_SERVER["SERVER_PORT"]*1){
	case 80:echo '<p>You are using an decrypted connection. <a href="https://'.$_SERVER['HTTP_HOST'].'">Click here to use secure https</a></p>';break;
	case 443:echo '<p>You are using the safe encrypted connection. <a href="http://'.$_SERVER['HTTP_HOST'].'/?http=1">Click here to use decrypted http</a></p>';break;
}?>
<form method="post" enctype="multipart/form-data">
Shortlink link: http(s)://delplink.xyz/<input type="text" name="n"><br>
<input type="radio" name="t" value="1" id="type1" checked>
<span onclick="typeClick(1)">Web address: </span>
<input type="text" name="w" onchange="typeClick(1)"><br>
<input type="radio" name="t" id="type2" value="2">
<span onclick="typeClick(2)">Computer code:</span>
<textarea name="c" class="delpcode" onchange="typeClick(2)"></textarea><br>
HTML Header(only used for computer code and can only have title and meta tags):<br>
<textarea class="delpcode" name="h"><title>Your code name</title>
<meta name="description" content="description for your code">
<meta name="keywords" content="code,ardunio,delphi,php,html,javascript">
<meta name="author" content="Your name">
</textarea><p>
<input type="button" value="Test" onclick="checkUrl(this.form)">
<input type="button" value="Generate URL" onclick="randomUrl(this.form)">
<input type="submit" value="Create tiny link"></p></form>
<?php $short=str_replace("/","_",$_POST["n"]);
$short=str_replace(".","_",$short);
$short=str_replace("\\","_",$short);
$short=str_replace('"',"_",$short);
$short=str_replace("'","_",$short);
$trys=0;
if(is_dir($short)){
	while(is_dir($short.$trys))$trys++;
	$short .= $trys;
}
if(!is_file($short)&&!is_dir($short)&&strlen($short)>0){
if(!mkdir($short))echo "mkdir: Failed.<br>";
file_put_contents($short.'/'.$deletefile,'<?php if($_POST["yes"]!="YES")die	("You did not confirm you wanted to delete it");unlink("index.php");unlink("count.txt");unlink("code.txt");unlink("head.txt");unlink("'.$deletefile.'");rmdir("../'.$short.'");?><p>Deleted</p>');
if(file_put_contents($short."/count.txt","0")===false)
echo "count.txt: Failed<br>";
switch($_POST["t"]*1){
case 1: $indexphp=file_put_contents($short."/index.php",
createWWW($_POST["w"]));break;
case 2:if(file_put_contents($short."/code.txt",$_POST["c"])===false)
echo "code.txt: Failed.<br>";$indexcode=str_replace(":editpasswd:",
$pageowner,file_get_contents(".htcodetemplete"));
file_put_contents($short."/head.txt",$_POST["h"]);?>
<?php
$indexphp=file_put_contents($short."/index.php",$indexcode.'<?php /* '.$_SERVER["REMOTE_ADDR"].' */?>');
break;
}
if($indexphp===false){echo "savelink: Failed.<br>";}else{?>
<center>Your shorten links:</center><p>
<p>
<input id="shorthttps" value="https://<?php echo $_SERVER['HTTP_HOST']."/".$short;?>" readonly>
<button class="cbbtn" data-clipboard-target="#shorthttps">
    Copy HTTPS Link
</button></p><p>
<input id="shorthttp" value="http://<?php echo $_SERVER['HTTP_HOST']."/".$short;?>" readonly>
<button class="cbbtn" data-clipboard-target="#shorthttp">
    Copy HTTP Link
</button></p><p>
<input id="countlink" value="https://<?php echo $_SERVER['HTTP_HOST']."/".$short;?>/count.txt" readonly>
<button class="cbbtn" data-clipboard-target="#countlink">
Copy visit counter link
</button></p>
<form method="post" action="/<?php echo $short.'/'.$deletefile;?>">
Type the word "YES" in uppercase to delete the link:
<input type="text" name="yes"><input type="submit" value="Delete"></form>
<script>visiturl="/<?php echo $short;?>/count.txt?";
setInterval(getVisits,10000);</script><?php }} ?>
</body></html>
