<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>二次元简易文件上传</title>
<meta name="keywords" content="二次元简易文件上传">
<meta name="description" content="一款简约文件上传,使用本地存储，再也不用担心文件丢失了！">
<link rel="icon" href="favicon.ico" type="image/ico">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="droppable">
<form id="form" action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="file">
</form>
 <div class="list"></div>
  <div class="info">
      <div class="info-drag info-item">
    <iframe frameborder="no" width="100px" height="100px" src="upload/upload.svg"></iframe>
      <div class="info-text">拖拽上传文件</div>
    </div>
    </form>
  </div>
</div>
<div id="div"><h2 class="h111"></h2></div>
<style>
    #file,form{
        width: 100%;
        height: 100%;
        overflow: hidden;
        cursor: pointer;
        opacity: 0;
    }

body
{ 
background: url(upload/background.jpg); 
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
$("body").css("background","url('upload/background1.jpg')")
        }
//监听input
$("#file").on("change",function (e) {
   var e = e || window.event;
   //获取 文件 个数 取消的时候使用
   var files = e.target.files;
   if(files.length>0){
       // 获取文件名 并显示文件名
       var fileName = files[0].name;
      //alert(fileName);
       $("#form").submit();
   }else{
   }
});
}
)
</script>
</body>
</html>