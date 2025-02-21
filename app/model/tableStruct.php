<?php
class SentencesStruct
{
   //users
   public $usersTable = 'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT,email VARCHAR(40) UNIQUE, name VARCHAR(20), lastname VARCHAR(20),password VARCHAR(80),status VARCHAR(15),rol VARCHAR(15),money FLOAT DEFAULT 0 );';
   public $usersCreate = 'INSERT INTO users (name, lastname, email,password,status,rol) VALUES (?,?,?,?,?,?);';
   public $userQuery = "SELECT * FROM users WHERE email=? AND status='active'";
   public $modifyMoney="UPDATE users SET money = money + ? WHERE email = ?;";
   public $userMoney="SELECT money FROM users WHERE email=? AND status='active'";

   //img_rute
   
   public $img_ruteTable = "CREATE TABLE IF NOT EXISTS img_rute (id INTEGER PRIMARY KEY  AUTOINCREMENT,rute VARCHAR(40) UNIQUE, name VARCHAR(20));
   INSERT INTO img_rute (rute, name) VALUES ('img/imagen.jpg','miimagen') ON CONFLICT (rute) DO NOTHING;";

   //category
   public $categorysTable = "CREATE TABLE IF NOT EXISTS categorys (id VARCHAR(20) PRIMARY KEY,id_img INT, name VARCHAR(20),status VARCHAR(20),description text);";
   public $allCategoryQuery = "SELECT *,(SELECT i.rute FROM img_rute as i where i.id=c.id_img) as img_rute , (SELECT COUNT(*) FROM products  as p WHERE  p.id_category=c.id AND p.status!='inactive' )as n_products  FROM categorys as c WHERE c.status!='inactive'; ";
   public $categoryQuery = "SELECT *,(SELECT i.rute  FROM img_rute as i where i.id=c.id_img) as img_rute, (SELECT COUNT(*) FROM products  as p WHERE  p.id_category=c.id AND p.status!='inactive')as n_products  FROM categorys as c WHERE c.status!='inactive' AND c.name LIKE '%' || ? || '%';";
   public $categoryId = "SELECT *  FROM categorys  as c WHERE  c.status!='inactive' AND c.id=?";
   public $createCategory = "INSERT INTO categorys (id,id_img,name,status,description) VALUES(?,?,?,'active',' ');";
   public $deleteCategory="UPDATE categorys SET status='inactive' WHERE id = ?;";
   
   //products
   public $productsTable = "CREATE TABLE IF NOT EXISTS products (id INTEGER PRIMARY KEY  AUTOINCREMENT,id_img INT,id_category VARCHAR(20), name VARCHAR(20), description VARCHAR(60),status VARCHAR(20),price FLOAT,amount INT,id_currency INT);";
   public $createProducts = "INSERT INTO products (id_category,id_img,price,amount,name,status,description) VALUES(?,?,?,?,?,'active',' ');";
   public $updateProducts="UPDATE products SET id_img=?, price=?, amount=?, name=?, WHERE id = ?;";
   public $productsMin="SELECT name FROM products WHERE amount < 5;";
   public $allProductsQuery = "SELECT *,
      (SELECT i.rute FROM img_rute as i WHERE p.id_img=i.id) as rute_img
      FROM products as p WHERE p.status!='inactive' AND p.id_category=?;";
   public $deleteProducts="UPDATE products SET status='inactive' WHERE id = ?;";

   public $productsQuery = "SELECT *,
      (SELECT i.rute FROM img_rute as i WHERE p.id_img=i.id) as rute_img
      FROM products as p WHERE p.status!='inactive' AND p.id_category=? AND p.name LIKE '%' || ? || '%';";
   public $modifyAmount="UPDATE products SET amount = amount + ? WHERE id = ?;";
   public $productAmount="SELECT amount FROM products WHERE id=? AND status='active'";

}

?>