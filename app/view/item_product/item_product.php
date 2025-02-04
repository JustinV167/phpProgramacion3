<?php
include_once(__DIR__."/../template/header.php");
?>
<div class="flex w-full my-4 text-3xl justify-center">
    <p class><?php echo $productsController->category['name'] ?> </p>
</div>
<?php if ($_SESSION['user']->rol == "admin"): ?>
<button onclick="showModal('modalCreate')" id="openModalButton"
    class="bg-blue-500 text-white mx-6 sm:mx-10 px-4  h-7 rounded-lg hover:bg-blue-700">
    Crear Producto
</button>
<div id="modalCreate" onclick="closeModal('modalCreate')"
    class="fixed z-10 inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <form onclick="return event.stopPropagation();" onsubmit="return handleCreateSubmit(event);"
        class="bg-white p-8 rounded-lg w-96 flex justify-center flex-col items-center">
        <h2 class="text-xl font-bold mb-4">Crear Producto</h2>
        <div>

            <p class="text-gray-600"><strong>Nombre:</strong></p>
            <input name="name" required class="border border-gray-600 rounded-lg h-7">
        </div>
        <div>

            <p class="text-gray-600"><strong>Precio:</strong></p>
            <input class="border border-gray-600 rounded-lg h-7" required name="price">
        </div>
        <div>
            <p class="text-gray-600"><strong>cantidad:</strong></p>
            <input class="border border-gray-600 rounded-lg h-7" required name="amount">
        </div>
        <div>

            <p class="text-gray-600"><strong>Imagen:</strong></p>
            <select id="imageSelector" required name="img_rute"
                class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" disabled selected>Selecciona una imagen</option>
                <?php
                    $imageArray = [
                        'img/imagen.jpg-1',
                    ];
                    foreach ($imageArray as $image) {
                        echo '<option value="' . $image . '">' . basename($image) . '</option>';
                    }
                    ?>
            </select>
            <div class="justify-center flex rounded-md mt-2">
                <div id="imagePreview" class="w-32 h-32 bg-gray-300 flex items-center justify-center rounded-md">
                    <span class="text-gray-500 text-xs">Selecciona una imagen para verla aquí.</span>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <button onclick="closeModal('modalCreate')" type="button" id="closeModalButton"
                class="px-1 h-8 bg-red-500 text-white my-2  rounded-lg hover:bg-red-700">
                Volver
            </button>
            <button name="createCategory" id="closeModalButton"
                class="px-1 h-8 bg-green-500 text-white my-2 rounded-lg hover:bg-green-700">
                Crear
            </button>
        </div>
    </form>
</div>

<div id="modalDelete" onclick="closeModal('modalDelete')"
    class="fixed z-10 inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div onclick="event.stopPropagation()"
        class="bg-white p-8 rounded-lg w-96 flex justify-center flex-col items-center">
        <h2 class="text-xl font-bold mb-4 text-center">¿Estás seguro de borrar este Producto?</h2>
        <div class="flex gap-4">
            <button onclick="closeModal('modalDelete')" type="button" id="closeModalButton"
                class="px-1 h-8 bg-red-500 text-white my-2  rounded-lg hover:bg-red-700">
                Volver
            </button>
            <button name="createCategory" onclick="deleteProduct()" id="closeModalButton"
                class="px-1 h-8 bg-green-500 text-white my-2 rounded-lg hover:bg-green-700">
                Eliminar
            </button>
        </div>
    </div>
</div>

