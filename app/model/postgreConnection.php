<?php
include_once __DIR__ . "/tableStruct.php";
class PostgreConnection
{
    private $connection;
    private $dbname;
    private $postgreStruct;
    public function __construct()
    {
        $this->dbname = getenv("POSTGRES_DB");
        $this->connection = $this->create_connection();
        $this->postgreStruct = new SentencesStruct();
        $this->initializeTables();
    }
    private function create_connection()
    {
        $host = getenv("POSTGRES_HOST");
        $username = getenv("POSTGRES_USER");
        $password = getenv("POSTGRES_PASSWORD");
        $port=getenv("POSTGRES_PORT");
        $dbPath=  dirname(dirname(__DIR__)).'/db/sqliteDB.sqlite';
        try {
            // $connection = new PDO("pgsql:host=$host;port=$port", $username, $password);
            $connection = new SQLite3($dbPath);
            // $sqlExisteDB = "SELECT 1 FROM pg_database WHERE datname = :dbname";
            // $sqlPrepare = $connection->prepare($sqlExisteDB);
            // $sqlPrepare->execute([':dbname' => 'php_login']);
            // if (!$sqlPrepare->fetch()) {
            //     $sqlCrearDB = "CREATE DATABASE " . $this->dbname;
            //     $connection->exec($sqlCrearDB);
            // }
            // $connection = new PDO("pgsql:host=$host;dbname=" . $this->dbname . ";", $username, $password);
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
            $countPrepare->bindValue(1, $data->email,SQLITE3_TEXT);
            $countResult=$countPrepare->execute();
            $count = $countResult->fetchArray();
            if ($count[0] >= 1) {
                return (object) ['code' => 400, 'message' => 'Este Correo ya existe'];
            }
            $keys=[$data->name, $data->lastname, $data->email, $data->password, 'active', 'user'];
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->usersCreate);
            foreach ($keys as $key => $value) {
                $sqlPrepare->bindValue($key+1, $value);
            }
            $result=$sqlPrepare->execute();
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
            $sqlPrepare->bindValue(1, $email,SQLITE3_TEXT);
            $prepareResult=$sqlPrepare->execute();
            $result = $prepareResult->fetchArray();
            if ($result && count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Usuario obtenido con exito', 'data' => $result];
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
            $result=$this->prepareQuery($this->postgreStruct->allCategoryQuery,[]);
            if ($result && count($result) > 0) {
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
            
            $result=$this->prepareQuery($this->postgreStruct->categoryQuery,[$name]);
            if ($result &&  count($result) > 0) {
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
            $result=$this->prepareQuery($this->postgreStruct->categoryId,[$id]);
            if ($result &&  count($result) > 0) {
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
            $result=$this->prepareQuery($this->postgreStruct->allProductsQuery,[$category]);
            if ($result && count($result) > 0) {
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
            $result=$this->prepareQuery($this->postgreStruct->productsQuery,[$category,$name]);
            if ($result && count($result) > 0) {
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
            $sqlPrepare->bindValue(1, $amount,SQLITE3_TEXT);
            $sqlPrepare->bindValue(2, $id,SQLITE3_TEXT);
            $result=$sqlPrepare->execute();
            if ($result) {
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
            $sqlPrepare->bindValue(1, $amount,SQLITE3_TEXT);
            $sqlPrepare->bindValue(2, $email,SQLITE3_TEXT);
            $result=$sqlPrepare->execute();
            if ($result) {
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
            $sqlPrepare->bindValue(1, $email,SQLITE3_TEXT);
            $prepareResult=$sqlPrepare->execute();
            $result=$prepareResult->fetchArray();
            if ($result &&  count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito',  'data' => [$result]];
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
            $sqlPrepare->bindValue(1, $id);
            $prepareResult=$sqlPrepare->execute();
            $result=$prepareResult->fetchArray();
            if ($result && count($result) > 0) {
                return (object) ['code' => 200, 'message' => 'Categorias obtenidas con exito',  'data' => [$result]];
            } else {
                return (object) ['code' => 404, 'message' => 'Categorias no encontradas', 'data' => [] ];
            }
        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al buscar Categorias',  'data' => []];
        }
    }

    public function createCategory($data){
        try {
            $keys=[$data->code, $data->img_rute,$data->name, ];
            $sqlPrepare = $this->connection->prepare($this->postgreStruct->createCategory);
            foreach ($keys as $key => $value) {
                $sqlPrepare->bindValue($key+1, $value);
            }
            $result=$sqlPrepare->execute();
            if ($result) {
                return (object) ['code' => 200, 'message' => 'categoria creado con exito'];
            } else {
                return (object) ['code' => 500, 'message' => 'No se pudo crear al categoria'];

            }

        } catch (PDOException $error) {
            echo '<script>console.log(`Error: ' . $error . '`)</script>';
            return (object) ['code' => 500, 'message' => 'Error al crear categoria'];
        }
    }
    private function initializeTables()
    {
        $arrTables = ['usersTable', 'img_ruteTable', 'categorysTable', 'productsTable'];
        foreach ($arrTables as $key => $value) {
            $this->connection->exec($this->postgreStruct->$value);
        }

    }
    private function prepareQuery($sqlQuery,$keys){
        $sqlPrepare = $this->connection->prepare($sqlQuery);
        foreach ($keys as $key => $value) {
            $sqlPrepare->bindValue($key+1, $value);
        }
        $prepareResult=$sqlPrepare->execute();
        $rows = [];
        while ($row = $prepareResult->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

}
?>