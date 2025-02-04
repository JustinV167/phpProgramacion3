<?php
include_once(__DIR__."/../template/header.php");
?>
    <div class="flex w-full my-4 text-3xl justify-center">
        <p class><?php echo $productsController->category['name'] ?> </p>
    </div>
    <form class="flex w-full my-4 px-10 ">
        <input value="<?php echo $productsController->searchProducts ?>" name="searchProduct" type="text" placeholder="Buscar producto"
            class="border rounded-lg border-gray-700 px-1">
        <button class="h-7 w-7 hover:bg-blue-500 flex justify-center items-center bg-blue-400 rounded-lg mx-1">
            <img src="<?php echo Router::$__public ?>icons/search.svg">
        </button>
    </form>
    <div class="flex flex-wrap w-full gap-4 px-10 justify-center sm:justify-start">

        <?php
        $data = $productsController->get_product_by_submit();
        if (count($data->data) == 0) {
            echo 'No se encontro ningun producto';
        } else {

            foreach ($data->data as $key => $value) { ?>
                <form onsubmit="return handleSubmit(event);"
                    class=' w-52 flex flex-col border border-blue-400 rounded-xl cursor-pointer  '>
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
                            <button type="button" onclick="prevButtonNumber(this)"
                                class="w-6 h-6 bg-blue-500 text-white font-semibold hover:scale-105 transform transition-all rounded-lg">
                                <</button>
                                    <input name="buy_amount" class="border border-gray-700 rounded-lg w-16" type="number"
                                        min="0" oninput="maxValue(this)" max="<?php echo $value['amount'] ?>">
                                    <button type="button" onclick="nextButtonNumber(this)"
                                        class="w-6 h-6 bg-blue-500 text-white font-semibold hover:scale-105 transform transition-all rounded-lg">></button>
                        </div>
                        <div class="flex flex-wrap justify-between pt-1">
                            <p>total:<span class="total_price">0</span><span
                                    class="price hidden"><?php echo $value['price'] ?></span>
                            </p>
                            <button name="buy_button" data-id="<?php echo $value['id'] ?>"
                                data-price="<?php echo $value['price'] ?>"
                                data-amount="<?php echo $value['amount'] ?>"
                                class="bg-blue-500 rounded-lg h-6 px-1 hover:scale-105 transform transition-all">Comprar</button>
                        </div>
                    </div>

                </form>

            <?php }
        } ?>
    </div>
    <script src="<?php echo Router::$__public ?>js/events.js"></script>
    <script>
        function handleSubmit(e) {
            e.preventDefault();
            const buy_amount = e.target.buy_amount.value
            const buy_button=e.target.buy_button
            const buy_id=buy_button.getAttribute('data-id')
            const buy_price=buy_button.getAttribute('data-price')
            const amount=buy_button.getAttribute('data-amount')
            if (buy_amount == "" || parseInt(buy_amount) == 0) {
                alert('No se ingreso ningun monto')
                return
            }
            const dataUser = { 
                amount,
                money: <?php echo $_SESSION['user']->money ?>,
                buy_amount:parseInt(buy_amount),buy_id,buy_price,buy:'true'
                }
            if(dataUser.money<(buy_price*buy_amount)){
                alert('No posees el dinero suficiente')
                return
            }
            const form = document.createElement('form');
            form.action = '';
            form.method = 'post';
            form.style.display = 'none'; 
            for (const key in dataUser) {
                if (dataUser.hasOwnProperty(key)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = dataUser[key];
                    form.appendChild(input);
                }
            }
            document.body.appendChild(form);
            form.submit()
        }
    </script>
</body>

</html>