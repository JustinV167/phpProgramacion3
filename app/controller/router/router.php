<?php
 include_once(__DIR__."/../data/categoryController.php");

class Router{
    public static $__root=folderPath."/";
    public static $__public=folderPath."/app/public/";
    public static $__view=folderPath."/app/view/";

    private $controller;
    private $method;
    public function __construct(){
        $this->matchRoute();
    }
    public function matchRoute(){
        $parsedUrl = parse_url(URL);
        $url=explode('/',$parsedUrl['path']);
        $this->controller=$url[1];
        $this->method=count($url)<3?'index':(!count($url)?'not__found':$url[2]);
        $this->controller=ucfirst($url[1]==""?'HomeController':$this->controller.'Controller');
        if(file_exists(__DIR__.'/'.$this->controller.'.php')){
            require_once  __DIR__.'/'.$this->controller.'.php';
        }else{
            require_once  __DIR__.'/HomeController.php';
            $this->method='not_found';
            $this->controller='HomeController';
        }
    }
    public function run(){
        $controller=new $this->controller();
        $method='view_'.$this->method;
        if(!method_exists($controller,$method)){
            require_once  __DIR__.'/HomeController.php';
            $controller=new HomeController();
            $method='view_not_found';
        }
        $controller->$method();
    }
};
?>