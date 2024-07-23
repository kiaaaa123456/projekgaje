<?php 

   $servername = "localhost";
   $username = "coder";
   $password   = "TheBest@123#";
   $dbname   = "db_tekad_2023";
   $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


   $servername_ = "localhost";
   $username_ = "coder";
   $password_   = "TheBest@123#";
   $dbname_   = "db_lapkin";
   $conn_ = new PDO("mysql:host=$servername_;dbname=$dbname_",$username_, $password_);
   $conn_->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql_delete = "DELETE FROM users";
   $statment_delete = $conn_->prepare($sql_delete);
   $statment_delete->execute();

   $sql_alter = "ALTER TABLE users AUTO_INCREMENT = 1";
   $statment_alter = $conn_->prepare($sql_alter);
   $statment_alter->execute();


   $sql_order = "SELECT * FROM sys_user"; 
   $statment_order = $conn->prepare($sql_order);
   $statment_order->execute();
   $hasil = $statment_order->fetchAll();
   $count = count($hasil);

   for ($i=0; $i < $count; $i++) { 

      $id_monev = $hasil[$i]['userid'];
      $kdprov = $hasil[$i]['kdprov'];
      $kdkab = $hasil[$i]['kdkab'];
      $kdkec = $hasil[$i]['kdkec'];
      $kddesa = $hasil[$i]['kddesa'];
      $company_id = 1;
      $nik = $hasil[$i]['nik'];
      $name = htmlspecialchars($hasil[$i]['fullname']);


      $email = $hasil[$i]['email'];
      $phone = $hasil[$i]['telpno'];
      $image = $hasil[$i]['photo'];
      if ($hasil[$i]['roleid'] == 1 || $hasil[$i]['roleid'] == 25 || $hasil[$i]['roleid'] == 26 || $hasil[$i]['roleid'] == 28 || $hasil[$i]['roleid'] == 29 || $hasil[$i]['roleid'] == 30) {
         $is_admin = 1;   
      } else {
         $is_admin = 0;
      }
      if($kdprov==00) {
         $timezone = 'Asia/Jakarta';   
      } else if($kdprov==53) {
         $timezone = 'Asia/Makassar';   
      } else {
         $timezone = 'Asia/Jayapura';
      }
      $role_id = 4;
      $department_id = $hasil[$i]['roleid'];
      $shift_id = 1;
      $is_email_verified = 'verified';
      $password = $hasil[$i]['password'];
      $status_id = $hasil[$i]['aktif'];
      $address = $hasil[$i]['alamat'];
      $gender = $hasil[$i]['jenis_kelamin'];
      $birth_date = $hasil[$i]['tgl_lahir'];
      $branch_id = 1;
      

      $sql_sync= "INSERT INTO users (id_user_monev, kdprov, kdkab, kdkec, kddesa, company_id, nik, name, email, phone, image, is_admin, role_id, department_id, shift_id, is_email_verified ,password, status_id, address, gender, birth_date, branch_id, time_zone) VALUES ('$id_monev', '$kdprov', '$kdkab', '$kdkec', '$kddesa', '$company_id', '$nik', '$name', '$email', '$phone', '$image', '$is_admin', '$role_id', '$department_id', '$shift_id', '$is_email_verified', '$password', '$status_id', '$address', '$gender', '$birth_date', '$branch_id', '$timezone')";
      $statment_sync = $conn_->prepare($sql_sync);
      $statment_sync->execute();

   }

   echo json_encode(['status' => 'success', 'message' => 'Data has been updated']); 

?>