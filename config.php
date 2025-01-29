<?php
    define('folderPath','http://'.$_SERVER['HTTP_HOST']);
    $urlPath='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $url=substr($urlPath,strlen(folderPath));
    define('URL',$url);
        
?>