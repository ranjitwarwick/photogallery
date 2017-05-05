<?php
function photo_gallery_header()
{
?>

<html>
 <head>
  <link rel="stylesheet" type="text/css" href="photo_look.css">
  <script src="photo_look.js" type="text/javascript"></script>
 </head>
<body onload="get_screen_data()">

<div id="wrapper">
<?php
}
?>

<?php
function photo_look_1_header()
{
?>

<html>
 <head>
  <link rel="stylesheet" type="text/css" href="photo_look.css">
  <script src="photo_look.js" type="text/javascript"></script>
 </head>
<body onload="photoFit()">

<div id="wrapper">
<?php
}
?>


<?php
function count_files_in_directory($dir)
{
   $counter = 0;
   if (is_dir($dir))
      {
        if ($dh = opendir($dir))
           {
              while (($file = readdir($dh)) !== false)
                    {
                      if (is_dir($file))
                         {
                           $file_is_a_folder = 1;
                           //echo "Folder Alert" . $file; 
                         }
                      else
                         {
                           $file_is_a_folder = 0;
                         }           


                      if ($file == ".." or $file == "." or $file_is_a_folder == 1)
                         {
                            //echo "not a file" . "<br>";
                         }
                      else
                         {
                            $counter++;
                         }
                    }
           closedir($dh);
           }
      }
return $counter;
}

?>


