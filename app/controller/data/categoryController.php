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
}
?>