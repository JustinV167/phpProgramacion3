<?php
    $ruta;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $ruta = 'https';
    } else {
        $ruta = 'http';
    }
    define('folderPath',$ruta.'://'.$_SERVER['HTTP_HOST']);
    $urlPath=$ruta.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $url=substr($urlPath,strlen(folderPath));
    define('URL',$url);
        
?>