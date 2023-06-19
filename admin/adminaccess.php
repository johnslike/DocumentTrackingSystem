<?php

$userdetails = $store->get_userdata();

if(isset($userdetails)){
  if($userdetails['access'] != "Admin"){
        header("Location: ../login_logout/login");
    }
}else{
    header("Location: ../login_logout/login");
}

?>
