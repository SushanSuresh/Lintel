<?php
$imgF = $_GET['imgFile'];
header("Content-type: image/jpeg");
$jpeg = fopen("${imgF}","r");
$image = fread($jpeg,filesize("${imgF}"));
echo $image;
?>
