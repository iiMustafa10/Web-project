<?php
session_start();
if (!empty($_REQUEST["email"])&& !empty($_REQUEST["password"]))
{
require_once('classes.php');
$user= user::login($_REQUEST["email"],md5($_REQUEST["password"]));

if(!empty($user)){
    $_SESSION["user"]=serialize($user);
    if ($user->role=="amin")
    {
        header("location:frontend/admin/home.php");
    }
    elseif($user->role=="subcriber")
    {
        header("location:frontend/subcriber/homeS");
    }
}
else
{
    header("location:index.php?msg=no_user");
}

}
else{
    header("location:index.php?msg=empyty_filed");
}


?>
