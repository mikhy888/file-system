<?php

$d_method = $_GET["method"];
$pres_name = $_GET["pres_name"];


$filename = 'uploads/'.$pres_name.'.zip';

  $dir = "uploads/".$pres_name;

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

// Redirecting back
//header("Location: " . $_SERVER["HTTP_REFERER"]);
