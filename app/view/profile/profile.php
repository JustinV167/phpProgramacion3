
<?php
include_once(__DIR__."/../template/header.php");
?>
<div class="flex justify-center mt-10">

    <div class="bg-white p-6 rounded-lg shadow-lg w-80">
        <h2 class="text-xl font-semibold text-gray-800 text-center">Perfil de Usuario</h2>
        <div class="mt-4">
            <p class="text-gray-600"><strong>Nombre:</strong> <?php echo $_SESSION['user']->name ?></p>
            <p class="text-gray-600"><strong>Apellido:</strong> <?php echo $_SESSION['user']->lastname ?></p>
            <p class="text-gray-600"><strong>Correo:</strong> <?php echo $_SESSION['user']->email ?></p>
            <p class="text-gray-600"><strong>Rol:</strong> <?php echo $_SESSION['user']->rol ?></p>
        </div>
        <form class='pt-4' method="post">
            <p class="text-gray-600"><strong>Recargar Saldo:</strong></p>
            <input class="border border-gray-600 rounded-lg h-7" type="number" name="money" min="0">
            <input class="bordor border-gray-600 rounded-lg bg-gray-400 hover:bg-gray-600 h-7 px-1" type="submit" name="submit" value="enviar">
        </form>
    </div>
</div>
</body>
</html>