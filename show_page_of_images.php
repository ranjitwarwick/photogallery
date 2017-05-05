<?php
include("php_look_functions.php");

$photoset = $_GET['photo_set_name'];
$page_number = $_GET['page_number'];
$base_dir = $_GET['base_dir'];

show_page_of_images($photoset,$page_number,$base_dir);

?>





