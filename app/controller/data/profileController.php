<?php
include_once __DIR__ . '/../../utils/validate__text.php';
include_once __DIR__ . '/../../model/postgreConnection.php';

class ProfileController
{
    private $dbConnection;
    public $errorArr = [];
    public function __construct()
    {
        $this->dbConnection = new PostgreConnection();
        $data = $this->obteinData();
        if (!isset($data)) {
            return;
        }
        $this->dbConnection->modify_money($_SESSION['user']->email, $data->money);
        $onlyMoney = $this->dbConnection->userMoney($_SESSION['user']->email);
        if (!property_exists($onlyMoney, 'data')) {
            return;
        }
        $_SESSION['user']->money = $onlyMoney->data[0]['money'];
    }

    public function obteinData()
    {
        if (isset($_POST["submit"])) {
            return (object) [
                "money" => $_POST["money"],
            ];
        }
        ;
        return null;
    }

}
?>