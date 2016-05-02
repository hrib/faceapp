<?php 
$imgurl = 'https://scontent-lhr3-1.xx.fbcdn.net/v/t1.0-9/11988259_1672140403008188_2765317534386607908_n.jpg?oh=ef2d8c9deed78c03d070ae0ac052497e&oe=57AA2100';
//$imgurl = 'http://dedarwin.net/wp-content/uploads/2015/02/HTML.jpg';
//header('Content-Type: image/jpeg');
//echo file_get_contents($imgurl);
//echo '<br>1<br>';
file_put_contents("image.jpg", file_get_contents($imgurl));
//echo $storedimg;
//echo '<br>2<br>';
//$imgteste = 'http://dedarwin.net/wp-content/uploads/2015/02/HTML.jpg';
echo "<img src='image.jpg'>";


?>
