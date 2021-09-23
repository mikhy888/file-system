<?php 

$pres_name = $_GET["pres_name"]; 
$dir = "uploads/".$pres_name;

/*creating parent dir for each keymessage*/
 
mkdir('uploads/'.$pres_name.'/'.$pres_name);

/*loop to create keymessge archive*/
$s_files = scandir($dir);
for ($a = 2; $a < count($s_files); $a++) {
    //echo $s_files[$a];

    $filename_n = 'uploads/'.$pres_name.'/'.$pres_name.'/'.$s_files[$a].'.zip';
    $dir_n = "uploads/".$pres_name.'/'.$s_files[$a];
    
    //Zip creater starts from here
    // Get real path for our folder
    $rootPath = realpath($dir_n);
    // Initialize archive object
    $zip = new ZipArchive();
    $zip->open($filename_n, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    // Create recursive directory iterator
    // @var SplFileInfo[] $files 
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    foreach ($files as $name => $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir())
        {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }
    // Zip archive will be created only after closing object
    $zip->close();
} /*loop ends hrere*/


unlink('uploads/'.$pres_name.'/'.$pres_name.'/'.$pres_name.'.zip');


/********************************creating parent zipped files***************************************/


$filename = 'uploads/'.$pres_name.'/'.$pres_name.'.zip';

  $dir = "uploads/".$pres_name."/".$pres_name;

  // Get real path for our folder
  $rootPath = realpath($dir);

  // Initialize archive object
  $zip = new ZipArchive();
  $zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

  // Create recursive directory iterator
  /** @var SplFileInfo[] $files */
  $files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
  );

  foreach ($files as $name => $file) {
    // Skip directories (they would be added automatically)
    if (!$file->isDir()) {
      // Get real and relative path for current file
      $filePath = $file->getRealPath();
      $relativePath = substr($filePath, strlen($rootPath) + 1);

      // Add current file to archive
      $zip->addFile($filePath, $relativePath);
    }
  }

  // Zip archive will be created only after closing object
  $zip->close();

 if (file_exists($filename)) {
    //echo 'test';exit;
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Content-Length: ' . filesize($filename));
    ob_clean();
    flush();

    readfile($filename);
    // delete file
    unlink($filename);
  }

  //$zip->close();


// Create zip
function createZip($zip, $dir)
{
  if (is_dir($dir)) {

    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {

        // If file
        if (is_file($dir . $file)) {
          if ($file != '' && $file != '.' && $file != '..') {

            $zip->addFile($dir . $file);
          }
        } else {
          // If directory
          if (is_dir($dir . $file)) {

            if ($file != '' && $file != '.' && $file != '..') {

              // Add empty directory
              $zip->addEmptyDir($dir . $file);

              $folder = $dir . $file . '/';

              // Read data of the folder
              createZip($zip, $folder);
            }
          }
        }
      }
      closedir($dh);
    }
  }
}


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
deleteDirectory('uploads/'.$pres_name.'/'.$pres_name);






