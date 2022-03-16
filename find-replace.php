<?php

$find = $_GET["find"];
$replace = $_GET["replace"];
$presentation_name = $_GET["current_presentation"];

if (($find && $replace) != "") {
 
 $slides = scandir("uploads/".$presentation_name);
 
 for ($a = 2; $a < count($slides); $a++) {  

	 foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*html") as $file) {
	 	$filename = basename($file);
	 	$file_new_name = str_replace($find, $replace, $filename);
	  rename($file, "uploads/".$presentation_name."/".$slides[$a]."/".$file_new_name);
	  $path_to_file = "uploads/".$presentation_name."/".$slides[$a]."/".$file_new_name;
	  $file_contents = file_get_contents($path_to_file);
	  $file_contents = str_replace($find, $replace,$file_contents);
	  file_put_contents($path_to_file,$file_contents);
	 }


	 foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/scripts/*js") as $filejs) {
	  $filename = basename($filejs);
	  $path_to_file = $filejs;

	  $file_contents = file_get_contents($path_to_file);
	  $file_contents = str_replace($find, $replace,$file_contents);
	  file_put_contents($path_to_file,$file_contents);
	 }


	  foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*jpg") as $jpg_file) {
		 	$filename = basename($jpg_file);
		 	$file_new_name = str_replace($find, $replace, $filename);
		  rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$file_new_name);	
	  }

		foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*jpeg") as $jpg_file) {
		 	$filename = basename($jpg_file);
		 	$file_new_name = str_replace($find, $replace, $filename);
		  rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$file_new_name);	
	  }

	  foreach(glob("uploads/".$presentation_name."/".$slides[$a]."/*png") as $jpg_file) {
		 	$filename = basename($jpg_file);
		 	$file_new_name = str_replace($find, $replace, $filename);
		  rename($jpg_file, "uploads/".$presentation_name."/".$slides[$a]."/".$file_new_name);	
	  }

	 /*change in folder name*/
 	 $name_existing_for_folder = "uploads/".$presentation_name.'/'.$slides[$a];
   $new_name_for_folder = str_replace($find, $replace, $name_existing_for_folder);

   rename( "uploads/".$presentation_name.'/'.$slides[$a], $new_name_for_folder);

 }

 header("Location: ".$_SERVER['HTTP_REFERER']);

}

?>