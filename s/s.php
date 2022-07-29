<?php
if (isset($_GET["nr"])){
$nr=$_GET["nr"];
file_put_contents("s.txt",$nr);
echo "提交成功";
echo "<script>setTimeout(\"window.location='../'\",700)</script>";  
}
else{
echo "错误";
   }
?>