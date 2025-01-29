<?php 
function logout(){
    session_destroy();
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.folderPath);
}
function expireLogout(){
    if(isset($_SESSION['exp'])){
        $timeStand=new DateTime();
        if($timeStand<$_SESSION['exp']){
            $_SESSION['exp']=$timeStand->modify('+4 hours');
        }else{
            logout();
        }
    }
}
?>