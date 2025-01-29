<?php
class SentencesStruct
{
   //users
   public $usersTable = 'CREATE TABLE IF NOT EXISTS users (id SERIAL PRIMARY KEY,email VARCHAR(40) UNIQUE, name VARCHAR(20), lastname VARCHAR(20),password VARCHAR(80),status VARCHAR(15),rol VARCHAR(15),money FLOAT DEFAULT 0 );';
   public $usersCreate = 'INSERT INTO users (name, lastname, email,password,status,rol) VALUES (?,?,?,?,?,?);';
   public $userQuery = "SELECT * FROM public.users WHERE email=? AND status='active'";
   //img_rute
   public $img_ruteTable = "CREATE TABLE IF NOT EXISTS img_rute (id SERIAL PRIMARY KEY,rute VARCHAR(40) UNIQUE, name VARCHAR(20));
   INSERT INTO img_rute (rute, name) VALUES ('img/imagen.jpg','miimagen') ON CONFLICT (rute) DO NOTHING;";

   //category
   public $categorysTable = "CREATE TABLE IF NOT EXISTS categorys (id VARCHAR(20) PRIMARY KEY,id_img INT, name VARCHAR(20) UNIQUE,status VARCHAR(20),description text);
   INSERT INTO categorys (id,id_img, name,status,description) VALUES ('fruits',1,'frutas','active','venta frutas' ),('clothes',1,'ropa','active','venta ropa' ) ON CONFLICT (name) DO NOTHING;";
   public $allCategoryQuery = "SELECT *,(SELECT i.rute as img_rute FROM public.img_rute as i where i.id=c.id_img), (SELECT COUNT(*) FROM public.products  as p WHERE  p.id_category=c.id AND p.status!='inactive' )as n_products  FROM public.categorys as c WHERE c.status!='inactive'; ";
   public $categoryQuery = "SELECT *,(SELECT i.rute as img_rute FROM public.img_rute as i where i.id=c.id_img), (SELECT COUNT(*) FROM public.products  as p WHERE  p.id_category=c.id AND p.status!='inactive')as n_products  FROM public.categorys as c WHERE c.status!='inactive' AND c.name ILIKE '%' || ? || '%';";
   public $categoryId = "SELECT *  FROM public.categorys  as c WHERE  c.status!='inactive' AND c.id=?";
   //products
   public $productsTable = "CREATE TABLE IF NOT EXISTS products (id SERIAL PRIMARY KEY,id_img INT,id_category VARCHAR(20), name VARCHAR(20) UNIQUE, description VARCHAR(60),status VARCHAR(20),price FLOAT,amount INT,id_currency INT);
   INSERT INTO products (id_img, id_category , name ,status ,price ,amount, id_currency,description) VALUES (1, 'clothes' , 'papel' ,'active' ,10 ,5, 1,'hojas de papel')  ON CONFLICT (name) DO NOTHING;";

   public $allProductsQuery = "SELECT *,
      (SELECT i.rute FROM public.img_rute as i WHERE p.id_img=i.id) as rute_img
      FROM public.products as p WHERE p.status!='inactive' AND p.id_category=?;";

   public $productsQuery = "SELECT *,
      (SELECT i.rute FROM public.img_rute as i WHERE p.id_img=i.id) as rute_img
      FROM public.products as p WHERE p.status!='inactive' AND p.id_category=? AND p.name ILIKE '%' || ? || '%';";
}

?>