<?php
include 'php_look_functions.php';

$photo_name_clicked = $_GET['image_name'];
$images_in_set = $_GET['images_in_set'];
$photo_set = $_GET['photo_set_name'];
$base_dir = $_GET['base_dir'];
$photo_short_name_array = array();
$photo_short_name_array = make_array_of_files_in_folder($base_dir,$photo_set);




//create $photo_full_name_array
$photo_full_name_array = array();
$dir = $base_dir . $photo_set; 
for($x = 0; $x < $images_in_set ; $x++)
{
  $file_name = $dir. "/" .$photo_short_name_array[$x];
  array_push($photo_full_name_array,$file_name);
   
}
usort($photo_full_name_array, 'strnatcmp');

//make php array into a javascript array - I think??
$short_name_string = "";
$full_name_string = "";
for($x = 0; $x < $images_in_set ; $x++)
{
 $short_name_string = $short_name_string . $photo_short_name_array[$x] . ",";
 $full_name_string = $full_name_string . $photo_full_name_array[$x] . ",";
}

$photo_short_name_string = rtrim($short_name_string,",");
$photo_full_name_string = rtrim($full_name_string,",");
//echo "<br>";
//echo $full_name_string;

echo $key_of_clicked_photo = array_search($photo_name_clicked,$photo_short_name_array);

?>


<html>
 <head>
  <link rel="stylesheet" type="text/css" href="photo_look.css">
  <script src="photo_look.js" type="text/javascript"></script>
 </head>
<body>

<div id="wrapper">
<div id="title-of-page-2-div">Photo Viewer</div>
<div id="photo-area-div">
  <div id="image-div">
    <img id="image-to-show">
  </div> <!-- image-div end -->
</div> <!-- photo-area-div end -->

<div id="nav-buttons-div">
  <button id="photo-number-button" type="button"></button> 
  <button id="back-button" type="button" onclick="back_forward_button(0,<?php echo $key_of_clicked_photo; ?>)"><</button> 
  <button id="forward-button" type="button" onclick="back_forward_button(1,<?php echo $key_of_clicked_photo; ?>)">></button>
  <button id="close-button" type="button" onclick="back_forward_button(2,<?php echo $key_of_clicked_photo; ?>)">X</button>
  <button id="auto-show" type="button" onclick="auto_show(<?php echo $key_of_clicked_photo; ?>,<?php echo $images_in_set;?>)">Auto</button>
  <button id="manual-mode" type="button" onclick="manual_control()">Maunal</button>
</div> <!--nav-buttons-div end-->

<div id="carousel-div">
  
 <table id="debug-info">
   <tr>
    <td>Wrapper:</td>
    <td id="info-0"></td>
    <td id="info-1"></td>
    <td id="info-2"></td>
   </tr>
     
   <tr>
    <td>Photo div:</td> 
    <td id="info-3"></td>
    <td id="info-4"></td>
    <td id="info-5"></td>
   </tr> 

   <tr>
    <td>natural image:</td> 
    <td id="info-6"></td>
    <td id="info-7"></td>
    <td id="info-8"></td>
   </tr>

   <tr> 
    <td>image:</td>
    <td id="info-9"></td>
    <td id="info-10"></td>
    <td id="info-11"></td>
   </tr>
 </table>

  
</div><!-- carousel-div end-->

<script>
window.addEventListener("resize", adjust_page);
</script>


<script>
//number_of_photos = <?php echo $images_in_set;?>;
//test_function_js(number_of_photos);

//var photos_full_name_a = window.opener.photo_full_name_array;
//var photos_short_name_a = window.opener.photo_short_name_array;
//var set_up_info = window.opener.parent_info;

photo_full_name_array = [];
photo_short_name_array = [];


//number_of_photos = <?php echo $images_in_set;?>;
//photo_name_clicked = <?php echo $photo_name_clicked;?>;
//base_dir = <?php echo $dir;?>;
//set_up_info = [photo_name_clicked,number_of_photos,base_dir];
//photo_full_name_array = [<?php echo $photo_full_name_string; ?>];
//photo_short_name_array = [<?php echo $photo_short_name_string; ?>];


var in_auto_mode = 0;
var setInt_var = 0;
document.getElementById("manual-mode").style.display = "none";
setup_page(<?php echo $key_of_clicked_photo; ?>,<?php echo $images_in_set;?>);

//display_photo(photos_full_name_array,photos_short_name_array,set_up_info);
</script>



</div><!-- End wrapper div-->


</body>
</html>














