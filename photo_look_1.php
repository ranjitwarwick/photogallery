<?php
include 'php_look_functions.php';
photo_look_1_header();


echo $photoset_id = $_GET['photoset_id'];
echo $previous_page = $_GET['previous_page'];
echo $next_page = $_GET['next_page'];
echo $page_number = $_GET['page_number'];
echo $base_dir = $_GET['base_dir'];


$imported_var = $photoset_id. "/";

//$imported_var = "kathy/";
$dir_base = "photos/";

$dir = $dir_base . $imported_var;
//$dir = "kathy/";
//$dir = "carol/";
$display_string = "<table id=\"gallery-table\"><tr class=\"gallery-row\">";
$full_name_string = "";
$full_name_array = array();

$file_is_a_folder = 0;

$short_name_string = "";
$short_name_array = array();

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
             //echo str_replace(' ', '%20', $file); 
             //echo "Adding image to array: " . $file. "<br>";
             array_push($full_name_array,$dir.$file);
             array_push($short_name_array,$file);
            }
        // $photo_counter++; 
     }
     closedir($dh);
     usort($full_name_array, 'strnatcmp');        
     usort($short_name_array, 'strnatcmp');
   
     //print_r($full_name_array);
     //echo "<br>";
     //print_r($short_name_array);
     
     $max_width = 190;
     $max_height = 190;        
     

     //read arrays and create strings in various formats
     $arrlength = count($short_name_array);
     $rows_per_page = 4;
     $columns_per_row = 8;

     $max_photos_per_page = $rows_per_page * $columns_per_row;
     
     $pages_for_photoset = ceil($files_in_dir/$max_photos_per_page);

     $page_counter = 0;
     $image_counter = 0; 

     $column_count=0;
     $row_count=1;
     for($x = 0; $x <= $arrlength - 1 ; $x++)
        {
          $size_data = getimagesize($full_name_array[$x]);
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


          $display_string = $display_string . "<td class=\"gallery-cell\"><img src=" . $dir . $short_name_array[$x] . " width=". $img_width . " height=". $img_height ." class=\"gallery-image\" onclick=\"go_to_slider(". "'" . $short_name_array[$x] ."'" . ")\"></td>";
          $column_count++;
          $full_name_string = $full_name_string . "\"" .  $full_name_array[$x] . "\"";
          $short_name_string = $short_name_string . "\"" .  $short_name_array[$x] . "\"";
         
          if ($x < $arrlength - 1)
             {
               $short_name_string = $short_name_string . ",";
               $full_name_string = $full_name_string . ",";
             }
 
          if ($column_count == $columns_per_row)
             {
               $display_string = $display_string . "</tr><tr class=\"gallery-row\">";
               $column_count=0;
               $row_count++;
                
             }           
        }
    }
$display_string = $display_string . "</tr></table>";
echo $display_string;
//echo $short_name_string;
}

?>

<script>
  
  function go_to_slider(photo_name_clicked)
  {
    
    number_of_photos = <?php echo $files_in_dir;?>;
    parent_info = [photo_name_clicked,number_of_photos,"<?php echo $dir;?>"];
    photo_full_name_array = [<?php echo $full_name_string; ?>];
    photo_short_name_array = [<?php echo $short_name_string; ?>];

    window.open('photo_look_2.php');
  }

</script>

</div><!-- End wrapper div-->

</body>
</html>














