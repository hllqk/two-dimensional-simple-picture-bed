<?php

// 允许上传的图片后缀
$allowedExts = array("zip");
$temp = explode(".", $_FILES["file"]["name"]);
//echo $_FILES["file"]["size"];
$extension = end($temp);     // 获取文件后缀名
if (in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
        echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
        echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
        
        // 判断当前目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("/" . $_FILES["file"]["name"]))
        {
            echo $_FILES["file"]["name"] . "文件已经存在 ";
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到目录下
            $zipn=$_FILES["file"]["name"];
            //die($zipn);
            move_uploaded_file($_FILES["file"]["tmp_name"],$zipn );
        unzip($zipn,"./");
         unlink($zipn);
              echo "解压成功，文件存储在: " . "../" . $_FILES["file"]["name"]."/";
        }
    }
}
else
{
    echo "非法的文件格式";
}
function unzip(string $zipName,string $dest){
//检测要解压压缩包是否存在
if(!is_file($zipName)){
return false;
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