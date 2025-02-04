<?php
    
    define('folderPath','https://'.$_SERVER['HTTP_HOST']);
    $urlPath='htpps://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $url=substr($urlPath,strlen(folderPath));
    define('URL',$url);
        
?>