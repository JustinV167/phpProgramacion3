<?php
include_once(__DIR__."/../../controller/data/categoryController.php");
$category=new CategoryDataController();
?>
<div class="nav__bar">
    <div class="nav__bar__section section__hidden"></div>
    <a href="<?php echo Router::$__root ?>" class="nav__bar__section nav__bar__pointer hidden__480px">
        <p>Inicio</p>
    </a>
    <input type="checkbox" id="menu__check" style="display:none;" />
    <div class="menu__lateral">
        <ul>
        <a href="<?php echo Router::$__root ?>"><li>Inicio</li></a>
            <?php if (isset($_SESSION['signIn'])): ?>
                <label for="menu__catalogo__check">
                    <li>Categorias </li>
                </label>
                <input type="checkbox" id="menu__catalogo__check" style="display:none;" checked />
                <ul>
                                    <a href="<?php echo Router::$__root ?>category"><li>Ver Categorias</li></a>

                                    <?php 
                 $data = $category->allcategorysData();
                 foreach ($data->data as $key => $value) { ?>
                    <a href="<?php echo  Router::$__root.'category/products/'.$value['id'] ?>">
                        <li><?php echo  $value['name'] ?></li>
                    </a>
                    <?php } ?>
                </ul>
            <?php else: ?>

                <a href="<?php echo Router::$__root ?>home/login"><li>Iniciar Sesion</li></a>
                <a href="<?php echo Router::$__root ?>home/register"><li>Registrarse</li></a>
            <?php endif ?>
            <a href="<?php echo Router::$__root ?>home/about"> <li>Nosotros</li></a>

        </ul>
    </div>
    <label for="menu__check" class="nav__bar__section nav__bar__pointer show__480px">
        <img width="30px" src="<?php echo Router::$__public ?>icons/menu.svg">
        <p>Menú</p>

    </label>
    <?php if (isset($_SESSION['signIn'])): ?>
        <input type="checkbox" id="catalogo__check" style="display:none;" />
        <label for="catalogo__check" class="nav__bar__section nav__bar__pointer hidden__480px">
            <div style="margin-top:auto;">
                <ul class="catalogo__menu">
                <a href="<?php echo Router::$__root ?>category"><li>Ver Categorias</li></a>
                <?php 
                 $data = $category->allcategorysData();
                 foreach ($data->data as $key => $value) { ?>
                    <a href="<?php echo  Router::$__root.'category/products/'.$value['id'] ?>">
                        <li><?php echo  $value['name'] ?></li>
                    </a>
                    <?php } ?>
                </ul>
            </div>
            <p>Categorias</p>
        </label>
    <?php endif ?>
    <a href="<?php echo Router::$__root ?>home/about" class="nav__bar__section nav__bar__pointer hidden__480px">
        <p>Nosotros</p>
    </a>
    <?php if (!isset($_SESSION['signIn'])): ?>
        <a href="<?php echo Router::$__root ?>home/register" class="nav__bar__section nav__bar__pointer hidden__480px">
            <p>Registrarse</p>
        </a>
        <a href="<?php echo Router::$__root ?>home/login" class="nav__bar__section nav__bar__pointer hidden__480px">
            <p>Iniciar Sesion</p>
        </a>
    <?php else: ?>
        <div>
            <label for="session__check" class="nav__bar__section nav__bar__pointer">
                <p>
                    <?php echo $_SESSION['user']->name ?>
                    <?php echo $_SESSION['user']->lastname ?>
                </p>
                <img width="30px" src="<?php echo Router::$__public ?>icons/user.svg">
            </label>
            <input type="checkbox" id="session__check" style="display:none;" checked />
            <div>
                <ul>
                    <a href="<?php echo Router::$__root ?>home/profile"><li>Mi perfil</li></a>
                    <li>
                        <form action="" method="post"><button name="logout" class="button__not__style" >Cerrar Sesion</button></form>
                    </li>
                </ul>
            </div>
        </div>

    <?php endif ?>
    <div class="nav__bar__section section__hidden"></div>
   
</div>
<div class="nav__bar__template"></div>
<?php if (isset($_SESSION['signIn'])): ?>
        <div class="fixed top-2 right-2 z-index ">
        <div class="nav__bar__template"></div>  
        <div class="p-1 bg-white border border-blue-600 rounded-lg ">
            Tu dinero: <?php echo $_SESSION['user']->money ?> bs
        </div>  
     </div>
        <?php endif ?>