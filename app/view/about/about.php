
<?php
include_once(__DIR__."/../template/header.php");
?>
   
    
    <main class="p-4">
        <div class="relative w-full h-64">
            <img src="<?php echo Router::$__public ?>img/contraportada.jpg" alt="Nuestra Empresa" class="w-full h-full object-cover rounded-lg">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <h2 class="text-3xl font-semibold text-white text-center">Comprometidos con la calidad y el servicio excepcional.</h2>
            </div>
        </div>
        
        <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800">Nuestra Historia</h3>
            <p class="text-gray-600 mt-2">Desde nuestros inicios, nos hemos dedicado a ofrecer productos frescos y de alta calidad a nuestros clientes. Con más de 20 años de experiencia en el sector, hemos crecido gracias a la confianza de nuestra comunidad.</p>
        </div>
        
        <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800">Nuestra Misión</h3>
            <p class="text-gray-600 mt-2">Brindar a nuestros clientes la mejor experiencia de compra, con productos frescos, precios competitivos y un servicio al cliente excepcional.</p>
        </div>
        
        <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800">Nuestros Valores</h3>
            <ul class="text-gray-600 mt-2 list-disc pl-6">
                <li>Calidad en cada producto</li>
                <li>Compromiso con nuestros clientes</li>
                <li>Innovación y mejora constante</li>
                <li>Responsabilidad social y ambiental</li>
            </ul>
        </div>
    </main>
</body>
</html>