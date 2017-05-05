<?php
echo "hallo";
$dir = "/var/www/html/darts/2017/photo-viewer/photos/sue";
//$dir="/var/www/html/darts/slide-2017/photos";
// Open a directory, and read its contents
if (is_dir($dir))
 {
   if ($dh = opendir($dir))
   {
      while (($file = readdir($dh)) !== false)
      {
         if ($file == ".." or $file == ".")
            {
              echo "not a file" .$file ."<br>";
            }
         else
            {
             echo $file . "<br>";
            }
     }
     closedir($dh);
   }
}

echo "bye";
$dir2="photos/sue/";
?>

<img src="<?php echo $dir2;?>21 image.png" width=200></img>



<?php
echo "<br>";
$url_org = "http://www.w3 schools.com";
$url = rawurlencode($url_org);     
if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
    echo("$url is a valid URL");
} else {
    echo("$url is not a valid URL");
}
echo "<br>";


$string = "beautiful";
$time = "winter";
echo "<br>";
$str = 'This is a $string $time morning!';
echo $str. "<br>";
echo "<br>";
$str = "This is a". $string. " . "  .$time . " morning!";
echo $str. "<br>";

eval("\$str = \"$str\";");
echo $str;


//$dir    = '/var/www/html/darts/slide-2017/photos';
//$files1 = scandir($dir);
//$files2 = scandir($dir, 1);

//print_r($files1);
//print_r($files2);
?>

<?php
//$numbers = array("4","3","33","6","2","22","10","11");
//sort($numbers);

//$arrlength = count($numbers);
//for($x = 0; $x < $arrlength; $x++) {
//    echo $numbers[$x];
//    echo "<br>";
//}
?>
