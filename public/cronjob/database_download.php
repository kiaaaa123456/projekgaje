<?php 

    $mysqlUserName      = 'coder';
    $mysqlPassword      = 'TheBest@123#';
    $mysqlHostName      = 'localhost';
    $DbName             = 'db_lapkin';
   
    

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $database = 'db_lapkin';
    $user = 'coder';
    $pass = 'TheBest@123#';
    $host = 'localhost';
    $dir = '/var/e-lapkin/public/db_lapkin.sql';

    exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);

    // var_dump($output);

    echo json_encode(['status' => 'success', 'message' => 'Download database successfully completed']); 

?>