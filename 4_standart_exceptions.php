<?php
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

function my_log($string){
    $log_file_name = $_SERVER['DOCUMENT_ROOT']."/my_log_4.txt";
    $now = date("Y-m-d H:i:s");
    file_put_contents($log_file_name, $now." ".$string."\r\n", FILE_APPEND);
}

function foo($arg) {
    global $errors;
    
    try {
      $func = 'do' . $arg;
      if (!is_callable($func)) {
          throw new BadFunctionCallException('Function ' . $func . ' is not callable', 32767);
      }
    }
    catch(BadFunctionCallException $e) {    
      $message = $e->getMessage();
      $type = $errors[$e->getCode()];
      $place = " Error on line ". $e->getLine()." in ".$e->getFile();
      $backtrace = $e->getTraceAsString(); 
      
      $string = "$message $type $place $backtrace";
      my_log($string);     
    }
}

foo('my');

function division($a, $b) {
  global $errors;

  try {
    if(!is_numeric($a) || !is_numeric($b)) {
     throw new InvalidArgumentException("One of the parameters is not a number", 32767);  
    }
  }
  catch(InvalidArgumentException $e) {    
    $message = $e->getMessage();
    $type = $errors[$e->getCode()];
    $place = " Error on line ". $e->getLine()." in ".$e->getFile();
    $backtrace = $e->getTraceAsString(); 
    
    $string = "$message $type $place $backtrace";
    my_log($string);     
  }  
}

division("a", 1);

?>
