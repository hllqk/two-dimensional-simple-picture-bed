<?php
ob_start();
if (isset($_GET["mm"])){
$mm=$_GET["mm"];
if ($mm=="hllqk"){
setcookie("mm",$mm,time()+123456789,"/");
echo "<script>alert('登录成功,欢迎回来,水啊!');setTimeout(\"window.location='../admin/'\",1000)</script>";  
}
}
?>