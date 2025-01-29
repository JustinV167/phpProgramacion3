<?php  session_start();
require_once __DIR__."/config.php";
require_once __DIR__."/app/controller/router/router.php";
require_once __DIR__."/app/utils/logout.php";
expireLogout();
if(isset($_POST["logout"])){
    logout();
}
$router=new Router();
$router->run();

?>