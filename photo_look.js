// Page 1 functions


// used in php function (onload) photo_gallery_header()
function get_screen_data()
{
   var screen_data = [];
   var screen_data = object_details_rectangle('wrapper')
   document.getElementById("hide-info-1").innerHTML = screen_data[0];
   document.getElementById("hide-info-2").innerHTML = screen_data[1];
   document.getElementById("hide-info-3").innerHTML = (screen_data[0] / screen_data[1]).toFixed(2);
  
}


// returns width and height of a rectangular object like div.
// parameter is something like id of a div object.
function object_details_rectangle(object_id)
{
  var myObject = document.getElementById(object_id);
  var width = myObject.clientWidth;
  var height = myObject.clientHeight;
  var objectDetails = [width,height]
  return objectDetails;   
}  


// returns width,height, natural width, and natural height of a photo.
// parameter is id of a the img. 
function object_details_photo(object_id)
{
  var myObject = document.getElementById(object_id);
  var width = myObject.clientWidth;
  var height = myObject.clientHeight;
  var naturalWidth = myObject.naturalWidth;
  var naturalHeight = myObject.naturalHeight;
  var objectDetails = [width,height,naturalWidth,naturalHeight] 
  return objectDetails;
}  



//function auto_show(position_of_current_Photo,photos_in_array)
function auto_show(button_value,image_number,images_in_set,photo_set_name,base_dir)
{
  in_auto_mode = 1;
  //enable manual button
  document.getElementById("manual_mode").style.display = "inline";  
  document.getElementById("auto_show").disabled = true;
  setInt_var=setInterval(function(){ next_photo(button_value,image_number,images_in_set,photo_set_name,base_dir); }, 3000);
}


function next_photo(button_value,image_number,images_in_set,photo_set_name,base_dir)
{
  current_image_number = document.getElementById('current_image_no').innerHTML; 
  current_image_number_int = parseInt(current_image_number);
  image_number = current_image_number_int;

 if (image_number == images_in_set -1)
     {
       image_number = -1;
       button_value = 1;
       change_my_image(button_value,image_number,images_in_set,photo_set_name,base_dir);
     }
  else
     { 
       
       button_value = 1;
       change_my_image(button_value,image_number,images_in_set,photo_set_name,base_dir);
       
     }
 
}

//-------------show_page_of_images_ajax
//photoset
//page_number
//base_dir)

function show_page_of_images_ajax(photo_set_name,page_number,base_dir)
{
 var ajaxRequest;  
 try{
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         alert("Your browser broke!");
         return false;
      }
   }
 }
 ajaxRequest.onreadystatechange = function(){
   if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('main_body_div');
      ajaxDisplay.innerHTML = ajaxRequest.responseText;

   }
 }
 
 queryString =  "?photo_set_name=" + photo_set_name + "&page_number=" + page_number + "&base_dir=" + base_dir; 
 ajaxRequest.open("GET","show_page_of_images.php" + queryString, true);
 ajaxRequest.send(null); 
}



//  ------------------- go_to_slider_ajax ------------------------------

function go_to_slider_ajax(image_name,images_in_set,photo_set_name,base_dir,image_number)
{
 document.getElementById('work_area_div').innerHTML = ""; 
 setup_photo_on_slider(image_name,photo_set_name,base_dir,image_number,images_in_set);
 
}

   
// --------------- setup_photo_on_slider
// image_name
// photo_set_name
// base_dir
// image_number
// images_in_set

