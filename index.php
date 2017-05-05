<?php

// --------- photo_gallery.php ------------------

include 'php_look_functions.php';
photo_gallery_header();
$base_dir="photos/";

?>
<div id="spare_divs"></div>
<div id="main_body_div">

 <div id="title-div">Ranjit Samrai Gallery</div> <!--title-div END -->
 <div id="pick-gallery-ajax-div">
    
  <!-- need to create this table dynamically!!! -->
  <table id="gallery-table">
   <tr>

<?php
showGallery();
?>
  </div> <!-- pick-gallery-ajax-div END -->

</div> <!-- main-body-div END -->

</div><!-- End wrapper div-->
<!-- <div id="photo-area-div"> <img id="image-to-show"> </div> -->
<div id="hidden-data-div">
  <table id=hidden-data-table>
     <tr><td>Wrapper W:</td><td id="hide-info-1"></td><td>Wrapper H:</td><td id="hide-info-2"></td><td>Wrapper AR:</td><td id="hide-info-3"></td></tr>
     <tr><td>Button val:</td><td id="button_val"></td><td>Current image num</td><td id="current_image_no"></td><td>spare:</td><td id="hide-info-3"></td></tr>
     <tr><td>nat-w:</td><td id="nat_w"></td><td>nat-h:</td><td id="nat_h"></td><td>nat-ar:</td><td id="nat_ar"></td><td>src:</td><td id="base_dir"></td></tr>
</table>
<img id="hidden-image"></img>
</div> <!-- hidden-data-div END -->

<script>
var in_auto_mode = 0;
var setInt_var = 0;
</script>



</body>
</html>




