<?php
include("php_look_functions.php");

$image_name = $_GET['image_name'];
$images_in_set = $_GET['images_in_set'];
$photo_set_name = $_GET['photo_set_name'];
$base_dir = $_GET['base_dir'];

//header('Location: photo_look_2.php?image_name=image_name&images_in_set=images_in_set&photo_set_name=photo_set_name&base_dir=base_dir');

$photo_short_name_array = array();
$photo_short_name_array = make_array_of_files_in_folder($base_dir,$photo_set_name);
  
//create $photo_full_name_array
$photo_full_name_array = array();
$dir = $base_dir . $photo_set_name;

//create table. It will be hidden and not displayed. Each td with have an id. The id will be the image name e.g. <td id="hilbert-jpg">
//We will have to convert hilbert.jpg to hibert-jpg
$table_string = "<table id=\"hidden-table\"><tr>"; 

for($x = 0; $x < $images_in_set ; $x++)  
   {
     $file_name = $dir. "/" .$photo_short_name_array[$x];
     array_push($photo_full_name_array,$file_name);
   }
   usort($photo_full_name_array, 'strnatcmp');

//get rid of one of these sort lines when testing is complete

usort($photo_short_name_array, 'strnatcmp');
for($y = 0; $y < $images_in_set ; $y++)  
   {
     $table_string = $table_string . "<td id=";
     $image_td_id_array = (explode(".",$photo_short_name_array[$y]));
     $table_string = $table_string . $image_td_id_array[0]."-".$image_td_id_array[1].">";          
   }
$table_string = $table_string . "</tr></table>";
echo $table_string;
 
   $key_of_clicked_photo = array_search($image_name,$photo_short_name_array);
  
   //go_to_slider_HTML($image_name,$images_in_set,$photo_set_name,$base_dir,$key_of_clicked_photo);

//go_to_slider($image_name,$images_in_set,$photo_set_name,$base_dir);

?>

<div id="title-of-page-2-div">Photo Viewer</div>

<div id="photo_area_div">
  <div id="image_div"> 
    <!-- <img id="image-to-show" src="<?php echo $base_dir.$photo_set_name."/".$image_name ?>"> -->
    <img id="image_to_show">
  </div> <!-- image-div end -->
</div> <!-- photo-area-div end -->

<div id="nav-buttons-div">
  <button id="photo-number-button" type="button"><?php echo $key_of_clicked_photo." of ".$images_in_set ?></button> 
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