function setup_photo_on_slider(image_name,photo_set_name,base_dir,image_number,images_in_set)
{
  //wrapper dimensions
  var wrapper_width = document.getElementById("hide-info-1").innerHTML;
  var wrapper_height = document.getElementById("hide-info-2").innerHTML; 
  var wrapperAspectRatio = wrapper_width / wrapper_height;

  var image_path_name =  base_dir + photo_set_name + "/" + image_name; 
  

  //Create divs within main_body_div
  //new_title_div
  var new_title_div = document.createElement("div");
  main_body_div.appendChild(new_title_div);
  new_title_div.id="title_slider_div";
  document.getElementById("title_slider_div").innerHTML = "Photo Viewer";   

  // create 
  var new_div = document.createElement("div");
  main_body_div.appendChild(new_div);
  new_div.id="photo_area_div";  
 
  var new_div_2 = document.createElement("div");
  photo_area_div.appendChild(new_div_2);
  new_div_2.id="image_div";

  var new_img = document.createElement("img");
  image_div.appendChild(new_img);
  new_img.id="image_to_show";  

  //determine size of photo area. 
  // for screen with aspect ratio > 1 we will use middle 80% of width of the screen
  // so 1 1600 x 900 will have a photo_area_div of 1600/100 * 80, etc  

  document.getElementById("photo_area_div").width = (wrapper_width / 100) * 80;
  document.getElementById("photo_area_div").height = (wrapper_height / 100) * 80;  
  
  var photo_frame_width=document.getElementById("photo_area_div").width;
  var photo_frame_height=document.getElementById("photo_area_div").height;


  document.getElementById("image_to_show").src = image_path_name;
  document.getElementById("current_image_no").innerHTML = image_number;
  if (image_number < images_in_set -1)
     { 
       document.getElementById("image_to_show").onclick = function(){back_forward_button(1,image_number,images_in_set,photo_set_name,base_dir);};
     }
  //document.getElementById("image_to_show").onkeypress = function(){back_forward_button(1,image_number,images_in_set,photo_set_name,base_dir);};  

  //natural image info
  var image_dimensions_a = object_details_photo("image_to_show");
  var image_width = image_dimensions_a[2];
  var image_height = image_dimensions_a[3]; 
  var imageAspectRatio = image_width / image_height;
     
  // is screen width >= screen height
  if (wrapperAspectRatio <= imageAspectRatio)
     {
       var scaleFactor = photo_frame_width / image_width;
       document.getElementById("image_to_show").height = image_height * scaleFactor;
       var image_to_show_width = image_width * scaleFactor;
       document.getElementById("image_to_show").width = image_to_show_width;
     }
  else
     {
       var scaleFactor = photo_frame_height / image_height;
       document.getElementById("image_to_show").width = image_width * scaleFactor;
       var image_to_show_height = image_height * scaleFactor;
       document.getElementById("image_to_show").height = image_to_show_height; 
     }

  var new_nav_div = document.createElement("div");
  main_body_div.appendChild(new_nav_div);
  new_nav_div.id="nav_buttons_div";

  button_string = create_nav_buttons(image_number,images_in_set,photo_set_name,base_dir);
  document.getElementById("nav_buttons_div").innerHTML = button_string;
  configure_buttons(image_number,images_in_set);  

  var in_auto_mode = 0;
  var setInt_var = 0;
  
  
}


// --------------- back_forward_button -----------
// button_value
// image_number
// images_in_set
// photo_set_name,base_dir

function back_forward_button(button_value,image_number,images_in_set,photo_set_name,base_dir)
{
 document.getElementById("button_val").innerHTML = button_value;
 //disable 
 document.getElementById("back_button").disabled = true;
 document.getElementById("forward_button").disabled = true;

 if(in_auto_mode = 1)
    {
      clearInterval(setInt_var);
      in_auto_mode = 0;
      document.getElementById("manual_mode").style.display = "none";
      document.getElementById("auto_show").disabled = false; 
    }

  change_my_image(button_value,image_number,images_in_set,photo_set_name,base_dir);
  
}



function change_my_image(button_value,image_number,images_in_set,photo_set_name,base_dir)
{
  document.getElementById("button_val").innerHTML = button_value;
  if (button_value == 0)
     {
       //back
       // auto mode - it might be set. If not set ???
       var image_number = image_number - 1;
       if (image_number == -1)
          {
            document.getElementById("back_button").disabled = true; 
          }
       image_name = get_image_name(image_number);
       switch_image(image_name,photo_set_name,base_dir,image_number,images_in_set); 
     }

  if (button_value == 1)
     {
       
       //forward
       var image_number = image_number + 1;
       
       if (image_number == images_in_set -1 )
          {
            document.getElementById("forward_button").disabled = true; 
          }
       //document.getElementById("image_to_show").src ="";
       image_name = get_image_name(image_number);
       switch_image(image_name,photo_set_name,base_dir,image_number,images_in_set);
        
     }

  if (image_number > 0)
     {
       document.getElementById("back_button").disabled = false; 
     }
  if (image_number < images_in_set -1)
     {
       document.getElementById("forward_button").disabled = false; 
     } 

  if (button_value == 2)
     {
       //close window
       window.close(); 
     }

  if (button_value == 3)
     {
       //auto mode i.e. show the photos in a continuous loop.
              
     }


 //redo the buttons

 document.getElementById("nav_buttons_div").innerHTML = "";
 button_string = create_nav_buttons(image_number,images_in_set,photo_set_name,base_dir);
 document.getElementById("nav_buttons_div").innerHTML = button_string;
 configure_buttons(image_number,images_in_set);
 
}

