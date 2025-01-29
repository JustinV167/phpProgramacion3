<?php
// class HomeController{
//     public static $__root='/repaso/';
//     public function view_home(){
//         include_once(__DIR__."/../../view/login/login.php");
//     }
//     public function view_index(){
//         include_once(__DIR__."/../../view/index/index.php");
//     }
//     public function view_not_found(){
//         include_once(__DIR__."/../../view/not_found/not_found.php");
//     }
// }

class HomeController{
    public function view_login(){
        if(isset($_SESSION['signIn'])){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.folderPath);
        }
        include_once(__DIR__."/../data/loginController.php");
        $loginController=new LoginController();
        include_once(__DIR__."/../../view/login/login.php");
    }
    public function view_register(){
        if(isset($_SESSION['signIn'])){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.folderPath);
        }
        include_once(__DIR__."/../data/registerController.php");
        $registerController=new RegisterController();
        include_once(__DIR__."/../../view/register/register.php");
    }
    public function view_index(){
        include_once(__DIR__."/../../view/index/index.php");
    }
    public function view_about(){
        include_once(__DIR__."/../../view/about/about.php");
    }
    public function view_not_found(){
        include_once(__DIR__."/../../view/not_found/not_found.php");
    }
}

?>