<?php
function show_page_of_images($photoset,$page_number,$base_dir)
{

$photoset = $_GET['photo_set_name'];
$page_number = $_GET['page_number'];
$base_dir = $_GET['base_dir'];


$short_name_array = array();
$full_name_array = array();

$file_is_a_folder = 0;

$display_string = "<div id=\"work_area_div\"><table id=\"gallery-table\"><tr class=\"gallery-row\">";

$dir = $base_dir . $photoset;
$files_in_dir = count_files_in_directory($dir);

if ($files_in_dir == 0 )
   {
      echo "No photos";
      exit;
   }
// read files in directory
if (is_dir($dir))
 {
   if ($dh = opendir($dir))
   {
      while (($file = readdir($dh)) !== false)
      {
         if (is_dir($file))
            {
               $file_is_a_folder = 1;
               //echo "Folder Alert" . $file; 
            }
         else
            {
               $file_is_a_folder = 0;
            }           
 
         if ($file == ".." or $file == "." or $file_is_a_folder == 1)
            {
              //echo "not a file" . "<br>";
            }
         else
            {
             //echo str_replace(' ', '%20', $file); 
             //echo "Adding image to array: " . $file. "<br>";
             array_push($full_name_array,$dir."/".$file);
             array_push($short_name_array,$file);
            }
        // $photo_counter++; 
     } // close while
     closedir($dh);
     usort($full_name_array, 'strnatcmp');        
     usort($short_name_array, 'strnatcmp');

     //create table. It will be hidden and not displayed. Each td with have an id. The id will be the image name e.g. <td id="hilbert-jpg">
     //We will have to convert hilbert.jpg to hibert-jpg
     $table_string = "<table id=\"hidden_table\">"; 

     for($y = 0; $y < $files_in_dir ; $y++)  
        {
          $table_string = $table_string . "<tr><td id=";
          $image_td_id_array = (explode(".",$short_name_array[$y]));
          $table_string = $table_string . $image_td_id_array[0]."_".$image_td_id_array[1].">".$short_name_array[$y]."</td></tr>";          
        }
     $table_string = $table_string . "</table>";
     
     


     //convert php array to JS
     //echo "<script>short_name_array_js = [];</script>"; 
     //for($x=1;$x<=$files_in_dir;$x++)
        //{
          //echo "make js array: ". $x . "<br>";
          //echo "<script>";
          //echo "short_name_array_js.push(".'$short_name_array[$x]'.")";
          //echo "</script>";
        //}


     
    //$imploded_full_name_array = implode("",$full_name_array);
    //$imploded_short_name_array = implode("",$short_name_array);

     //print_r($full_name_array);
     //echo "<br>";
     //print_r($short_name_array);
   } //close if    
  } //close if 

//read arrays and create strings in various formats
     $images_in_set = count($short_name_array);
      
     //echo "Images in set: " . $mages_in_set . "<br>";   

     $rows_per_page = 4;
     $columns_per_row = 8;

     $max_photos_per_page = $rows_per_page * $columns_per_row;

     $offset = ($page_number - 1) * $max_photos_per_page;
     //echo "offset: ".$offset . "<br>";
     $pages_for_photoset = ceil($files_in_dir/$max_photos_per_page);
     $last_page = $pages_for_photoset;

     $page_counter = 0;
     $image_counter = 0; 

     $max_width = 150;
     $max_height = 150;     

     $column_count=0;
     $row_count=1;
     
     for($x = 0; $x < $max_photos_per_page ; $x++)
        {
          $image_counter++;
          $image_number = $x + $offset;
          if ($image_number >= $images_in_set)
             {
                //add extra rows and blank <td> to fill out table to max size
                //echo "no image" .$x . "<br>";
                $display_string = $display_string . "<td class=\"gallery-cell\"<td>";
                $column_count++;  
                if ($column_count == $columns_per_row)
                   {
                     $display_string = $display_string . "</tr><tr class=\"gallery-row\">";
                     $column_count=0;
                     $row_count++;
                   }         
   
             }   
          else
             { 
               $size_data = getimagesize($full_name_array[$image_number]);
               $photo_width = $size_data[0];
               $photo_height = $size_data[1];
               $aspect_ratio = $photo_width / $photo_height;
              //echo "aspect ratio: ". round($aspect_ratio,2) . "<br>"; 
            if ($aspect_ratio == 1)
               {
                 $img_width = $max_width;
                 $img_height = $max_height;
               }
            if ($aspect_ratio < 1)
               {
                 $img_height = $max_height;
                 $img_width = $img_height * $aspect_ratio;
               }
            if ($aspect_ratio > 1)
               {
                 $img_width = $max_width;
                 $img_height = $img_width / $aspect_ratio;
               }               

            //Pass $images_in_set is the total number of images in a given directory.
            //This number could change if more photos are added whilst this code is running.
            //For speed of processing - we will not keep recalculating this particular parameter.
            //Perhaps a notice to the user saying "new photos addded" would be in order.
            
            //$temp_string = $full_name_array[$image_number]; 

            $display_string = $display_string . "<td class=\"gallery-cell\"><img src=" ."'" .$full_name_array[$image_number] ."'" ." width=". $img_width . " height=". $img_height ." class=\"gallery-image\" onclick=\"go_to_slider_ajax(". "'" . $short_name_array[$image_number] ."'" . ",$images_in_set,'$photoset','$base_dir',$image_number)\"></td>";
            $column_count++;
            
            if ($x < $images_in_set - 1)
               {
                 //$short_name_string = $short_name_string . ",";
                 //$full_name_string = $full_name_string . ",";
               }
 
            if ($column_count == $columns_per_row)
               {
                 $display_string = $display_string . "</tr><tr class=\"gallery-row\">";
                 $column_count=0;
                 $row_count++;
                
               }     
           } //end if else concerning $last_page


          // ----------------- paging --------------------------------------
          
          if ($image_counter == $max_photos_per_page)
          {
            $display_string = $display_string . "<table id=\"nav-table\"><tr>";
            $display_string = $display_string . "<td id=\"navTableC1\">Page</td><td id=\"navTableC2\">" .$page_number. " of " .$pages_for_photoset. "</td>";  
            
            if ($page_number > 1)
               {    
                 //previous page
                 $previous_page = $page_number - 1;  
                 $display_string = $display_string . "<td id=\"navTableC3\"><input type=\"button\" onclick=\"show_page_of_images_ajax('".$photoset."',".$previous_page.",'".$base_dir."')\" value=\"Previous\"></td>";
               }
            else
               {
                 $display_string = $display_string . "<td id=\"navTableC3\"></td>";
               }    



            if ($page_number < $last_page)
               {  
                 //next page
                 $next_page = $page_number + 1;   
                 $display_string = $display_string . "<td id=\"navTableC4\"><input type=\"button\" onclick=\"show_page_of_images_ajax('".$photoset."',".$next_page.",'".$base_dir."')\" value=\"next\"></td>";
               }
            else
               {
                 $display_string = $display_string . "<td id=\"navTableC4\"></td>";
               }    
              
          }
     


      
        }
   
$display_string = $display_string . "<td id=\"navTableC5\"><input type=\"button\" onclick=\"back_to_gallery()\" value=\"Gallery\"></td>";
$display_string = $display_string . "</tr></table>";

if ($pages_for_photoset > 1)
{
  $display_string = $display_string . "<table id=\"quickNavTable\"><tr>";
  for($x = 1; $x <= $pages_for_photoset ; $x++)  
     {
        $display_string = $display_string . "<td><input type=\"button\" onclick=\"show_page_of_images_ajax('".$photoset."',".$x.",'".$base_dir."')\" value=\"".$x."\"></td>";
     }
  $display_string = $display_string . "</tr></table>";
}

$display_string = $display_string . "</div>";
                                                        //^ /div belongs to <div id="work_area_div" >
                                                  
echo $display_string;
echo $table_string;


}
?>



<?php
function make_array_of_files_in_folder($base_dir,$photo_set)
{
$array_name = array();
$dir = $base_dir . $photo_set;
$files_in_dir = count_files_in_directory($dir);

if ($files_in_dir == 0 )
   {
      echo "No photos";
      exit;
   }

// Open a directory, and read its contents
if (is_dir($dir))
 {
   if ($dh = opendir($dir))
   {
      while (($file = readdir($dh)) !== false)
      {
         if (is_dir($file))
            {
               $file_is_a_folder = 1;
               //echo "Folder Alert" . $file; 
            }
         else
            {
               $file_is_a_folder = 0;
            }           
 
         if ($file == ".." or $file == "." or $file_is_a_folder == 1)
            {
              //echo "not a file" . "<br>";
            }
         else
            {
             array_push($array_name,$file);
            }
      } // close while
      closedir($dh);
      usort($array_name, 'strnatcmp');   
      return $array_name;    
   }
 }           
}
?>


