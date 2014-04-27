<?php

  //includes
  include ('lib/class.mysql.php');
  include ('lib/class.IQimport.php');

  //connect to database
  $connection = new MySQLConnection();
  $connection->connectDatabase();
  $database = "TickerData";
  $connection->selectDatabase($database);

//for each text file in the import folder, create array and import values to MySQL database
$files = glob('import/*.{txt}', GLOB_BRACE);
foreach($files as $file) {

  $IQimport = new IQimport();
  //parse imported text file
  $minutes = $IQimport->getArrayFromImport($file);

  //get symbol from filename
  $folderName = "import/";
  $symbol = $IQimport->getSymbolFromFilename($file, $folderName, ".txt");

  //generating sql statement and inserting into database
  $sql = $IQimport->getSqlFromArray($minutes, $symbol);
  mysql_query($sql) or exit(mysql_error()); 

  //echo "<pre>";
  //print_r($minutes); 
  //echo "</pre>";
}

?>
