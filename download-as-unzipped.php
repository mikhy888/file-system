<?php 

$pres_name = $_GET["pres_name"]; 
$dir = "uploads/".$pres_name;

/*creating parent dir for each keymessage*/
mkdir('uploads/'.$pres_name.'/'.$pres_name);

function custom_copy($src, $dst) {
  $dir = opendir($src);
  @mkdir($dst);
  while( $file = readdir($dir) ) {
      if (( $file != '.' ) && ( $file != '..' )) {
          if ( is_dir($src . '/' . $file) ) {
              custom_copy($src . '/' . $file, $dst . '/' . $file);
          }
          else {
              copy($src . '/' . $file, $dst . '/' . $file);
          }
      }
  }
  closedir($dir);
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

function zipper($filename, $dir) {
  if( $dir != "" ) {
      $rootPath = realpath($dir);
      $zip = new ZipArchive();
      $zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);
      if ($rootPath != "") {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
      }
      foreach ($files as $name => $file)
      {
          if (!$file->isDir())
          {
              $filePath = $file->getRealPath();
              $relativePath = substr($filePath, strlen($rootPath) + 1);
              $zip->addFile($filePath, $relativePath);
          }
      }
      $zip->close();
    }
}

/*loop to create keymessge archive*/
$s_files = scandir($dir);
for ($a = 2; $a < count($s_files); $a++) {
    //echo $s_files[$a];

    if( $s_files[$a] != $pres_name) {
      mkdir('uploads/'.$pres_name.'/'.$pres_name.'/'.$s_files[$a]);
      mkdir('uploads/'.$pres_name.'/'.$pres_name.'/'.$s_files[$a].'/'.$s_files[$a]);

      
      custom_copy('uploads/'.$pres_name.'/'.$s_files[$a], 'uploads/'.$pres_name.'/'.$pres_name.'/'.$s_files[$a].'/'.$s_files[$a]);
    }

    /*$filename_n = 'uploads/'.$pres_name.'/'.$pres_name.'/'.$s_files[$a].'.zip';
    $dir_n = 'uploads/'.$pres_name.'/'.$pres_name.'/'.$s_files[$a];
    zipper($filename_n, $dir_n);
    deleteDirectory('uploads/'.$pres_name.'/'.$pres_name.'/'.$s_files[$a]); */

} /*loop ends hrere*/

/********************************creating parent zipped files***************************************/

  $filename = 'uploads/'.$pres_name.'/'.$pres_name.'.zip';
  $dir = "uploads/".$pres_name."/".$pres_name;

  zipper($filename, $dir);

 if (file_exists($filename)) {
    //echo 'test';exit;
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Content-Length: ' . filesize($filename));
    ob_clean();
    flush();

    readfile($filename);
    unlink($filename);
  }

  deleteDirectory('uploads/'.$pres_name.'/'.$pres_name);


header('Location: ' . $_SERVER['HTTP_REFERER']);


