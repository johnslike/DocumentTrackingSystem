<?php

$userdetails = $store->get_userdata();

if(isset($userdetails)){
  if($userdetails['access'] != "User"){
        header("Location: ../login_logout/login");
    }
}else{
    header("Location: ../login_logout/login");
}

?>
