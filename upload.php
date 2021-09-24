<?php

//disabling error reporting
error_reporting(E_ERROR | E_PARSE);

//Deleting existing dir
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


//checking file is uploaded or not
if(isset($_FILES['file'])) {

   $folder_name = "uploads/".basename($_FILES["file"]["name"], '.zip');
  
   if (!file_exists($folder_name)) {

    $file = $_FILES["file"];

    //move to temporary path
    move_uploaded_file($file["tmp_name"], "uploads/" . $file["name"]);
    $foldername = $file["name"];
    $foldername_new = basename($file["name"], '.zip');

    $zip = new ZipArchive;
    $res = $zip->open("uploads/".$foldername);

    //extract the presentation
    if ($res === TRUE) {
      $zip->extractTo('uploads/'.$foldername_new);


    //check another folder exists with same name            
    if("uploads/".$foldername_new."/".$foldername_new) {
      
      //echo "child directory is there!";
      
      //changing the files location to parent folder
      if (!function_exists('rec_func'))   {
          function rec_func($src, $dst) { 
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
        }
        }

      $src = "uploads/".$foldername_new."/".$foldername_new;
      $dst = "uploads/".$foldername_new;
      rec_func($src, $dst);

      //deleting child folder
      deleteDirectory("uploads/".$foldername_new."/".$foldername_new);

    }  else {
      echo "child dierctory is not there!";
    }


     //Extracting all the files
      $files = scandir("uploads/".$foldername_new."/");
      for ($a = 2; $a < count($files); $a++) {
         echo $files[$a]; // single file name
         if($zip->open("uploads/".$foldername_new.'/'.$files[$a]) === TRUE) {
          $zip->extractTo('uploads/'.$foldername_new.'/'.basename($files[$a], '.zip')); 
          $zip->close();
          unlink('uploads/'.$foldername_new.'/'. $files[$a]);
         }
      }

      $zip->close();
      unlink("uploads/".$foldername);
      echo 'File extraction successfull!';
    } else {
      echo 'File extraction got some error!';
    }

    //checking KM is zipped or not
    $files1 = scandir("uploads/".$foldername_new."/");
        for ($a = 2; $a < count($files1); $a++) {  
            if("uploads/".$foldername_new."/".$files1[$a]."/".$files1[$a] != false) {
            echo "child directory is there inner";
            //changing the files location to parent folder
           if (!function_exists('rec_funca'))   {
                function rec_funca($src1, $dst1) { 
                    $dir1 = opendir($src1); 
                    @mkdir($dst1); 
                    foreach (scandir($src1) as $file1) { 
                        if (( $file1 != '.' ) && ( $file1 != '..' )) { 
                            if ( is_dir($src1 . '/' . $file1) ) 
                            { 
                                rec_funca($src1 . '/' . $file1, $dst1 . '/' . $file1); 
                            } 
                            else { 
                                copy($src1 . '/' . $file1, $dst1 . '/' . $file1); 
                            } 
                        } 
                    } 
                    closedir($dir1);
                }
            }

            $src1 = "uploads/".$foldername_new."/".$files1[$a]."/".$files1[$a];
            $dst1 = "uploads/".$foldername_new."/".$files1[$a];
            rec_funca($src1, $dst1);

            //deleting child folder
            deleteDirectory("uploads/".$foldername_new."/".$files1[$a]."/".$files1[$a]);

        }  else {
            echo "child dierctory is not there!";
        }
    }   


    header("Location: index.php?result=success");

   } else {
     echo "Same presentation name already exists.";
     //header("Location: index.php?result=failed");
     if (!empty($_SERVER['HTTP_REFERER'])) {
        //header("Location: ".$_SERVER['HTTP_REFERER']);
        header("Location: index.php?result=failed");
     } else {
       echo "No referrer.";
     }
   }
}

//header('Location: ' . $_SERVER['HTTP_REFERER']);

// Redirecting back
//header("Location: " . "index.php"); 

