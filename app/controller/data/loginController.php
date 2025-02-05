<?php
include_once __DIR__ . '/../../utils/validate__text.php';
include_once __DIR__ . '/../../model/postgreConnection.php';

class LoginController{   
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
        $getUser=$this->dbConnection->get_user($data->email);
        if($getUser->code!=200){
            array_push($this->errorArr, $getUser->message);
            return;
        }
        if(!password_verify($data->password,$getUser->data['password'])){
            array_push($this->errorArr, 'Contraseña Incorrecta');
            return;
        }
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

        if($userData['rol']=="admin"){
            $minProduct=$this->dbConnection->productsMin();
            if(count($minProduct->data)>0){
                $string="";
                foreach ($minProduct->data as $key => $value) {
                    if($key==0){
                        $string=$value["name"];
                    }else{
                        $string=$string.', '.$value["name"];
                    }
                }
                echo "<script> alert('los siguiente productos se quedaron o estan a punto de quedarse sin stock: $string');window.location.href = 'http://" . $_SERVER['HTTP_HOST'] . "';</script>";
            }else{
        header('Location: https://'.$_SERVER['HTTP_HOST']);

                return;
            }
        }
        header('Location: https://'.$_SERVER['HTTP_HOST']);
        return;
    }
    public function validateData($data)
    {
        $errors = [];
        $case = (object) ['1' => 'cort', '2' => 'larg'];
        if (!verifyPassword($data->password)) {
            array_push($errors, "La contraseña debe contener al menos 1 minuscula, 1 mayuscula, 1 numero y un caracter especial");
        }
        ;
        $passwordLength = validateLength($data->password, 6, 40);
        if ($passwordLength != 0) {
            array_push($errors, "La contraseña es muy " . $case->$passwordLength . "a.");
        }
        ;
        return $errors;
    }
    public function obteinData()
    {
        if (isset($_POST["submit"])) {
            return (object) [
                "email" => $_POST["email"],
                "password" => $_POST["password"],
            ];
        }
        ;
        return null;
    }
  
}
?>