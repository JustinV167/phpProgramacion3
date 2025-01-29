<?php
include_once __DIR__ . "/tableStruct.php";
class PostgreConnection
{
    private $connection;
    private $dbname;
    private $postgreStruct;
    public function __construct()
    {
        $this->dbname = 'php_login';
        $this->connection = $this->create_connection();
        $this->postgreStruct = new SentencesStruct();
        $this->initializeTables();
    }
    private function create_connection()
    {
        $host = 'dpg-cucsdm1u0jms73cd4bb0-a';
        $username = 'php_login_user';
        $password = 'DmRzJUwUgP78zLkUPDiWVHhqnO1Puybn';
        try {
            $connection = new PDO("pgsql:host=$host;", $username, $password);
            $sqlExisteDB = "SELECT 1 FROM pg_database WHERE datname = :dbname";
            $sqlPrepare = $connection->prepare($sqlExisteDB);
            $sqlPrepare->execute([':dbname' => 'php_login']);
            if (!$sqlPrepare->fetch()) {
                $sqlCrearDB = "CREATE DATABASE " . $this->dbname;
                $connection->exec($sqlCrearDB);
            }
            $connection = new PDO("pgsql:host=$host;dbname=" . $this->dbname . ";", $username, $password);

            return $connection;
        } catch (PDOException $error) {
            echo '<script>console.log(`No se pudo conectar por: ' . $error . '`)</script>';
        }
    }
    public function create_user($data)
    {
        if (!is_object($data)) {
            return (object) ['code' => 400, 'message' => 'objeto null'];
        }
        $dataKeys = ["name", 'lastname', 'password', 'email'];
        for ($i = 0; $i < count($dataKeys); $i++) {
            $item = $dataKeys[$i];
            if (!isset($data->$item) || $data->$item == '') {
                echo '<script>console.log(`node encontro la key ' . $item . '`)</script>';
                return (object) ['code' => 400, 'message' => 'No se declararon todos los datos'];

            }
        }
        try {

            $this->connection->exec($this->postgreStruct->usersTable);
            $countPrepare = $this->connection->prepare('select count(*) from users where email=?;');
            $countPrepare->execute([$data->email]);
            $count = $countPrepare->fetch();
            if ($count[0] >= 1) {
                return (object) ['code' => 400, 'message' => 'Este Correo ya existe'];
            }
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->usersCreate);
            $result = $sqlPrepare->execute([$data->name, $data->lastname, $data->email, $data->password, 'active', 'user']);
            if ($result) {
                return (object) ['code' => 200, 'message' => 'Usuario creado con exito'];
            } else {
                return (object) ['code' => 500, 'message' => 'No se pudo crear al usuario'];

            }

        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al crear Usuario'];
        }
    }
    public function get_user($email)
    {
        if (!isset($email)) {
            return (object) ['code' => 400, 'message' => 'correo es null'];
        }
        try {
            $this->connection->exec($this->postgreStruct->usersTable);
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->userQuery);
            $sqlPrepare->execute([$email]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Usuario obtenido con exito', 'data' => $result[0]];
            } else {
                return (object) ['code' => 404, 'message' => 'Usuario no encontrado'];
            }
        } catch (PDOException $error) {
            echo $error;
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al Buscar Usuario'];
        }
    }
    public function get_all_categorys()
    {
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->allCategoryQuery);
            $sqlPrepare->execute();
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito', 'data' => $result];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', 'data' => []];
            }
        } catch (PDOException $error) {
            echo $error;
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias', 'data' => []];
        }
    }
    public function get_categorys($name)
    {
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->categoryQuery);
            $sqlPrepare->execute([$name]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito', 'data' => $result];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', 'data' => []];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias', 'data' => []];
        }
    }
    public function get_category_id($id)
    {
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->categoryId);
            $sqlPrepare->execute([$id]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito', 'data' => $result[0]];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas',];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias',];
        }
    }
    //products
    public function get_all_products($category)
    {
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->allProductsQuery);
            $sqlPrepare->execute([$category]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito', 'data' => $result];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', 'data' => []];
            }
        } catch (PDOException $error) {
            echo $error;
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias', 'data' => []];
        }
    }
    public function get_products($category,$name)
    {
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->productsQuery);
            $sqlPrepare->execute([$category,$name]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito', 'data' => $result];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', 'data' => []];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias', 'data' => []];
        }
    }
    public function modify_amount($id,$amount)
    {
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->modifyAmount);
            $sqlPrepare->execute([$amount,$id]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito', ];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', ];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias', ];
        }
    }
    public function modify_money($email,$amount)
    {
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->modifyMoney);
            $sqlPrepare->execute([$amount,$email]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito', ];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', ];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias', ];
        }
    }
    public function userMoney($email){
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->userMoney);
            $sqlPrepare->execute([$email]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito',  'data' => $result];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', 'data' => [] ];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias',  'data' => []];
        }
    }public function productAmount($id){
        try {
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->productAmount);
            $sqlPrepare->execute([$id]);
            $result = $sqlPrepare->fetchAll();
            if (count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito',  'data' => $result];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', 'data' => [] ];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias',  'data' => []];
        }
    }
    private function initializeTables()
    {
        $arrTables = ['usersTable', 'img_ruteTable', 'categorysTable', 'productsTable'];
        foreach ($arrTables as $key => $value) {
            $this->connection->exec($this->postgreStruct->$value);
        }

    }

}
?>