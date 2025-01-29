
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentsss</title>
    <link rel="stylesheet" href="<?php echo Router::$__public?>css/styles.css">
</head>
<body>
<?php
include_once(__DIR__."/../template/signInNavbar.php");
?>

    <form action="" method="post" class="form__register mx-auto my-2">
    <p class="title__form">Iniciar Sesión </p>
    <?php
        if(!is_object($loginController)){return;}
        $errorArr=$loginController->errorArr;
        if(isset($errorArr) && count($errorArr) > 0) {
        echo '<div>';
        foreach ($errorArr as $index=> &$item) {
        echo '<li>'.$item.'</li>';
        };
        echo '</div>';
    }
    ?>
        <?php
        $inputCase=['text','email','password'];
        $inputs=['email-1-Correo',
        'password-2-Contraseña'];
        
        foreach ($inputs as $index=> &$item) {
            $item=explode('-',$item);
            echo "<label>
            <input class='input__form' placeholder=' ' type='".$inputCase[$item[1]]."' name='".$item[0]
            ."' defaultValue='' ".(isset($_POST[$item[0]])?'value='.$_POST[$item[0]]:' ')." required>
            <span>".$item[2]."</span></label>";
        }
        ?>
       
        <input type="submit" class="basic__button" name="submit" value="Iniciar Sesión">
    </form>
    
</body>
</html>