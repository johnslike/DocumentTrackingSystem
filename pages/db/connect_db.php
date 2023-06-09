
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
                $stmt = $connection->prepare("SELECT t1.id, t1.username, t1.password, t1.access, t2.fname, t2.minitial, t2.lname, t2.suffix FROM setting_accounts t1 LEFT JOIN setting_users t2 ON t1.user_id = t2.id WHERE username = ? AND `password` = ?");
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
            "id" => $array['id']
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


    public function add_account()
    {
        if(isset($_POST['add_account']))
        {

            $employee = $_POST['employee'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $access = $_POST['access'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO setting_accounts(`user_id`, `username`, `password`, `access`) VALUES(?,?,?,?)");
                $stmt->execute([$employee, $username, $password, $access]);

                echo header ("Location: accounts");

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


    public function add_unit()
    {
        if(isset($_POST['add_unit']))
        {
            $user = $_POST['user'];
            $ict_no = $_POST['ict_no'];
            $serial_no = $_POST['serial_no'];
            $type = $_POST['type'];
            $brand = $_POST['brand'];
            $specs = $_POST['specs'];
            $acquired = $_POST['acquired'];
            $status = $_POST['status'];


                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO ict_units(`user_id`, `ict_no`, serial_no, `type`, brand, brief_specs, date_acquired, `status`) VALUES(?,?,?,?,?,?,?,?)");
                $stmt->execute([$user,$ict_no,$serial_no,$type,$brand,$specs,$acquired,$status]);

                echo header ("Location: ict_units.php");


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


    public function show_404(){

        http_response_code(404);
        echo "Page not found";
        die;

    }


    public function getUsers()
    {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT t1.id, t1.fname, t1.minitial, t1.lname, t1.suffix, t1.date_added, t2.position, t2.id as pos_id, t3.division, t3.id as div_id FROM setting_users t1 LEFT JOIN setting_positions t2 ON t1.position_id = t2.id LEFT JOIN setting_divisions t3 ON t1.division_id = t3.id ORDER BY t1.date_added DESC");
        $stmt->execute();
        $emp = $stmt->fetchAll();
        $userCount = $stmt->rowCount();

        if($userCount > 0){
            return $emp;
        }else{
            return 0;
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


    public function update_request(){


        if(isset($_POST['update_request'])){

            $id = $_POST['id'];
            $request_by = $_POST['request_by'];
            $date_requested = $_POST['date_requested'];
            $problem_request = $_POST['problem_request'];
            $date_acted = $_POST['date_acted'];
            $action_taken = $_POST['action_taken'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `request_problem` SET `user_id` = '$request_by', `action_taken` = '$action_taken', `request` = '$problem_request', `date_requested` = '$date_requested', `date_acted` = '$date_acted', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:requests_all.php");

        }

    }


    public function update_ictDetails(){


        if(isset($_POST['update_details'])){

            $id = $_POST['id'];
            $user = $_POST['user'];
            $ict_no = $_POST['ict_no'];
            $serial_no = $_POST['serial_no'];
            $type = $_POST['type'];
            $brand = $_POST['brand'];
            $specs = $_POST['specs'];
            $acquired = $_POST['acquired'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `ict_units` SET `user_id` = '$user', `ict_no` = '$ict_no', `serial_no` = '$serial_no', `type` = '$type', `brand` = '$brand', `brief_specs` = '$specs', `date_acquired` = '$acquired', `status` = '$status', `remarks` = '$remarks', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:Unit_Details.php?id=".$id);

        }

    }


    public function update_user(){


        if(isset($_POST['update'])){

            $id = $_POST['id'];
            $fname = $_POST['fname'];
            $mintial = $_POST['mintial'];
            $lname = $_POST['lname'];
            $suffix = $_POST['suffix'];
            $division = $_POST['division'];
            $position = $_POST['position'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `setting_users` SET `fname` = '$fname', `minitial` = '$mintial', `lname` = '$lname', `suffix` = '$suffix', `division_id` = '$division', `position_id` = '$position', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:setting_users.php");

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


    public function update_details(){


        if(isset($_POST['btn_update_details'])){

                $id = $_POST['id'];
                $type = $_POST['type'];
                $to = $_POST['to'];
                $subject = $_POST['subject'];

                $connection = $this->openConnection();
                $connection->query("UPDATE `log_db` SET `type` = '$type', `subject` = '$subject', `date_updated` = now() WHERE `id` = '$id'");

                echo header("Location:Details.php?id=".$id);

        }

    }


    public function delete_user(){

        if(isset($_POST['delete'])){

            $id = $_POST['id'];

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `setting_users` WHERE `id` = '$id'");

                echo header("Location: setting_users.php");


        }
    }


    public function delete_account(){

        if(isset($_POST['delete'])){

            $id = $_POST['id'];

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `setting_accounts` WHERE `id` = '$id'");

                echo header("Location: setting_accounts.php");


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


    public function delete_file(){


        if(isset($_POST['delete_file'])){

            $id = $_POST['id'];
            // $file_id = $_POST['file_id'];
            $file_name = $_POST['file_name'];
            // $ref_no = $_POST['ref_no'];

            $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
            $file_delete =  "$base_dir/HRDLog/pages/files/$file_name";
            // $path = realpath('../scannedfile/'.$file_name);
            // echo $path;
            if(unlink($file_delete)){

                $connection = $this->openConnection();
                $connection->query("DELETE FROM `files` WHERE `log_id` = '$id'");
                // $connection->query("UPDATE ataf_list SET `file_upload` = 1  WHERE `id` = '$id'");
                $connection->query("DELETE FROM `fileupload_log` WHERE `log_id` = '$id'");

                echo header("Location:Details.php?id=".$id);
            }else{
                echo "not delete";
            }

        }

    }


}

$store = new JOS();
