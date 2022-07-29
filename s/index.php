<h1>写入:</h1>
<form action="s.php">
<input name="nr" placeholder="内容">
<input type="submit" value="提交">
</form>
<h1>读取:</h1>
<?php
$s=file_get_contents("s.txt");
echo "<h2>$s</h2>";
?>