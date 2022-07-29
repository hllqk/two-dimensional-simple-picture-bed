<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>后台</title>
<meta name="keywords" content="二次元简易文件上传">
<meta name="description" content="一款简约文件上传,使用本地存储，再也不用担心文件丢失了！">
<link rel="icon" href="favicon.ico" type="image/ico">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>a{
    color: #5DB1FF;
    }
</style>
<h1><a href="../">文件列表</a></h1>
<div style="background: transparent;" class="mdui-card mdui-shadow-24">
<br>
<br>
<?php
//if admin
if (!isset($_COOKIE["mm"]) || $_COOKIE["mm"]!="hllqk" ){
echo "<script>window.location='../admin/login.php'</script>";
}
echo "<link rel=\"stylesheet\" href=\"https://unpkg.com/mdui@1.0.2/dist/css/mdui.min.css\" />";
echo "<script src=\"https://unpkg.com/mdui@1.0.2/dist/js/mdui.min.js\"></script>";
$f=false;
$dir=scandir('../upload/');
foreach($dir as $file)
{
    if($file!='.' and $file!='..')
    {
$r='../upload/'.$file;
$v="<a href='$r'>$file</a> ";
echo "<div style=\"margin: 10px;\" class='mdui-divider'></div>";
echo $v;
if (end(explode(".",$file))=="zip"){
echo " <a href='index.php?unzip=$r&lj=$file'>解压</a> ";
}
echo "<a href='../admin/index.php?file=$r&if=$f'>删除</a><br>";
    }  
}
echo "<div style=\"margin: 10px;\" class='mdui-divider'></div>";

//unzip
if (isset($_GET["unzip"]) and isset($_GET["lj"])){
$file=$_GET["unzip"];
$lj="../upload/";
$r=unzip($file,$lj);
if ($r){
echo "解压成功";   
}
else{
echo "解压失败";
}
//Goto admin
echo "<script>setTimeout(\"window.location='../admin/index.php'\",1000)</script>";
}
if (isset($_GET["file"]) and isset($_GET["if"])){
$file=$_GET["file"];
$if=$_GET["if"];
if ($if){
unlink($file);
echo "<script>mdui.alert('删除成功')</script>";
echo "<script>setTimeout(\"window.location='../admin/'\",1000)</script>";
}
else{
echo "<script>var r=confirm('是否删除');if(r==true) { window.location='../admin/index.php?file=$file&if=true'; }else{ window.location='../admin/index.php' }</script>";
}
}
//function
function unzip(string $zipName,string $dest){
//检测要解压压缩包是否存在
if(!is_file($zipName)){
return false;
}
//die($file);
//检测是否可以覆盖
$fg=true;
if ($fg==false){
die("不可以覆盖");
$file=$dest.explode(".",$zipName)[2];
if(file_exists($file)){
echo "文件已存在";
return false;
}
}
//检测目标路径是否存在
if(!is_dir($dest)){
mkdir($dest,0777,true);
}
$zip=new ZipArchive();
if($zip->open($zipName)){
$zip->extractTo($dest);
$zip->close();
return true;
}else{
return false;
}
}
?>
<br>
<br>
</div>
<style>
body
{ 
background: url(../upload/background.jpg); 
background-repeat:no-repeat ;
background-size:100% 100%;
background-attachment: fixed;
/*background-image: url(bg.jpg);*/
}
</style>
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function (){
    if(navigator.userAgent.match(/mobile/i)) {
$("body").css("background","url('../upload/background1.jpg')")
        }
}
)
</script></body>
</html>