//--------------- get_image_name ------------- photoset,page_number,base_dir

function get_image_name(image_number)
{
  var cells = document.getElementById('hidden_table').getElementsByTagName('td');
  
  return cells[image_number].innerHTML;
}

// ---------------- Switch_image --------------
// image_name
// photo_set_name base_dir
// image_number
// images_in_set

function loadImage(wrapper_width,wrapper_height,wrapperAspectRatio,photo_frame_width,photo_frame_height)
{
  image_dimensions_a = object_details_photo("image_to_show");
  //natural image info
  image_dimensions_a = object_details_photo("image_to_show");
  var image_width = image_dimensions_a[2];
  var image_height = image_dimensions_a[3]; 
  var imageAspectRatio = image_width / image_height;

  document.getElementById("nat_w").innerHTML = image_width;
  document.getElementById("nat_h").innerHTML = image_height;
  document.getElementById("nat_ar").innerHTML = imageAspectRatio.toFixed(4);
  base_uri=document.getElementById("image_to_show").currentSrc;   
  document.getElementById("base_dir").innerHTML = base_uri;  
   
  // is screen width >= screen height
  if (wrapperAspectRatio <= imageAspectRatio)
     {
       var scaleFactor = photo_frame_width / image_width;
       document.getElementById("image_to_show").height = image_height * scaleFactor;
       var image_to_show_width = image_width * scaleFactor;
       document.getElementById("image_to_show").width = image_to_show_width;
      
     }
  else
     {
       var scaleFactor = photo_frame_height / image_height;
       document.getElementById("image_to_show").width = image_width * scaleFactor;
       var image_to_show_height = image_height * scaleFactor;
       document.getElementById("image_to_show").height = image_to_show_height; 

     }
}

 

function switch_image(image_name,photo_set_name,base_dir,image_number,images_in_set)
{
  
  //photo-area-div info
  var wrapper_width = document.getElementById("hide-info-1").innerHTML;
  var wrapper_height = document.getElementById("hide-info-2").innerHTML; 
  var wrapperAspectRatio = wrapper_width / wrapper_height;

  var image_path_name =  base_dir + photo_set_name + "/" + image_name; 
  
  document.getElementById("photo_area_div").width = (wrapper_width / 100) * 80;
  document.getElementById("photo_area_div").height = (wrapper_height / 100) * 80;  

  
  var photo_frame_width = document.getElementById("photo_area_div").width;
  var photo_frame_height=document.getElementById("photo_area_div").height;
 
  //var img = new Image();

  document.getElementById("image_to_show").onload = function(){loadImage(wrapper_width,wrapper_height,wrapperAspectRatio,photo_frame_width,photo_frame_height);};
  document.getElementById("image_to_show").src = image_path_name;
  if (image_number < images_in_set -1)
     { 
       document.getElementById("image_to_show").onclick = function(){back_forward_button(1,image_number,images_in_set,photo_set_name,base_dir);};
     }
  //document.getElementById("image_to_show").onkeypress = function(){back_forward_button(1,image_number,images_in_set,photo_set_name,base_dir);};
  


  // need this for auto mode 
  document.getElementById("current_image_no").innerHTML = image_number;
    
}


