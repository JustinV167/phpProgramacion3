<?php
include_once(__DIR__."/../template/header.php");
?>
    <div class="flex w-full my-4 text-3xl justify-center">
        <p class> Categorias</p>
    </div>
    <form  class="flex w-full my-4 px-10 ">
        <input value="<?php echo $categoryController->searchCategory?>" name="searchCategory" type="text" placeholder="Buscar categoria" class="border rounded-lg border-gray-700 px-1">
        <button class="h-7 w-7 hover:bg-blue-500 flex justify-center items-center bg-blue-400 rounded-lg mx-1">
            <img  src="<?php echo Router::$__public ?>icons/search.svg">
        </button>
    </form>
    <div class="flex flex-wrap w-full gap-4 px-10 justify-center sm:justify-start">

        <?php
        $data = $categoryController->get_category_by_submit();
        if(count($data->data)==0){
            echo 'no hay categorias';
        }else{

        foreach ($data->data as $key => $value) { ?>
            <a href='<?php echo  Router::$__root.'category/products/'.$value['id'] ?>' class=' w-52 flex flex-col border border-blue-400 rounded-xl cursor-pointer hover:scale-105 transform transition-all '>
                <div class="bg-blue-200 rounded-t-xl py-2 pb-0 flex flex-col items-center ">
                    <img class='w-48 h-36 rounded-xl  border border-blue-400 rounded-xl' src='<?php echo Router::$__public . $value['img_rute'] ?>'></img>
                    <p class="font-semibold nrom"><?php echo $value['name'] ?></p>
                </div>
                <div class="bg-gray-200 rounded-b-xl flex-1 px-2 py-1  border-t border-blue-400">
                <p>n° de productos: <?php echo $value['n_products'] ?></p>
                </div>

            </a>
        
        <?php }} ?>
    </div>
</body>

</html>