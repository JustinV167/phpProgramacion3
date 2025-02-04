<?php
include_once(__DIR__ . "/../template/header.php");
?>
<div class="flex w-full my-4 text-3xl justify-center">
    <p class> Categorias</p>
</div>
<?php if ($_SESSION['user']->rol == "admin"): ?>
<button onclick="showModal('modalCreate')" id="openModalButton"
    class="bg-blue-500 text-white mx-6 sm:mx-10 px-4  h-7 rounded-lg hover:bg-blue-700">
    Crear Categoria
</button>
<div id="modalCreate" onclick="closeModal('modalCreate')"
    class="fixed z-10 inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <form onclick="return event.stopPropagation();" onsubmit="return handleSubmit(event);"
        class="bg-white p-8 rounded-lg w-96 flex justify-center flex-col items-center">
        <h2 class="text-xl font-bold mb-4">Crear Categoria</h2>
        <div>

            <p class="text-gray-600"><strong>Nombre:</strong></p>
            <input name="name" required class="border border-gray-600 rounded-lg h-7">
        </div>
        <div>

            <p class="text-gray-600"><strong>Codigo:</strong></p>
            <input class="border border-gray-600 rounded-lg h-7" required name="code">
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
        <h2 class="text-xl font-bold mb-4 text-center">¿Estás seguro de borrar esta Categoria?</h2>
        <div class="flex gap-4">
            <button onclick="closeModal('modalDelete')" type="button" id="closeModalButton"
                class="px-1 h-8 bg-red-500 text-white my-2  rounded-lg hover:bg-red-700">
                Volver
            </button>
            <button name="createCategory" onclick="deleteCategory()" id="closeModalButton"
                class="px-1 h-8 bg-green-500 text-white my-2 rounded-lg hover:bg-green-700">
                Eliminar
            </button>
        </div>
    </div>
</div>

<?php endif; ?>
<form class="flex w-full my-4 px-6 sm:px-10  ">
    <input value="<?php echo $categoryController->searchCategory ?>" name="searchCategory" type="text"
        placeholder="Buscar categoria" class="border rounded-lg border-gray-700 px-1">
    <button class="h-7 w-7 hover:bg-blue-500 flex justify-center items-center bg-blue-400 rounded-lg mx-1">
        <img src="<?php echo Router::$__public ?>icons/search.svg">
    </button>
</form>
<div class="flex flex-wrap w-full gap-4 px-10 justify-center sm:justify-start">

    <?php
    $data = $categoryController->get_category_by_submit();
    if (count($data->data) == 0) {
        echo 'no hay categorias';
    } else {

        foreach ($data->data as $key => $value) { ?>
    <a href='<?php echo Router::$__root . 'category/products/' . $value['id'] ?>'
        class=' w-52 flex flex-col border border-blue-400 rounded-xl cursor-pointer hover:scale-105 transform transition-all '>
        <div class="bg-blue-200 rounded-t-xl py-2 pb-0 flex flex-col items-center ">
            <img class='w-48 h-36 rounded-xl  border border-blue-400 rounded-xl'
                src='<?php echo Router::$__public . $value['img_rute'] ?>'></img>
            <p class="font-semibold nrom"><?php echo $value['name'] ?></p>
        </div>
        <div class="bg-gray-200 rounded-b-xl flex-1 px-2 py-1  border-t border-blue-400">
            <p>n° de productos: <?php echo $value['n_products'] ?></p>
            <?php if ($_SESSION['user']->rol == "admin"): ?>
            <div class="flex justify-between">
                <button onclick=" event.preventDefault();showModal('modalDelete','<?php echo $value['id'] ?>')"
                    type="button" class="px-1 h-8 bg-red-500 text-white  rounded-lg hover:bg-red-700">
                    Eliminar
                </button>

            </div>
            <?php endif; ?>

        </div>

    </a>

    <?php }
    } ?>
</div>


<script>
function deleteCategory() {
    const modal = document.getElementById("modalDelete");
    const idCategory = modal.getAttribute("data-id")
    const dataForm = {
        deleteCategory: false,
        idCategory
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
function handleSubmit(e) {
    e.preventDefault()
    const category_name = e.target.name.value
    const category_code = e.target.code.value
    const category_img_rute = e.target.img_rute.value.split('-')[1]

    if (category_name == " " || category_code == " ") {
        alert('No se ingreso nombre o codigo')
        return
    }
    const dataForm = {
        createCategory: false,
        category_name,
        category_code,
        category_img_rute
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

<
/body>

<
/html>