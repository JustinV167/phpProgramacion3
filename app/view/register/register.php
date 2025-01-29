<?php
include_once(__DIR__."/../template/header.php");
?>
    <form action="" method="post" class="form__register mx-auto my-2">
    <p class="title__form">Registro </p>
    <?php
        if(!is_object($registerController)){return;}

        $errorArr=$registerController->errorArr;
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
        $inputs=['name-0-Nombre','lastname-0-Apellido','email-1-Correo',
        'password-2-Contraseña','confirmPassword-2-Confirmar Contraseña'];
        
        foreach ($inputs as $index=> &$item) {
            $item=explode('-',$item);
            echo ($index==0?'<div class="double__element">':'')."
            <label>
            <input class='input__form' placeholder=' ' type='".$inputCase[$item[1]]."' name='".$item[0]
            ."' defaultValue='' ".(isset($_POST[$item[0]])?'value='.$_POST[$item[0]]:' ')." required>
            <span>".$item[2]."</span></label>".($index==1?'</div>':'');
        }
        ?>
       
        <input type="submit" class="basic__button" name="submit" value="Registrarse">
    </form>
    
</body>
</html>