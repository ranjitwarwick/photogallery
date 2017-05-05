<?php
$dir = "photos";
if (is_dir($dir))
 {
   // open main photos folder
   if ($dh = opendir($dir))
   {
      //read contents - not interested in .. and . though
      while (($file = readdir($dh)) !== false)
      {
         if ($file == ".." or $file == ".")
            {
              //echo "not a file" .$file ."<br>";
            }
         else
            {
             //echo "This folder within ". $dir." is " . $file . "<br>";
             //echo "checking: ".$dir."/".$file."<br>";
             // now working on the sub directories
             $subdir = $dir."/".$file;
                  if (is_dir($dir ."/". $file))
                     {
                      //echo "<br> yes ". $file ." is a dir<br>";
                      $forkhandles = opendir($subdir);
                       $fi = new FilesystemIterator($subdir, FilesystemIterator::SKIP_DOTS);
                       //printf("<br>There were %d Files in %s <br>" , iterator_count($fi),$subdir );
                       echo "<br>". iterator_count($fi),$subdir . "<br>" ;
                         
                      //----------------------------------------------
                        while (($filesinsub = readdir($forkhandles)) !== false)
                               {
                                 //---------
                                 if ($filesinsub == ".." or $file == ".")
                                    {
                                      //do nothing
                                    }
                                 else
                                  {     
                                 //---------
                                  // echo "Reading ".$filesinsub;
                                  } 
                               }
                              closedir($forkhandles);
                      //----------------------------------------------
                          
                     }
                  else
                     {
                        //echo "no " . $file . " is not a dir<br>";
                     } 


 
            }
     }
     closedir($dh);
   }
}


echo " <br> Random number: ". (rand(10,100));


//printf("<br>There were %d Files", 785);






?>

















