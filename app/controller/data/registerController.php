<?php
include_once __DIR__ . '/../../utils/validate__text.php';
include_once __DIR__ . '/../../model/postgreConnection.php';

class registerController
{   
    private $dbConnection;
    public $errorArr = [];
    public function __construct()
    {
        $this->dbConnection=new PostgreConnection();
        $data = $this->obteinData();
        if (!isset($data)) {
            return;
        }
        $this->errorArr = $this->validateData($data);
        if (count($this->errorArr) > 0) {
            return;
        }
        $passwordEncrypt = password_hash($data->password, PASSWORD_BCRYPT);
        if (!$passwordEncrypt) {
            return;
        }
        $data->password=$passwordEncrypt;
        $createUser=$this->dbConnection->create_user($data);
        array_push($this->errorArr, $createUser->message);
        $getUser=$this->dbConnection->get_user($data->email);
        $userData=$getUser->data;
        $_SESSION['user']= (object)[
            'name'=>$userData['name'],
            'lastname'=>$userData['lastname'],
            'email'=>$userData['email'],
            'status'=>$userData['status'],
            'rol'=>$userData['rol'],
            'money'=>$userData['money'],
        ];
        $_SESSION['signIn']=true;
        $_SESSION['exp']=new DateTime();
        $_SESSION['exp']->modify('+4 hours');
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.folderPath);
    }
    public function validateData($data)
    {
        $errors = [];
        $case = (object) ['1' => 'cort', '2' => 'larg'];
        if (!onlyText($data->name)) {
            array_push($errors, "El nombre debe tener solo letras.");
        }
        ;
        $nameLength = validateLength($data->name, 3, 20);
        if ($nameLength != 0) {
            array_push($errors, "El nombre es muy " .
                ($case->$nameLength) . "o.");
        }
        ;
        if (!onlyText($data->lastname)) {
            array_push($errors, "El apellido debe tener solo letras.");
        }
        ;
        $lastnameLength = validateLength($data->lastname, 3, 20);
        if ($lastnameLength != 0) {
            array_push($errors, "El apellido es muy " . $case->$lastnameLength . "o.");
        }
        ;
        if (!verifyPassword($data->password)) {
            array_push($errors, "La contraseña debe contener al menos 1 minuscula, 1 mayuscula, 1 numero y un caracter especial");
        }
        ;
        $passwordLength = validateLength($data->password, 6, 40);
        if ($passwordLength != 0) {
            array_push($errors, "La contraseña es muy " . $case->$passwordLength . "a.");
        }
        ;
        if ($data->password != $data->confirmPassword) {
            array_push($errors, "Las contraseñas no coinciden");
        }
        ;
        return $errors;
    }
    public function obteinData()
    {
        if (isset($_POST["submit"])) {
            return (object) [
                "name" => $_POST["name"],
                "lastname" => $_POST["lastname"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
                "confirmPassword" => $_POST["confirmPassword"],
            ];
        }
        ;
        return null;
    }

}
?>