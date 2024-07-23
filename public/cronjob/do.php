<?php 

   $servername = "localhost";
   $username = "coder";
   $password   = "TheBest@123#";
   $dbname   = "db_lapkin";
   // $date = date('Y-m-d 23:59:59');
   $date = date("Y-m-d 00:00:00", time() + 86400);
   // $date_now = date("Y-m-d", time() - 86400);
   $date_now = date("Y-m-d");

   $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql_order = "SELECT * FROM  attendances WHERE check_out IS NULL";
   $statment_order = $conn->prepare($sql_order);
   $statment_order->execute();
   $hasil = $statment_order->fetchAll();
   $count = count($hasil);


   if($count > 0) {

   	

	   for ($i=0; $i < $count; $i++) { 
        
        $id = $hasil[$i]['id'];
        $check_location = "SELECT check_in_location FROM attendances WHERE id='$id'";
        $statment_max = $conn->prepare($check_location);
        $statment_max->execute();
        $hasil_loc = $statment_max->fetchAll();
        $location = $hasil_loc['0']['check_in_location'];
        $stringLocation = preg_replace('/[^A-Za-z0-9]/', '', $location);

        $sql= "UPDATE attendances SET check_out_location='$stringLocation', check_out = '$date', out_status='CJ' WHERE id='$id'";
	     $statment = $conn->prepare($sql);
	     $statment->execute();

    	}

      $check_second = "SELECT timestampdiff(second, check_in, check_out) AS detik, check_in ,id FROM attendances WHERE id='$id' AND date='$date_now'";
      $statment_second = $conn->prepare($check_second);
      $statment_second->execute();
      $hasil_second = $statment_second->fetchAll();
      $check_in = $hasil_second['0']['check_in'];
      $second = $hasil_second['0']['detik'];
      $id_second = $hasil_second['0']['id'];


      if ($second > 28800) {

           
           $second = 28800;

           $check_out =  date("Y-m-d H:i:s", (strtotime(date($check_in)) + $second));
           
           $check_out =  date("Y-m-d H:i:s", (strtotime(date($check_in)) + $second));
           
           $sql= "UPDATE attendances SET check_out = '$check_out', out_status='CJ' WHERE id='$id_second'";
           $statment = $conn->prepare($sql);
           $statment->execute();
      }

      $sql_cron= "INSERT INTO cronjob (date, total, status) VALUES ('$date_now', '$count', 'success')";
      $statment_cron = $conn->prepare($sql_cron);
      $statment_cron->execute();

      echo json_encode(['status' => 'cronjob success']); 
      echo 'ok';

   } else if($count == 0) {

      $sql_cron= "INSERT INTO cronjob (date, total, status) VALUES ('$date_now', '$count', 'empty')";
      $statment_cron = $conn->prepare($sql_cron);
      $statment_cron->execute();

      echo json_encode(['status' => 'cronjob empty']); 
      echo 'ok';

   } else {

      $sql_cron= "INSERT INTO cronjob (date, total, status) VALUES ('$date_now', '$count', 'failed')";
      $statment_cron = $conn->prepare($sql_cron);
      $statment_cron->execute();

      echo json_encode(['status' => 'cronjob failed']); 

   }
   

?>