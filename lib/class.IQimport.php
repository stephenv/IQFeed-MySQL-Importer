<?php

/**
 * Importing IQFeed Qcollector text files into MySQL
 */
class IQimport {

  function getSymbolFromFilename($file, $folderName, $filetype){
      //include trailing slash
      $symbolFile=str_replace($folderName, "", $file);
      //include period
      $symbol = str_replace($filetype, "", $symbolFile);
      $symbol = substr($symbol, 0, -2);
      return $symbol;
  }

  function getArrayFromImport($file){
      ini_set('auto_detect_line_endings', true);
      $fh = fopen($file, 'r');
      while (($line = fgetcsv($fh, 1000, "\t")) !== false) {
        $minutes[] = $line;
      }
      fclose($fh);
      return $minutes;
  }

  function getSqlFromArray($minutes, $symbol){
    $sql = "INSERT INTO prices (symbol, date, time, open, high, low, close, volume) values ";
      
      $valuesArray = array();
      foreach($minutes as $row) {
        //format date for insertion
        $date = $row[0];
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
        //format time for insertion
        $time = date('G:i',strtotime($row[1]));
        //formatting prices and volume for insertion 
        $open = sprintf("%0.4f",$row[2]);
        $high = sprintf("%0.4f",$row[3]);
        $low = sprintf("%0.4f",$row[4]);
        $close = sprintf("%0.4f",$row[5]);
        $volume = (int) $row[6];
        $valuesArray[] = "('$symbol', '$date', '$time', '$open', '$high', '$low', '$close', '$volume')";
      }

    $sql .= implode(',', $valuesArray);
    return $sql;
  }

}

?>
