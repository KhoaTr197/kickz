<?php
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