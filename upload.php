<?php
include "ys.php";
// 允许上传的图片后缀
$allowedExts = array("py","html","js","css","gif","jpeg", "jpg", "png","txt","zip","7z","rar","exe","apk");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 5*1024*1024)   // 小于5mb
|| in_array($extension, $allowedExts))
{
if ($_FILES["file"]["error"] > 0)
{
echo "错误：" . $_FILES["file"]["error"] . "<br>";
}
else
{
echo "上传文件名: ".$_FILES["file"]["name"] . "<br>";
echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kb<br>";
echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
// 判断当前目录下的 upload 目录是否存在该文件
// 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
if (file_exists("upload/" . $_FILES["file"]["name"]))
{
echo $_FILES["file"]["name"] . " 文件已经存在。 ";
}
else
{
$file="upload/".$_FILES["file"]["name"];
echo "文件存储在: " . "<a href='upload/" . $_FILES["file"]["name"]."'>打开</a><br>";
// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
move_uploaded_file($_FILES["file"]["tmp_name"],$file);
$ImgCompressor = new ImgCompressor();
//仅压缩
$result = $ImgCompressor->set($file,$file)->compress(5)->get($file);
echo "文件压缩后大小: " .getsize($file). " kb<br>";
echo "上传成功"."<br>";
}
}
}
else
{
echo "非法的文件格式";
}
?>