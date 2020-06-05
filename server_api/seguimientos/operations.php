<?php
 include "../library/config.php";
class Operations{
    // database connection and table name
    private $conn;
    private $table_name = "SeguimientoTrabajos2";
  
    // object properties
    public $id;
    public $name;

  
    // constructor with $db as database connection
    public function __construct(){
        
    }

    public function  getData(){
        $sql = mysqli_query("SELECT * FROM $table_name");
        $RESULT =  mysqli_fetch_array($sql);
        echo $RESULT;
    }
}
?>