function create_nav_buttons(image_number,images_in_set,photo_set_name,base_dir)
{//info button
//image_number starts from 0. Add 1 to image_number so it makes sense to users
human_image_number = image_number + 1; 
button_string = "<div id=\"nav_info_div\"><button id=\"photo_number_button\" type=\"button\">"+human_image_number+" of "+images_in_set+"</button></div>"; 

//back button
  button_string = button_string + "<div id=\"nav_back_div\"><button id=\"back_button\" type=\"button\" onclick=\"back_forward_button(0,"+image_number+","+images_in_set+ ",'"+photo_set_name+ "','"+ base_dir + "')\"><</button></div>";

//next button
  button_string = button_string + "<div id=\"nav_forward_div\"><button id=\"forward_button\" type=\"button\" onclick=\"back_forward_button(1,"+image_number+","+images_in_set+ ",'"+photo_set_name + "','"+ base_dir + "')\">></button></div>";

//back to page of images  
button_string = button_string + "<div id=\"nav_close_div\"><button id=\"close_button\" type=\"button\" onclick=\"x_control('" + photo_set_name + "',1,'" + base_dir + "')\">X</button></div>";

//auto slide show
//button_string = button_string + "<button id=\"auto_show\" type=\"button\" onclick=\"auto_show()\">Auto</button>";
button_string = button_string + "<div id=\"nav_auto_div\"><button id=\"auto_show\" type=\"button\" onclick=\"auto_show(1,"+image_number+","+images_in_set+ ",'"+photo_set_name + "','"+ base_dir + "')\">Auto</button></div>";

//manual control
button_string = button_string + "<div id=\"nav_manual_div\"><button id=\"manual_mode\" type=\"button\" onclick=\"manual_control()\">Maunal</button></div>";

return button_string;
}

//when x is pressed we go back to the "show_page_of_images". Need to shut things down first.
function x_control(photo_set_name,page_number,base_dir)
{
  stopbutton();
  document.getElementById("manual_mode").style.display = "none";
  document.getElementById("auto_show").disabled = false;

  // a image was clicked on a certain page e.g. page 4. Need to return to that page or recalculate
  // which page the current slide image would be on. Using JS rather than php on this occasion. 
  // use id=photo_number_button
  ImageNumberAndTotalImages = document.getElementById("photo_number_button").innerHTML;
  
  var tempArray = ImageNumberAndTotalImages.split(" ");
  var imageNumberXControl = parseInt(tempArray[0]);
  console.log('image number: ',imageNumberXControl);
  var imagesInSetXControl = parseInt(tempArray[2]);
  //32 images per screen
  stepOneCalc = Math.floor(imageNumberXControl / 32);
  console.log('stepOneCalc: ',stepOneCalc);
  modCalc = imageNumberXControl % 32;
  console.log('modCalc: ',modCalc);
  if (stepOneCalc < 1)
     {
       page_number = 1;
     }    
  if (stepOneCalc => 1)
     {
       if (modCalc > 0)
          {
             page_number = stepOneCalc + 1;
          }
       else
          {
             page_number = stepOneCalc;
          }
     }   
  
  console.log('page number: ',page_number);  
  show_page_of_images_ajax(photo_set_name,page_number,base_dir);
}

// stopbutton()
function stopbutton()
{
    if (in_auto_mode == 1) 
       { 
         clearInterval(setInt_var);
         in_auto_mode = 0; 
       }
    else
       {
         clearInterval(setInt_var);
       }
}


function manual_control()
{
  stopbutton();
  document.getElementById("manual_mode").style.display = "none";
  document.getElementById("auto_show").disabled = false;
}

function configure_buttons(image_number,images_in_set)
{
   if (image_number > 0)
     {
       document.getElementById("back_button").disabled = false; 
     }
   else
     {
       document.getElementById("back_button").disabled = true;
     } 
  if (image_number < images_in_set - 1)
     {
       document.getElementById("forward_button").disabled = false; 
     }
  else
     {
       document.getElementById("forward_button").disabled = true; 
     }  

  if (in_auto_mode == 0)
     {
       document.getElementById("manual_mode").style.display = "none";
     }
  else
     {
       document.getElementById("manual_mode").style.display = "inline";
     }    

  if (in_auto_mode == 1) 
       { 
           
          document.getElementById("auto_show").disabled = true;
       }
  

}





function back_to_gallery()
{
  location.replace("photo_gallery.php");
}
      

function test_function_js(number_of_photos)
{
alert(number_of_photos);
}




//RUBBISH
function photoFit(){}









