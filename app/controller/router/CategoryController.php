<?php

class CategoryController{
    public function __construct(){
        if(!isset($_SESSION['signIn'])){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.folderPath);
        }
    }
    public function view_index(){
        include_once(__DIR__."/../data/categoryController.php");
        $categoryController=new CategoryDataController();
        include_once(__DIR__."/../../view/index_products/index_products.php");
    }
    public function view_products(){
        $url=explode('/',URL);
        if (isset($url[3]) && $url[3]!="" ) {
            $parsedUrl = parse_url($url[3]);
            $item_product = $parsedUrl['path']; 
            if(isset($parsedUrl['query'])){
                parse_str($parsedUrl['query'], $params);
            }
            $search = isset($params['search']) ? $params['search'] : '';
            include_once(__DIR__."/../data/productsController.php");
            $productsController=new ProductsDataController();
            include_once(__DIR__."/../../view/item_product/item_product.php");
            return;
        }
        $this->view_index();
    }
}
?>