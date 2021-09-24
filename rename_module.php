<?php	
	//disabling error reporting
    error_reporting(E_ERROR | E_PARSE);

	$presentation_name = $_GET["current_presentation"];
	$new_name = $_GET["rename_module"];
	$init_num = $_GET["init_num"];

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

 		if($init_num == true) {
 			$value = $init_num++;
 		} else {
 			if(($a) > 10) {
	   			$value = $a -1;
	   		} else {
	   			$value = "0".($a-1);
	   		} 	
 		}
 		
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
       
	header('Location: ' . $_SERVER['HTTP_REFERER']);
 } else {
 	header('Location: ' . $_SERVER['HTTP_REFERER']);
 }
 
?>








