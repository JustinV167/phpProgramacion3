<?php
include_once __DIR__ . '/../../utils/validate__text.php';
include_once __DIR__ . '/../../model/postgreConnection.php';

class CategoryDataController
{
    private $dbConnection;
    public $errorArr = [];
    private $categorySubmit;
    public $searchCategory;
    public function __construct()
    {
        $this->dbConnection = new PostgreConnection();
        $this->createCategory();
        $this->deleteCategory();

        $this->categorySubmit = $this->obteinData();
        $this->searchCategory=isset($this->categorySubmit->searchCategory) ? $this->categorySubmit->searchCategory : '';
    }
    public function get_category_by_submit()
    {
        $nameSearch =$this->searchCategory ;
        return $this->get_categorys($nameSearch);
    }
    public function get_categorys($name)
    {
        if (isset($name) && $name != '') {
            return $this->dbConnection->get_categorys($name);
        } else {
            return $this->allcategorysData();
        }

    }
    public function allcategorysData()
    {
        return $this->dbConnection->get_all_categorys();
    }
    public function obteinData()
    {
        if (isset($_GET["searchCategory"])) {
            return (object) [
                "searchCategory" => $_GET["searchCategory"],
            ];
        }
        ;
        return (object) [];
    }
    private function createCategory(){
        if (!isset($_POST["createCategory"])) {
           return;
        }
        $categoryData= (object) [
            "category_code" => $_POST["category_code"],
            "category_name" => $_POST["category_name"],
            "category_img_rute" => $_POST["category_img_rute"],
        ];
        
        $createCategory=$this->dbConnection->createCategory((object)[
            "code"=>$categoryData->category_code,
            "name"=>$categoryData->category_name,
            "img_rute"=>$categoryData->category_img_rute,
            
        ]);
        
    }

    private function deleteCategory(){
        if (!isset($_POST["deleteCategory"])) {
           return;
        }
        $categoryData= (object) [
            "idCategory" => $_POST["idCategory"],
        ];
        if($_SESSION["user"]->rol!="admin"){
            return;
        }   
        $this->dbConnection->deleteCategory($categoryData->idCategory);
        
    }
}
?>