<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo Router::$__public ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo Router::$__public ?>css/tailwind.css">
</head>

<body>
    <?php
    include_once(__DIR__ . "/../template/signInNavbar.php");
    ?>
    <div class="flex w-full my-4 text-3xl justify-center">
        <p class><?php echo $productsController->category['name'] ?> </p>
    </div>
    <form class="flex w-full my-4 px-10 ">
        <input value="" name="searchCategory" type="text" placeholder="Buscar categoria"
            class="border rounded-lg border-gray-700 px-1">
        <button class="h-7 w-7 hover:bg-blue-500 flex justify-center items-center bg-blue-400 rounded-lg mx-1">
            <img src="<?php echo Router::$__public ?>icons/search.svg">
        </button>
    </form>
    <div class="flex flex-wrap w-full gap-4 px-10 justify-center sm:justify-start">

        <?php
        $data = $productsController->get_product_by_submit();
        var_dump($data->data);
        if (count($data->data) == 0) {
            echo 'no hay productos';
        } else {

            foreach ($data->data as $key => $value) { ?>
                <div class=' w-52 flex flex-col border border-blue-400 rounded-xl cursor-pointer  '>
                    <div class="bg-blue-200 rounded-t-xl py-2 pb-0 flex flex-col items-center ">
                        <img class='w-48 h-36 rounded-xl  border border-blue-400 rounded-xl'
                            src='<?php echo Router::$__public . $value['rute_img'] ?>'></img>
                        <p class="font-semibold nrom"><?php echo $value['name'] ?></p>
                    </div>
                    <div class="bg-gray-200 rounded-b-xl flex-1 px-2 py-1  border-t border-blue-400">
                        <div class="w-full flex justify-between">
                            <p>stock:<?php echo $value['amount'] ?></p>
                            <p>precio:<?php echo $value['price'] ?>bs</p>
                        </div>
                        <div class="w-full flex justify-center gap-2">
                            <button onclick="prevButtonNumber(this)"
                                class="w-6 h-6 bg-blue-500 text-white font-semibold hover:scale-105 transform transition-all rounded-lg">
                            <</button>
                            <input class="border border-gray-700 rounded-lg w-16" type="number" min="0" oninput="maxValue(this)"
                                max="<?php echo $value['amount'] ?>">
                            <button onclick="nextButtonNumber(this)"
                                class="w-6 h-6 bg-blue-500 text-white font-semibold hover:scale-105 transform transition-all rounded-lg">></button>
                        </div>
                        <div class="flex flex-wrap justify-between pt-1">
                            <p>total:<span class="total_price">0</span><span
                                    class="price hidden"><?php echo $value['price'] ?></span>
                            </p>
                            <button class="bg-blue-500 rounded-lg h-6 px-1 hover:scale-105 transform transition-all">Comprar</button>
                        </div>
                    </div>

                </div>

            <?php }
        } ?>
    </div>
    <script src="<?php echo Router::$__public ?>js/events.js"></script>
</body>

</html>