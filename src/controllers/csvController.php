<?php
  function isCSV($filenames) {
    if(gettype($filenames) == 'array') {
      foreach($filenames as $filename) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        
        if ($extension !== 'csv') {
          return false;
        }
      }
    } else {
      $extension = pathinfo($filenames, PATHINFO_EXTENSION);
        
      if ($extension !== 'csv') {
        return false;
      }
    }

    return true;
  }
  function handleCSV($filepath) {
    return fopen($filepath, "r");
  }
  function readCSV($handler, $callback) {
    $columns=[];
    $rowIdx = 1;

    while(($row = fgetcsv($handler, 1000, ",")) !== false) {
      if($rowIdx === 1) {
        foreach($row as $key => $value) {
          $columns[$value] = $key;
        }         
      } else {
        $callback($row, $columns);
      }
      $rowIdx++;
    }
    fclose($handler);
  }
?>