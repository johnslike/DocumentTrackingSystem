
<?php

Class JOS {

    private $server = "mysql:host=localhost;dbname=dts_database";
    private $user = "root";
    private $pass = "123456";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>
    PDO::FETCH_ASSOC);
    protected $con;

    public function openConnection()
    {
        try{

            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;

        }
            catch(PDOException $e)
            {
                echo "There is some problem in connection :".$e->getMessage();
            }
        }

    public function closeConnection()
    {
        $this->con - null;
    }



    public function getAccounts()
    {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT t1.id, t1.username, t1.password, t1.access, t1.date_added, t1.date_updated, t2.fname, t2.minitial, t2.lname, t2.suffix, t3.division FROM setting_accounts t1 LEFT JOIN setting_users t2 ON t1.user_id = t2.id LEFT JOIN setting_divisions t3 ON t2.division_id = t3.id ORDER BY t3.division");
        $stmt->execute();
        $users = $stmt->fetchAll();
        $userCount = $stmt->rowCount();

        if($userCount > 0){
            return $users;
        }else{
            return 0;
        }

    }


    public function login(){

            if(!isset($_SESSION)){
                session_start();
            }

        if(isset($_POST['login'])){

            $username = $_POST['username'];
            $password = $_POST['password'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("SELECT t1.username, t1.password, t1.access, t2.id, t2.fname, t2.minitial, t2.lname, t2.suffix, t2.division_id, t2.picture FROM setting_accounts t1 LEFT JOIN setting_users t2 ON t1.user_id = t2.id WHERE username = ? AND `password` = ?");
                $stmt->execute([$username, $password]);
                $user = $stmt->fetch();
                $total = $stmt->rowCount();

                if($total > 0){
                    // $user_id = $user['id'];

                        if($user['access'] == "Admin"){
                              header("Location: ../admin/home");
                          }elseif($user['access'] == "User"){
                              header("Location: ../accounts/documents");
                          }

                    $this->set_userdata($user);
                }else{
                    header("location:login.php?msg=failed");

                }
        }
    }


    public function set_userdata($array)
    {
        if(!isset($_SESSION)){
            session_start();
        }

        $_SESSION['userdata'] = array(
            "fname" => $array['fname'],
            "minitial" => $array['minitial'],
            "lname" => $array['lname'],
            "suffix" => $array['suffix'],
            "access" => $array['access'],
            "id" => $array['id'],
            "division_id" => $array['division_id'],
            "picture" => $array['picture']

        );

        return $_SESSION['userdata'];

    }



    public function get_userdata()

    {
        if(!isset($_SESSION)){
            session_start();
        }

        if(isset ($_SESSION['userdata'])){
            return $_SESSION['userdata'];
        }else{
            return null;
        }

    }


    public function logout()
    {
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['userdata'] = null;
        unset($_SESSION['userdata']);
    }


    public function check_emp_id_exist($emp_id){


      $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT * FROM setting_users WHERE employee_id = ?");
      $stmt->execute([$emp_id]);
      $total = $stmt->rowCount();

      return $total;
}


    public function check_position_exist($position){


                $connection = $this->openConnection();
                $stmt = $connection->prepare("SELECT * FROM setting_positions WHERE position = ?");
                $stmt->execute([$position]);
                $total = $stmt->rowCount();

                return $total;
    }


    public function check_employee_exist($fullname){


                $connection = $this->openConnection();
                $stmt = $connection->prepare("SELECT * FROM employees WHERE employee = ?");
                $stmt->execute([$fullname]);
                $total = $stmt->rowCount();

                return $total;
    }



    public function check_user_exist($username){


        $connection = $this->openConnection();
                $stmt = $connection->prepare("SELECT * FROM setting_accounts WHERE username = ?");
                $stmt->execute([$username]);
                $total = $stmt->rowCount();

                return $total;
    }


    public function getNewlyDocument($id){


                $connection = $this->openConnection();
                $stmt = $connection->prepare("SELECT t1.*, t2.division FROM (SELECT * from documents WHERE division_id = ?) t1 LEFT JOIN setting_divisions t2 ON t1.division_id = t2.id");
                $stmt->execute([$id]);
                $Details = $stmt->fetchall();
                $total= $stmt->rowCount();

                if($total > 0){
                    return $Details;
                }else{
                    return FALSE;
                }

                }


                public function add_employee()
                {
                    if(isset($_POST['add_employee']))
                    {
                        $emp_id = $_POST['emp_id'];
                        $fname = $_POST['fname'];
                        $mnitial = $_POST['mnitial'];
                        $lname = $_POST['lname'];
                        $suffix = $_POST['suffix'];
                        $position = $_POST['position'];
                        $division = $_POST['division'];
                        $contact_no = $_POST['contact_no'];
                        $email_add = $_POST['email_add'];
                        $address = $_POST['address'];
                        $gender = $_POST['gender'];
                        $civil_status = $_POST['civil_status'];
                        $bday = $_POST['bday'];

                        if($this->check_emp_id_exist($emp_id) == 0)
                        {

                            $connection = $this->openConnection();
                            $stmt = $connection->prepare("INSERT INTO setting_users(`employee_id`, `fname`, minitial, `lname`, suffix, division_id, position_id, birth_date, `address`, `gender`, `civil_status`, `contact_no`, email_add) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt->execute([$emp_id,$fname,$mnitial,$lname,$suffix,$division,$position,$bday,$address,$gender,$civil_status,$contact_no,$email_add]);

                            echo header ("Location: employees");

                        }else{

                            echo header ("Location: employees");
                      }


                    }
                }


    public function add_document(){


        if(isset($_POST['add_document'])){

            $user_id = $_POST['user_id'];
            $division_id = $_POST['division_id'];
            $tracking_no = $_POST['tracking_no'];
            $subject = $_POST['subject'];
            $type = $_POST['type'];
            $status = $_POST['status'];

            {

                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO `documents`(`tracking_no`, `subject`, `type`, `division_id`, `creator_id`, `status`) VALUES(?,?,?,?,?,?)");
                $stmt->execute([$tracking_no, $subject, $type, $division_id, $user_id, $status]);

              //   if($stmt === TRUE){
              //   $_SESSION['msg'] = "Thanks!";
              //   $_SESSION['msg_status'] = "success!";

              // }

              // echo header("Location:../accounts/documents");

                    echo header("Location:../accounts/documents?msg=add_document");

            }
        }

        }


    public function receive_new_document(){


        if(isset($_POST['receive_document'])){

            $document_id = $_POST['document_id'];
            $tracking_no = $_POST['tracking_no'];
            $acted_division = $_POST['acted_division'];
            $user_id = $_POST['user_id'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'];

            {

                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO `document_log`(`document_id`, `tracking_no`, `acted_by_division_id`, `acted_by_user_id`, `status`, `remarks`) VALUES(?,?,?,?,?,?)");
                $stmt->execute([$document_id, $tracking_no, $acted_division, $user_id, $status, $remarks]);

                $connection->query("UPDATE `documents` SET `route_to_division_id` = '$acted_division', `acted_by_user_id` = '$user_id', `status` = '$status', `latest_remarks` = '$remarks' WHERE `id` = '$document_id'");

                echo header("Location:../accounts/documents");

            }
        }

        }


    public function end_cycle_document(){


        if(isset($_POST['end_cycle_document'])){

            $document_id = $_POST['document_id'];
            $tracking_no = $_POST['tracking_no'];
            $end_to_division_id = $_POST['end_to_division_id'];
            $user_id = $_POST['user_id'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'];

            {

                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO `document_log`(`document_id`, `tracking_no`, `acted_by_division_id`, `acted_by_user_id`, `status`, `remarks`) VALUES(?,?,?,?,?,?)");
                $stmt->execute([$document_id, $tracking_no, $end_to_division_id, $user_id, $status, $remarks]);

                $connection->query("UPDATE `documents` SET `status` = '$status', `latest_remarks` = '$remarks' WHERE `id` = '$document_id'");

                echo header("Location:../accounts/documents");

            }
        }

        }


    public function forward_new_document(){


        if(isset($_POST['forward_new_document'])){

            $document_id = $_POST['document_id'];
            $tracking_no = $_POST['tracking_no'];
            $routed_to_division_id = $_POST['routed_to_division_id'];
            $from_division_id = $_POST['from_division_id'];
            $user_id = $_POST['user_id'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'];

            {

                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO `document_log`(`document_id`, `tracking_no`, `acted_by_division_id`, `acted_by_user_id`, `status`, `remarks`) VALUES(?,?,?,?,?,?)");
                $stmt->execute([$document_id, $tracking_no, $routed_to_division_id, $user_id, $status, $remarks]);

                $connection->query("UPDATE `documents` SET `route_to_division_id` = '$routed_to_division_id', `acted_by_user_id` = '$user_id', `status` = '$status', `from_division_id` = '$from_division_id', `latest_remarks` = '$remarks' WHERE `id` = '$document_id'");

                echo header("Location:../accounts/documents");


            }
        }

        }


    public function return_to_sender(){


        if(isset($_POST['return_to_sender'])){

            $document_id = $_POST['document_id'];
            $tracking_no = $_POST['tracking_no'];
            $from_division_id = $_POST['from_division_id'];
            $user_id = $_POST['user_id'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'];

            {

                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO `document_log`(`document_id`, `tracking_no`, `acted_by_division_id`, `acted_by_user_id`, `status`, `remarks`) VALUES(?,?,?,?,?,?)");
                $stmt->execute([$document_id, $tracking_no, $from_division_id, $user_id, $status, $remarks]);

                $connection->query("UPDATE `documents` SET `route_to_division_id` = '$from_division_id', `acted_by_user_id` = '$user_id', `status` = '$status', `latest_remarks` = '$remarks' WHERE `id` = '$document_id'");

                echo header("Location:../accounts/documents");


            }
        }

        }


    public function add_account()
    {
        if(isset($_POST['add_account']))
        {

            $employee = $_POST['employee'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $access = $_POST['access'];

            if($this->check_user_exist($username) == 0)
            {
                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO setting_accounts(`user_id`, `username`, `password`, `access`) VALUES(?,?,?,?)");
                $stmt->execute([$employee, $username, $password, $access]);

                echo header ("Location: accounts");
            }else{
                echo header ("Location: accounts");
            }

        }
    }


    public function add_user()
    {
        if(isset($_POST['add_user']))
        {

            $fname = $_POST['fname'];
            $mintial = $_POST['mintial'];
            $lname = $_POST['lname'];
            $suffix = $_POST['suffix'];
            $division = $_POST['division'];
            $position = $_POST['position'];


                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO setting_users(`fname`, `minitial`, lname, suffix, division_id, position_id) VALUES(?,?,?,?,?,?)");
                $stmt->execute([$fname,$mintial,$lname,$suffix,$division,$position]);

                echo header ("Location: setting_users.php");


        }
    }



    public function add_position()
    {
        if(isset($_POST['add_position']))
        {

            $position = $_POST['position'];

            if($this->check_position_exist($position) == 0)
            {
                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO setting_positions(`position`) VALUES(?)");
                $stmt->execute([$position]);

                echo header ("Location: setting_positions.php");
            }else{

              echo header ("Location: setting_positions.php");
        }

        }
    }


    public function add_division()
    {
        if(isset($_POST['add_division']))
        {

            $position = $_POST['division'];

            if($this->check_position_exist($position) == 0)
            {
                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO setting_divisions(`division`) VALUES(?)");
                $stmt->execute([$position]);

                echo header ("Location: setting_divisions.php");
            }else{

              echo header ("Location: setting_divisions.php");
        }

        }
    }


    public function add_files()
{
    if(isset($_POST['upload']))
    {

      $user_id = $_POST["user_id"];
      $id = $_POST["id"];
      $tracking_no = $_POST["tracking_no"];
      $title = $_POST["subject"];

      $name_array = $_FILES['files']['name'];
      $tmp_name_array = $_FILES['files']['tmp_name'];
      // Number of files
      $count_tmp_name_array = count($tmp_name_array);

      $N = count($title);


      for($i = 0; $i < $count_tmp_name_array; $i++){
         // Get extension of current file

         $numbers = rand(0,100000);
         $extension = pathinfo($name_array[$i] , PATHINFO_EXTENSION);

         for($j=0; $j < $N; $j++){
          $rename=$title[$j].date('m-d-Y-').$numbers.".".$extension;

        }

          // We define the static final name for uploaded files (in the loop we will add an number to the end)
          $static_final_name = $rename;


         // Pay attention to $static_final_name
         if(move_uploaded_file($tmp_name_array[$i], "../files/document_files/".$static_final_name)){
          $connection = $this->openConnection();
          $stmt = $connection->prepare("INSERT INTO files(`document_id`, `tracking_no`, `renamed`, `original_name`, uploaded_by) VALUES(?,?,?,?,?)");
          $stmt->execute([$id, $tracking_no, $static_final_name, $name_array[$i], $user_id]);
            echo header("Location:DocumentDetails?id=".$id);
         } else {
            echo "move_uploaded_file function failed for ".$name_array[$i]."<br>";
         }

        }
    }

     }


     public function add_photo()
     {
         if(isset($_POST['add_photo']))
         {

         #retrieve file title
         $id = $_POST["id"];
         $title = $_POST["fullname"];

         $date = date('m-d-Y H:i:s');

         $oldname=$_FILES['file']['name'];
         $extension = pathinfo($oldname,PATHINFO_EXTENSION);
         $randomno=rand(0,100000);
         $rename=$title.date('m-d-Y-').$randomno;

         $newname=$rename.'.'.$extension;
         $filename=$_FILES['file']['tmp_name'];

         if(move_uploaded_file($filename, '../files/profile_pic/'.$newname))
         {

                 $connection = $this->openConnection();
                 $connection->query("UPDATE `setting_users` SET `picture` = '$newname' WHERE `id` = '$id'");

                 echo header("Location:profile?id=".$id);
         }
         else
             {
                 echo "not uploaded";
             }
         }
     }


     public function employee_file()
     {
         if(isset($_POST['employee_file']))
         {

         #retrieve file title
         $id = $_POST["id"];
         $file_name = $_POST["file_name"];
         $title = $_POST["fullname"];

         $date = date('m-d-Y H:i:s');

         $oldname=$_FILES['file']['name'];
         $extension = pathinfo($oldname,PATHINFO_EXTENSION);
         $randomno=rand(0,100000);
         $rename=$title.date('m-d-Y-').$randomno;

         $newname=$rename.'.'.$extension;
         $filename=$_FILES['file']['tmp_name'];

         if(move_uploaded_file($filename, '../files/employee_files/'.$newname))
         {

                 $connection = $this->openConnection();
                 $stmt = $connection->prepare("INSERT INTO employee_files(`employee_id`, `file_name`, `rename_file`) VALUES(?,?,?)");
                 $stmt->execute([$id, $file_name, $newname]);

                 echo header("Location:profile?id=".$id);
         }
         else
             {
                 echo "not uploaded";
             }
         }
     }


    public function show_404(){

        http_response_code(404);
        echo "Page not found";
        die;

    }


    public function getUsers()
    {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT t1.id, t1.employee_id, t1.fname, t1.minitial, t1.lname, t1.suffix, t1.date_added, t2.position, t2.id as pos_id, t3.division, t3.id as div_id FROM setting_users t1 LEFT JOIN setting_positions t2 ON t1.position_id = t2.id LEFT JOIN setting_divisions t3 ON t1.division_id = t3.id ORDER BY t1.date_added DESC");
        $stmt->execute();
        $emp = $stmt->fetchAll();
        $userCount = $stmt->rowCount();

        if($userCount > 0){
            return $emp;
        }else{
            return 0;
        }

    }


    public function get_files($id){

      $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT t1.id, t2.id as file_id, t2.* FROM (SELECT * from documents WHERE id = ?) t1 LEFT JOIN files t2 on t1.id = t2.document_id ORDER BY t2.date_added DESC");
      $stmt->execute([$id]);
      $file = $stmt->fetchall();
      $total= $stmt->rowCount();
      if($total > 0){
          return $file;
      }else{
          return FALSE;
      }

      }


    public function getEmployeeFile($id){

      $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT t1.id, t2.* FROM (SELECT * FROM setting_users WHERE id = ?) t1 LEFT JOIN employee_files t2 on t1.id = t2.employee_id ORDER BY t2.date_added DESC");
      $stmt->execute([$id]);
      $file = $stmt->fetchall();
      $total= $stmt->rowCount();
      if($total > 0){
          return $file;
      }else{
          return FALSE;
      }

      }


    public function getPositions()
    {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM setting_positions");
        $stmt->execute();
        $emp = $stmt->fetchAll();
        $userCount = $stmt->rowCount();

        if($userCount > 0){
            return $emp;
        }else{
            return 0;
        }

    }


    public function getDivisions()
    {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM setting_divisions");
        $stmt->execute();
        $emp = $stmt->fetchAll();
        $userCount = $stmt->rowCount();

        if($userCount > 0){
            return $emp;
        }else{
            return 0;
        }

    }


    public function getAllDocument()
    {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT t1.*, s.division as division_owner, t3.division FROM documents t1 LEFT JOIN document_log t2 ON t1.id = t2.document_id LEFT JOIN setting_divisions t3 ON t1.route_to_division_id = t3.id LEFT JOIN setting_divisions s ON t1.division_id = s.id GROUP BY t1.id ORDER BY t1.id DESC");
        $stmt->execute();
        $emp = $stmt->fetchAll();
        $userCount = $stmt->rowCount();

        if($userCount > 0){
            return $emp;
        }else{
            return 0;
        }

    }


    public function getDocumentsDetails($id){

      $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT t1.* FROM (SELECT * from documents WHERE id = ?) t1 LEFT JOIN document_log t2 ON t1.id = t2.document_id ORDER BY t1.date_added DESC");
      $stmt->execute([$id]);
      $Details = $stmt->fetch();
      $total= $stmt->rowCount();

      if($total > 0){
          return $Details;
      }else{
          return FALSE;
      }
    }


    public function getProfile($id){

      $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT t1.*, t2.division, t3.position FROM (SELECT * from setting_users WHERE id = ?) t1 LEFT JOIN setting_divisions t2 ON t1.division_id = t2.id LEFT JOIN setting_positions t3 ON t1.position_id = t3.id");
      $stmt->execute([$id]);
      $Details = $stmt->fetch();
      $total= $stmt->rowCount();

      if($total > 0){
          return $Details;
      }else{
          return FALSE;
      }
    }


    public function getTrackingno($id){

      $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT t1.*, t2.division, t3.fname, t3.minitial, t3.lname, t3.suffix FROM document_log t1 LEFT JOIN setting_divisions t2 ON t1.acted_by_division_id = t2.id LEFT JOIN setting_users t3 ON t1.acted_by_user_id = t3.id WHERE document_id = ? GROUP BY t1.id ORDER BY t1.date_acted ASC");
      $stmt->execute([$id]);
      $Details = $stmt->fetchall();
      $total= $stmt->rowCount();

  if($total > 0){
      return $Details;
  }else{
      return FALSE;
  }

  }


    public function update_account(){


        if(isset($_POST['update'])){

            $id = $_POST['id'];
            $fname = $_POST['fullname'];
            $uname = $_POST['username'];
            $pass = $_POST['password'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `setting_accounts` SET `fullname` = '$fname', `username` = '$uname', `password` = '$pass', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:setting_accounts.php");

        }

    }


    public function update_user(){


        if(isset($_POST['edit_employee'])){

            $id = $_POST['id'];
            $emp_id = $_POST['emp_id'];
            $fname = $_POST['fname'];
            $mnitial = $_POST['mnitial'];
            $lname = $_POST['lname'];
            $suffix = $_POST['suffix'];
            $position = $_POST['position'];
            $division = $_POST['division'];
            $contact_no = $_POST['contact_no'];
            $email_add = $_POST['email_add'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $civil_status = $_POST['civil_status'];
            $bday = $_POST['bday'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `setting_users` SET `employee_id` = '$emp_id', `fname` = '$fname', `minitial` = '$mnitial', `lname` = '$lname', `suffix` = '$suffix', `division_id` = '$division', `position_id` = '$position', `birth_date` = '$bday', `address` = '$address', `gender` = '$gender', `civil_status` = '$civil_status', `contact_no` = '$contact_no', `email_add` = '$email_add', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:profile?id=".$id);

        }

    }


    public function update_position(){


        if(isset($_POST['update'])){

            $id = $_POST['id'];
            $position = $_POST['position'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `setting_positions` SET `position` = '$position', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:setting_positions.php");

        }

    }


    public function update_division(){


        if(isset($_POST['update'])){

            $id = $_POST['id'];
            $division = $_POST['division'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `setting_divisions` SET `division` = '$division', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:setting_divisions.php");

        }

    }

    public function delete_document(){

        if(isset($_POST['delete_document'])){

            $document_id = $_POST['document_id'];

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `documents` WHERE `id` = '$document_id'");

                echo header("Location: documents");


        }
    }


    public function delete_user(){

        if(isset($_POST['delete'])){

            $id = $_POST['id'];

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `users` WHERE `id` = '$id'");

                echo header("Location: employees");


        }
    }


    public function delete_account(){

        if(isset($_POST['delete'])){

            $id = $_POST['id'];

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `setting_accounts` WHERE `id` = '$id'");

                echo header("Location: accounts");


        }
    }


    public function delete_position(){

        if(isset($_POST['delete'])){

            $id = $_POST['id'];

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `setting_positions` WHERE `id` = '$id'");

                echo header("Location: setting_positions.php");


        }
    }


    public function delete_division(){

        if(isset($_POST['delete'])){

            $id = $_POST['id'];

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `setting_divisions` WHERE `id` = '$id'");

                echo header("Location: setting_divisions.php");


        }
    }


    public function delete_photo(){


      if(isset($_POST['delete_photo'])){

          $id = $_POST['id'];
          // $file_id = $_POST['file_id'];
          $file_name = $_POST['file_name'];

          $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
          $file_delete =  "$base_dir/DTS/files/profile_pic/$file_name";
          if(unlink($file_delete)){

              $connection = $this->openConnection();
              $connection->query("UPDATE `setting_users` SET `picture` = NULL WHERE `id` = '$id'");

              echo header("Location:profile?id=".$id);
          }else{
              echo "not delete";
          }

      }

  }


    public function delete_file(){


        if(isset($_POST['delete_file'])){

            $id = $_POST['id'];
            $file_id = $_POST['file_id'];
            // $file_id = $_POST['file_id'];
            $file_name = $_POST['filename'];
            // $ref_no = $_POST['ref_no'];

            $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
            $file_delete =  "$base_dir/DTS/files/document_files/$file_name";
            // $path = realpath('../scannedfile/'.$file_name);
            // echo $path;
            if(unlink($file_delete)){

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `files` WHERE `id` = '$file_id'");

                echo header("Location:DocumentDetails?id=".$id);
            }else{
                echo "not delete";
            }

        }

    }


}

$store = new JOS();
