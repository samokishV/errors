<?php

function myErrorHandler($errno, $message, $file, $line) {

  //error types
  $errors = array(
    1      =>  "E_ERROR",
    2      =>  "E_WARNING",
    4      =>  "E_PARSE",
    8      =>  "E_NOTICE",
    16     =>  "E_CORE_ERROR", 
    32     =>  "E_CORE_WARNING",
    64     =>  "E_COMPILE_ERROR",
    128    =>  "E_COMPILE_WARNING",
    256    =>  "E_USER_ERROR",
    512    =>  "E_USER_WARNING",
    1024   =>  "E_USER_NOTICE",
    2048   =>  "E_STRICT",
    4096   =>  "E_RECOVERABLE_ERROR",
    8192   =>  "E_DEPRECATED",
    16384  =>  "E_USER_DEPRECATED",
    32767  =>  "E_ALL" 
  );
 
    $type = $errors[$errno];
    $place = " Error on line $line in $file ";
    
    //get error backlog
    ob_start();
    debug_print_backtrace();
    $backlog = ob_get_contents();
    ob_end_clean();
    
    //write error data to file;
    $string = "$message $type $place $backlog";
    my_log($string);
    
}

function my_log($string){
    $log_file_name = $_SERVER['DOCUMENT_ROOT']."/my_log_2.txt";
    $now = date("Y-m-d H:i:s");
    file_put_contents($log_file_name, $now." ".$string."\r\n", FILE_APPEND);
}

set_error_handler("myErrorHandler");

// Trigger error
function division($a, $b) {
  if(!is_numeric($a) || !is_numeric($b)) {
    trigger_error("One of the parameters is not a number", E_USER_ERROR);  
  }

  elseif($b==0) {
    trigger_error("It is impossible to divide by zero", E_USER_WARNING);
  }
  
  else echo $a/$b."<br>";
}

division(8, 4);
division(3, 15);
division(10, 0);
division("�", 10);


?> 