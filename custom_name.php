<?php 

	$presentation_name = $_GET["current_presentation"];
	$slide_name = $_GET["current_slide"];
	$new_name = $_GET["new_name"];


	/*change html file name*/
	foreach(glob("uploads/".$presentation_name."/".$slide_name."/*html") as $file) {
	   rename($file, "uploads/".$presentation_name."/".$slide_name."/".$new_name.".html");
	}

	/*renaming internal files and folders*/
   	foreach(glob("uploads/".$presentation_name."/".$slide_name."/*jpg") as $jpg_file) {
		if (strpos($jpg_file,'thumb')) {
			rename($jpg_file, "uploads/".$presentation_name."/".$slide_name."/".$new_name."-thumb.jpg");
		} elseif (strpos($jpg_file,'full')) {
			rename($jpg_file, "uploads/".$presentation_name."/".$slide_name."/".$new_name."-full.jpg");
		}
	} 

	
	 foreach(glob("uploads/".$presentation_name."/".$slide_name."/*jpeg") as $jpeg_file) {
	    if (strpos($jpeg_file,'thumb')) {
			rename($jpg_file, "uploads/".$presentation_name."/".$slide_name."/".$new_name."-thumb.jpeg");
		} elseif (strpos($jpeg_file,'full')) {
			rename($jpg_file, "uploads/".$presentation_name."/".$slide_name."/".$new_name."-full.jpeg");
		}
	} 

	
	foreach(glob("uploads/".$presentation_name."/".$slide_name."*png") as $png_file) {
	    if (strpos($png_file,'thumb')) {
			rename($png_file, "uploads/".$presentation_name."/".$slide_name."/".$new_name."-thumb.png");
		} elseif (strpos($png_file,'full')) {
			rename($png_file, "uploads/".$presentation_name."/".$slide_name."/".$new_name."-full.png");
		}
	} 

	//changing name for folder
	rename( "uploads/".$presentation_name.'/'.$slide_name, "uploads/".$presentation_name.'/'.$new_name); 

	header('Location: ' . $_SERVER['HTTP_REFERER']);
 ?>

