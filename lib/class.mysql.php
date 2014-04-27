<?php

/**
 * Opening, closing and modifying MySQL connection
 *
 * @var string $username The username for the MySQL connection
 * @var string $password The password for the MySQL connection
 * @var string $hostname The hostname for the MySQL connection
 * @var string $database The database name for the MySQL connection
 */
class MySQLConnection {

    var $username="root";
    Var $password="mysql";
    var $hostname="localhost";
    var $database="TickerData";
    var $currentConnection;

    function connectDatabase() {
        $connection = mysql_connect($this->hostname,$this->username,$this->password);
        if(!$connection) {
            die ("Unable to connect to MySQL Database...<br>");
        } else {
            $this->currentConnection = $connection;
            echo "Connected to MySQL Database...<br>";
        }
        return $this->currentConnection;
    }

    function selectDatabase($database) {
        if(!$database){
          $database = $this->database;
        }
        mysql_select_db($database);
        if(mysql_error()){
          echo "Unable to find database: ".$database."...<br>";
        }
        echo "Database selected...<br>";       
    }

    function closeConnection() {
        mysql_close($this->currentConnection);
        echo "Connection closed...<br>";
    }

}

?>