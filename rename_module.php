<?php
	
	//disabling error reporting
    error_reporting(E_ERROR | E_PARSE);

	$presentation_name = $_GET["current_presentation"];
	$new_name = $_GET["rename_module"];
 ?>

 <?php

 if( $new_name != "" ){
 	$slides = scandir("uploads/".$presentation_name);

 $value = "";
 function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

 for ($a = 2; $a < count($slides); $a++) {  

 		if(($a) > 10) {
   			$value = $a -1;
   		} else {
   			$value = "0".($a-1);
   		} 

		//check another folder exists with same name
		/*if("uploads/".$presentation_name."/".$slides[$a]."/".$slides[$a] != false) {
			
			echo "child directory is there!";
			
			//changing the files location to parent folder
			if (!function_exists('rec_func'))   {
			    function rec_func($src, $dst) { 
				    //if($dir != false) {
				    	$dir = opendir($src); 
					    @mkdir($dst); 
					    foreach (scandir($src) as $file) { 
					        if (( $file != '.' ) && ( $file != '..' )) { 
					            if ( is_dir($src . '/' . $file) ) 
					            { 
					                rec_func($src . '/' . $file, $dst . '/' . $file); 
					            } 
					            else { 
					                copy($src . '/' . $file, $dst . '/' . $file); 
					            } 
					        } 
					    } 
					    closedir($dir);
				   // }
				}
		    }

			$src = "uploads/".$presentation_name."/".$slides[$a]."/".$slides[$a];
			$dst = "uploads/".$presentation_name."/".$slides[$a];
			rec_func($src, $dst);

			//deleting child folder
			deleteDirectory("uploads/".$presentation_name."/".$slides[$a]."/".$slides[$a]);

		}  else {
			echo "child dierctory is not there!";
		}*/
 		

 		/*renaming internal files and folders*/
       	foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*jpg") as $jpg_file) {
			if (strpos($jpg_file,'thumb')) {
				rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$new_name.$value."-thumb.jpg");
			} elseif (strpos($jpg_file,'full')) {
				rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$new_name.$value."-full.jpg");
			}
		} 

		
		 foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*jpeg") as $jpeg_file) {
		    if (strpos($jpg_file,'full')) {
				rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$new_name.$value."-full.jpeg");
			} elseif (strpos($jpg_file,'thumb')) {
				rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$new_name.$value."-thumb.jpeg");
			}
		} 

		
		foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*png") as $png_file) {
		    if (strpos($jpg_file,'full')) {
				rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$new_name.$value."-full.png");
			} elseif (strpos($jpg_file,'thumb')) {
				rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$new_name.$value."-thumb.png");
			}
		} 
    
		
        foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*html") as $file) {
		    rename($file, "uploads/".$presentation_name."/".$slides[$a]."/".$new_name.$value.".html");
		} 

        rename( "uploads/".$presentation_name.'/'.$slides[$a], "uploads/".$presentation_name.'/'.$new_name.$value); 
 }  
       
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
	 if (!empty($_SERVER['HTTP_REFERER'])) {
	    header("Location: ".$_SERVER['HTTP_REFERER']);
	 } else {
	   echo "No referrer.";
	 }
 } else {
 	//header('Location: ' . $_SERVER['HTTP_REFERER']);
 	if (!empty($_SERVER['HTTP_REFERER'])) {
	    header("Location: ".$_SERVER['HTTP_REFERER']);
	 } else {
	   echo "No referrer.";
	 }
 }
 
?>






