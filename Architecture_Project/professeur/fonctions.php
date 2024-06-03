<?php  
  
  function db_connect() {
    $connection = mysqli_connect("localhost", "root", "", "etuprof");
    if(mysqli_connect_errno()) {
      $msg = "Database connection failed: ";
      $msg .= mysqli_connect_error();
      $msg .= " (" . mysqli_connect_errno() . ")";
      exit($msg);
    }
    return $connection;
  }
   function db_query($connection, $sql) {
    $result_set = mysqli_query($connection, $sql);
    if(substr($sql, 0, 7) == 'SELECT ') {
      confirm_query($result_set);
    }
    return $result_set;
  }

  function confirm_query($result_set) {
    if(!$result_set) {
      exit("Database query failed.");
    }
  }
  

  
 ?>