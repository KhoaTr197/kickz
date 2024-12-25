<?php
//Kiem tra file co phai .csv
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
  //Mo file
  function handleCSV($filepath) {
    return fopen($filepath, "r");
  }
  //Doc file
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

    //Dong file
    fclose($handler);
  }
?>