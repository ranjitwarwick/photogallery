<?php

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
                      //echo "<br>". iterator_count($fi),$subdirPath . "<br>" ;
                      $filesInAlbum = iterator_count($fi);
                      if ($filesInAlbum > 0)
                         { 
                           while (($contents = readdir($forkhandles)) !== false)
                                 if ($contents == ".." or $contents == ".")
                                    { 
                                    }
                                 else 
                                    {
                                      //echo $contents."<br />";
                                      $contentsArray[$contentsCounter] = $contents;
                                      //echo $contentsArray[$contentsCounter] . "<br>";
                                      //echo   "last but one: " . $contentsCounter ;
                                      $contentsCounter++;
                                    }

                           // pick random number for a random photo from set
                           //$upperArrayLimit = $filesInAlbum - 1;  
                           //echo "random: ". $randomNumber = rand(0,$upperArrayLimit);
                           // check if the random item exists - this will be the chosen image for the gallery
                           
                           //echo "<br>";    
                             //       echo $contentsArray[$randomNumber];
                                  
                           //echo "<br>"; 

                           //$contentsArray[$contentsCounter] = $contents[$randomNumber];  
                           //echo "<br>";
                           //echo   "last of all: " . $contentsCounter;
                           //$contentsArray[$contentsCounter] = $contentsArray[$randomNumber];
                           
                           natsort($contentsArray);
                           $SortedContentsArray = array();
                           $x=0; 
                           echo "<br>";
                           //echo $contentsArray[0];
                           foreach ($contentsArray as $value) {
                                   //echo "$value <br>";
                                   $SortedContentsArray[$x] = $value;
                                   $x++;  
                                   }
                           echo "<br>";                             
 
                            

                           echo $galleryPhoto =  $SortedContentsArray[0];   
                           //print_r($contentsArray);
                           // add other data to beginning of array
                           array_unshift($SortedContentsArray,$dir,$subdirOrFile,$galleryPhoto,$filesInAlbum);
                           //echo "<br>";
                           //print_r($contentsArray);
                            

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
/*
echo "<br>";   
print_r($subFolderArray[0]);
echo "<br>";   
echo "<br>";   
print_r($subFolderArray[1]);
echo "<br>"; 
echo "<br>";   
print_r($subFolderArray[2]);
echo "<br>"; 
echo "<br>";   
print_r($subFolderArray[3]);
echo "<br>"; 
echo "<br>";   
print_r($subFolderArray[4]);
echo "<br>"; 
echo "<br>";   
print_r($subFolderArray[5]);
echo "<br>"; 
echo "<br>";   
print_r($subFolderArray[6]);
echo "<br>"; 
echo "<br>";   
print_r($subFolderArray[7]);
echo "<br>"; 
*/
?>



























