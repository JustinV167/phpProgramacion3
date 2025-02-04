<?php
include_once __DIR__ . '/../../utils/validate__text.php';
include_once __DIR__ . '/../../model/postgreConnection.php';

class ProductsDataController
{
    private $dbConnection;
    public $errorArr = [];
    public $productsSubmit;
    public $item_product;

    public $searchProducts='';
    public $category;
    public function __construct()
    {
        
        $this->dbConnection = new PostgreConnection();
        $url = explode('/', URL);
        $parsedUrl = parse_url($url[3]);
        $item_product = $parsedUrl['path'];
        $this->item_product=$item_product;
        $this->productsSubmit = $this->obteinData();
        $this->deleteProduct();
        $this->createProduct();


        $categoryQuery=$this->dbConnection->get_category_id($item_product);
        if(!property_exists($categoryQuery,'data')){
            return;
        }
        $this->searchProducts=isset($this->productsSubmit->searchProduct) ? $this->productsSubmit->searchProduct : '';
        $this->category=$categoryQuery->data;
    }
    public function get_product_by_submit()
    {
        $nameSearch = $this->searchProducts;
        return $this->get_products($nameSearch);
    }
    public function get_products($name)
    {
        if (isset($name) && $name != '') {
            return $this->dbConnection->get_products($this->category['id'],$name);
        } else {
            return $this->allproductsData();
        }

    }
    public function allproductsData()
    {
        return $this->dbConnection->get_all_products($this->category['id']);
    }
    public function obteinData()
    {
        $searchObj=(object) [];
        if (isset($_GET["searchProduct"])) {
            $searchObj=(object) [
                "searchProduct" => $_GET["searchProduct"],
            ];
        };
        if(isset(($_POST['buy']))){
            $objectData=(object)[
                'email'=> $_SESSION['user']->email,
                'money'=>$_SESSION['user']->money,
                'buy_amount'=>$_POST['buy_amount'],
                'buy_id'=>$_POST['buy_id'],
                'buy_price'=>$_POST['buy_price'],
                'amount'=>$_POST['amount'],
            ];
            $dbAmount=$this->dbConnection->productAmount($objectData->buy_id,);
            if(!property_exists($dbAmount,'data')){
                return  $searchObj;
            }
            $onlyAmount=$dbAmount->data[0]['amount'];
            if($onlyAmount<$objectData->buy_amount || $objectData->amount!=$onlyAmount){
                return  $searchObj;
            }
            $totalPrice=$objectData->buy_amount*$objectData->buy_price;
            if($objectData->money<$totalPrice){
                return  $searchObj;
            }
            $this->dbConnection->modify_amount($objectData->buy_id,-$objectData->buy_amount);
            $this->dbConnection->modify_money($objectData->email,-$totalPrice);
            $onlyMoney=$this->dbConnection->userMoney($objectData->email);
            if(!property_exists($onlyMoney,'data')){
                return  $searchObj;
            }
            $_SESSION['user']->money=$onlyMoney->data[0]['money'];
        };
        return  $searchObj;
    }
    public function deleteProduct(){
         if (!isset($_POST["deleteProduct"])) {
           return;
        }
        $productData= (object) [
            "idProduct" => $_POST["idProduct"],
        ];
        if($_SESSION["user"]->rol!="admin"){
            return;
        }   
        $this->dbConnection->deleteProducts($productData->idProduct);
    }
    private function createProduct(){
        if (!isset($_POST["createProduct"])) {
           return;
        }
        $categoryData= (object) [
            "product_price" => $_POST["price"],
            "product_amount" => $_POST["amount"],
            "product_name" => $_POST["name"],
            "product_img_rute" => $_POST["img_rute"],
        ];
        
        $createProduct=$this->dbConnection->createProduct((object)[
            "price"=>$categoryData->product_price,
            "name"=>$categoryData->product_name,
            "img_rute"=>$categoryData->product_img_rute,
            "id_category"=>$this->item_product,
            "amount"=>$categoryData->product_amount,
        ]);
        
    }
}
?>