<?php
include_once __DIR__ . '/../../utils/validate__text.php';
include_once __DIR__ . '/../../model/postgreConnection.php';

class ProductsDataController
{
    private $dbConnection;
    public $errorArr = [];
    public $category;
    public function __construct()
    {
        $this->dbConnection = new PostgreConnection();
        $url = explode('/', URL);
        $parsedUrl = parse_url($url[3]);
        $item_product = $parsedUrl['path'];
        $categoryQuery=$this->dbConnection->get_category_id($item_product);
        if(!property_exists($categoryQuery,'data')){
            return;
        }
        $this->category=$categoryQuery->data;
        $this->categorySubmit = $this->obteinData();
    }
    public function get_product_by_submit()
    {
        $nameSearch = '';
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
        if (isset($_GET["searchProduct"])) {
            return (object) [
                "searchProduct" => $_GET["searchProduct"],
            ];
        }
        ;
        return (object) [];
    }
}
?>