<?php endif; ?>
<form class="flex w-full my-4 px-10 ">
    <input value="<?php echo $productsController->searchProducts ?>" name="searchProduct" type="text"
        placeholder="Buscar producto" class="border rounded-lg border-gray-700 px-1">
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
                    < </button>
                        <input name="buy_amount" class="border border-gray-700 rounded-lg w-16" type="number" min="0"
                            oninput="maxValue(this)" max="<?php echo $value['amount'] ?>">
                        <button type="button" onclick="nextButtonNumber(this)"
                            class="w-6 h-6 bg-blue-500 text-white font-semibold hover:scale-105 transform transition-all rounded-lg">></button>
            </div>
            <div class="flex flex-wrap justify-between pt-1">
                <p>total:<span class="total_price">0</span><span
                        class="price hidden"><?php echo $value['price'] ?></span>
                </p>
                <button name="buy_button" data-id="<?php echo $value['id'] ?>"
                    data-price="<?php echo $value['price'] ?>" data-amount="<?php echo $value['amount'] ?>"
                    class="bg-blue-500 rounded-lg h-6 px-1 hover:scale-105 transform transition-all">Comprar</button>

            </div>
            <?php if ($_SESSION['user']->rol == "admin"): ?>
            <div class="flex justify-between mt-2">
                <button onclick=" event.preventDefault();showModal('modalDelete','<?php echo $value['id'] ?>')"
                    type="button" class="px-1 h-8 bg-red-500 text-white  rounded-lg hover:bg-red-700">
                    Eliminar
                </button>
                <!-- <button name="createCategory" id="closeModalButton"
                    class="px-1 h-8 bg-green-500 text-white rounded-lg hover:bg-green-700">
                    Editar
                </button> -->
            </div>
            <?php endif; ?>
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
    const buy_button = e.target.buy_button
    const buy_id = buy_button.getAttribute('data-id')
    const buy_price = buy_button.getAttribute('data-price')
    const amount = buy_button.getAttribute('data-amount')
    if (buy_amount == "" || parseInt(buy_amount) == 0) {
        alert('No se ingreso ningun monto')
        return
    }
    const dataUser = {
        amount,
        money: <?php echo $_SESSION['user']->money ?>,
        buy_amount: parseInt(buy_amount),
        buy_id,
        buy_price,
        buy: 'true'
    }
    if (dataUser.money < (buy_price * buy_amount)) {
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
<script>
function deleteProduct() {
    const modal = document.getElementById("modalDelete");
    const idProduct = modal.getAttribute("data-id")
    const dataForm = {
        deleteProduct: false,
        idProduct
    }

    const form = document.createElement('form');
    form.action = '';
    form.method = 'post';
    form.style.display = 'none';
    for (const key in dataForm) {
        if (dataForm.hasOwnProperty(key)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = dataForm[key];
            form.appendChild(input);
        }
    }
    document.body.appendChild(form);
    form.submit()
}

function showModal(idModal, id) {
    const modal = document.getElementById(idModal);
    modal.classList.remove('hidden');
    modal.setAttribute("data-id", id ?? "")
}

function closeModal(idModal) {
    const modal = document.getElementById(idModal);
    modal.classList.add('hidden');

}
</script>
<script>
const imageSelector = document.getElementById('imageSelector');
const imagePreview = document.getElementById('imagePreview');
imageSelector.addEventListener('change', function() {
    const selectedImageUrl = imageSelector.value.split('-')[0];
    if (selectedImageUrl) {
        imagePreview.innerHTML = '';
        const img = new Image();
        img.src = '<?php echo Router::$__public ?>' + selectedImageUrl;
        img.classList.add('w-full', 'h-full', 'object-cover', 'rounded-md');
        imagePreview.appendChild(img);
    }
});
</script>
<script>
function handleCreateSubmit(e) {
    e.preventDefault()
    const name = e.target.name.value
    const price = parseFloat(e.target.price.value)
    const amount = parseInt(e.target.amount.value)
    const img_rute = e.target.img_rute.value.split('-')[1]

    if (name == " " || price == " " || img_rute == " " || amount == " ") {
        alert('No se ingreso nombre o codigo')
        return
    }
    const dataForm = {
        createProduct: false,
        name,
        price,
        amount,
        img_rute,
    }
    const form = document.createElement('form');
    form.action = '';
    form.method = 'post';
    form.style.display = 'none';
    for (const key in dataForm) {
        if (dataForm.hasOwnProperty(key)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = dataForm[key];
            form.appendChild(input);
        }
    }
    document.body.appendChild(form);
    form.submit()
}
</script>
</body>

</html>