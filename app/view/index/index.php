
<?php
include_once(__DIR__."/../template/header.php");
?>
 
    
    <main class="">
        <div class="relative w-full h-96">
            <img src="<?php echo Router::$__public ?>img/portada.svg" alt="Supermercado" class="w-full h-96 object-cover rounded-lg">
            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-end justify-end pb-4">
                <h2 class="text-3xl font-semibold text-white text-end">Encuentra los mejores productos frescos, ofertas exclusivas y un servicio de entrega confiable.</h2>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-4 pb-8 mt-6">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-bold">Categorías Populares</h3>
                <ul class="text-gray-600 mt-2">
                    <li>- Frutas y Verduras</li>
                    <li>- Lácteos y Huevos</li>
                    <li>- Carnes y Pescados</li>
                    <li>- Panadería</li>
                    <li>- Bebidas y Refrescos</li>
                    <li>- Limpieza y Hogar</li>
                </ul>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-bold">Beneficios de Comprar con Nosotros</h3>
                <ul class="text-gray-600 mt-2">
                    <li>- Entrega rápida y segura</li>
                    <li>- Ofertas exclusivas cada semana</li>
                    <li>- Variedad y calidad garantizada</li>
                    <li>- Atención al cliente 24/7</li>
                    <li>- Pago seguro en línea</li>
                    <li>- Devoluciones fáciles</li>
                </ul>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-bold">Información Adicional</h3>
                <ul class="text-gray-600 mt-2">
                    <li>- Horarios de atención: 8 AM - 10 PM</li>
                    <li>- Contacto: soporte@supermercado.com</li>
                    <li>- Teléfono: +123 456 7890</li>
                    <li>- Ubicación: Av. Principal 123, Ciudad</li>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>