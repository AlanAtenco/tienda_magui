<?php 
$sesionIniciada = isset($_SESSION['usuario']); 

// Array con las rutas de las imágenes
$imagenes = [
    '../public/img/shein.png',
    '../public/img/mercado.png',
    '../public/img/prices.jpg',
    '../public/img/ramo.jpg',
    '../public/img/papeleria.jpg',
    '../public/img/peluches.jpg',
    '../public/img/jugetes.jpg',
    '../public/img/dulces.jpg',
    '../public/img/tazas.jpg',
];

// Array con las transcripciones
$transcripciones = [
    'En regalos magui realizamos pedidos de shein sin costo extra',
    'Realizamos pedidos en plataformas digitales como mercado libre',
    'Realizamos pedidos de price shoes',
    'Elaboramos ramos y arreglos de dulces para alguna persona especial',
    'Contamos con la venta de algunos utiles escolares como por ejemplo: lapiz,goma,resisto,plumas,etc..',
    'Tenemos a la venta peluches para alguna ocacion especial',
    'Tenemos a la venta articulos de jugueteria para los pequeños de la casa',
    'Contamos con la venta de algunos dulces y caramelos',
    'Contamos con la venta de algunas tazas con diferentes diseños',
];
?>


<div class="container mt-5">
        <div class="row">
            <?php for ($i = 0; $i < 9; $i++): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-inner">
                            <!-- Parte Frontal: Solo la imagen -->
                            <div class="card-front" style="background-image: url('images/<?php echo $imagenes[$i]; ?>');">
                            </div>
                            <!-- Parte Trasera: Contiene la transcripción -->
                            <div class="card-back">
                                <p><?php echo $transcripciones[$i]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
</div>