<?php
function go_to_slider($image_name,$images_in_set,$photo_set_name,$base_dir)
{
  
  $photo_short_name_array = array();
  $photo_short_name_array = make_array_of_files_in_folder($base_dir,$photo_set_name);
  
  //create $photo_full_name_array
  $photo_full_name_array = array();
  $dir = $base_dir . $photo_set_name; 
  for($x = 0; $x < $images_in_set ; $x++)  
  {
    $file_name = $dir. "/" .$photo_short_name_array[$x];
    array_push($photo_full_name_array,$file_name);
  }
  usort($photo_full_name_array, 'strnatcmp');
 
  $key_of_clicked_photo = array_search($image_name,$photo_short_name_array);
  
  go_to_slider_HTML($image_name,$images_in_set,$photo_set_name,$base_dir,$key_of_clicked_photo);

}

?>

<?php
function go_to_slider_HTML($image_name,$images_in_set,$photo_set_name,$base_dir,$key_of_clicked_photo)
{
?>
<!--
<html>
 <head>
  <link rel="stylesheet" type="text/css" href="photo_look.css">
  <script src="photo_look.js" type="text/javascript"></script>
 </head>
<body>

<div id="wrapper">
-->
<div id="title-of-page-2-div">Photo Viewer</div>
- 
<div id="photo_area_div">
 <div id="image_div"> 
   
<img id="image_to_show" src="<?php echo $base_dir.$photo_set_name."/".$image_name ?>"> 
</div> <!-- image-div end -->
</div>  <!-- photo-area-div end -->


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
function load_photo()
{
alert("in load photo");
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
}
</script>



</div><!-- End wrapper div-->


</body>
</html>

<?php
} //
?>



<?php
function showGallery()
{
$subFolderArray = array();
$contentsArray = array();
$subFolderCounter = 0;
$contentsCounter = 0;

$dir = "photos";
if (is_dir($dir))
{
   // open main photos folder
   if ($dh = opendir($dir))
   {
     while (($subdirOrFile= readdir($dh)) !== false)
      {
         if ($subdirOrFile== ".." or $subdirOrFile== ".")
            { 
            }
         else
            {
             $subdirPath = $dir."/".$subdirOrFile;
             if (is_dir($subdirPath))
                     {
                      $forkhandles = opendir($subdirPath);
                      $fi = new FilesystemIterator($subdirPath, FilesystemIterator::SKIP_DOTS);
                      $filesInAlbum = iterator_count($fi);
                      if ($filesInAlbum > 0)
                         { 
                           while (($contents = readdir($forkhandles)) !== false)
                                 if ($contents == ".." or $contents == ".")
                                    { 
                                    }
                                 else 
                                    {
                                      $contentsArray[$contentsCounter] = $contents;
                                      $contentsCounter++;
                                    }
                         
                           
                           natsort($contentsArray);
                           $SortedContentsArray = array();
                           $x=0; 
                           foreach ($contentsArray as $value) {
                                   $SortedContentsArray[$x] = $value;
                                   $x++;  
                                   }
                          

                           $galleryPhoto =  $SortedContentsArray[0];   
                           array_unshift($SortedContentsArray,$dir,$subdirOrFile,$galleryPhoto,$filesInAlbum);
                         

                           $subFolderArray[$subFolderCounter] = $SortedContentsArray;
                           $subFolderCounter++;
                           $contentsCounter = 0;
                           $contentsArray = array();
                           $SortedContentsArray = array();                           
                         }
                      else
                         {
                            //echo "no files <br>";
                         }
                      closedir($forkhandles);
                      }
            }
     }
     closedir($dh);
   }
}

$albumCounter=0;
$rowCounter = 0;
$columnCounter = 0;
while ($albumCounter < $subFolderCounter)
      {
        $sourceIMG = $subFolderArray[$albumCounter][0]."/".$subFolderArray[$albumCounter][1]."/".$subFolderArray[$albumCounter][2];
        $base_dir= $dir . "/";
        $subFolderDisplay= $subFolderArray[$albumCounter][1];       
        echo "<td class=\"gallerytd\"><img src=\"". $sourceIMG. " \" width=\"210\" onclick=\"show_page_of_images_ajax('$subFolderDisplay',1,'$base_dir')\" alt=\"no image\"></td>";
        $columnCounter++;      
        $albumCounter++;
        if ($columnCounter > 6)
           {  
             echo "<tr>";
             $columnCounter = 0;
             $rowCounter++;
           }   
      }
echo "</tr></table>"; 

}
?>
















