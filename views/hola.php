<?php
// Ruta del archivo JSON donde se almacenarán los productos
$filePath = 'productos.json';

// Verifica si el archivo JSON existe, si no, lo crea con un array vacío
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([]));
}

// Procesar las solicitudes del frontend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'];
    $productos = json_decode(file_get_contents($filePath), true);

    if ($action === 'add') {
        $nuevoProducto = [
            'id' => uniqid(),
            'nombre' => $data['nombre'],
            'precio' => $data['precio'],
            'url' => $data['url']
        ];
        $productos[] = $nuevoProducto;
        file_put_contents($filePath, json_encode($productos));
        echo json_encode(['success' => true, 'product' => $nuevoProducto]);
    } elseif ($action === 'edit') {
        foreach ($productos as &$producto) {
            if ($producto['id'] === $data['id']) {
                $producto['nombre'] = $data['nombre'];
                $producto['precio'] = $data['precio'];
                $producto['url'] = $data['url'];
                break;
            }
        }
        file_put_contents($filePath, json_encode($productos));
        echo json_encode(['success' => true]);
    } elseif ($action === 'delete') {
        $productos = array_filter($productos, fn($producto) => $producto['id'] !== $data['id']);
        file_put_contents($filePath, json_encode($productos));
        echo json_encode(['success' => true]);
    }
    exit;
}

// Obtener los productos desde el archivo JSON
$productos = json_decode(file_get_contents($filePath), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS.'caballero.css'?>">
    <title>Productos</title>
    <style>
        /* Aquí va tu CSS si lo necesitas */
    </style>
</head>
<body>
<section class="main-content">
    <div class="container">
        <h1 class="section-title" style="color:black">Productos de caballero</h1>

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador'): ?>
            <div class="admin-buttons">
                <button class="btn-action" id="btn-agregar">Agregar Producto</button>
            </div>
        <?php endif; ?>

        <div class="cards-container" id="cards-container">
            <?php foreach ($productos as $producto): ?>
                <div class="card" data-id="<?= $producto['id'] ?>">
                    <img src="<?= $producto['url'] ?>" alt="<?= $producto['nombre'] ?>" class="card-image">
                    <div class="card-info">
                        <p class="product-name"><?= $producto['nombre'] ?></p>
                        <p class="product-price">$<?= $producto['precio'] ?></p>

                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente'): ?>
                            <button class="btn-action">Comprar</button>
                        <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador'): ?>
                            <button class="btn-action" onclick="abrirModalEditar(this)">Editar</button>
                            <button class="btn-action" onclick="eliminarProducto(this)">Eliminar</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div id="modal-form" style="display:none;">
    <div class="modal-content">
        <h2>Agregar/Editar Producto</h2>
        <label for="product-name">Nombre del Producto:</label>
        <input type="text" id="product-name" placeholder="Nombre del producto">
        
        <label for="product-price">Precio:</label>
        <input type="number" id="product-price" placeholder="Precio del producto">

        <label for="product-url">URL Imagen:</label>
        <input type="text" id="product-url" placeholder="URL de la imagen">

        <div class="modal-actions">
            <button id="submit-product" class="btn-submit">Guardar</button>
            <button id="cancel-product" class="btn-cancel">Cancelar</button>
        </div>
    </div>
</div>

<script>
    // Función para abrir el modal de agregar producto
    document.getElementById("btn-agregar").addEventListener("click", function () {
        document.getElementById("product-name").value = "";
        document.getElementById("product-price").value = "";
        document.getElementById("product-url").value = "";
        document.getElementById("modal-form").style.display = "flex"; // Muestra el modal
        
        // Establecer el evento de 'Guardar' dentro del modal para agregar producto
        document.getElementById("submit-product").onclick = async function () {
            let nombre = document.getElementById("product-name").value;
            let precio = document.getElementById("product-price").value;
            let url = document.getElementById("product-url").value;

            if (nombre && precio && url) {
                // Realiza la solicitud para agregar el nuevo producto al backend
                const response = await fetch("", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ action: "add", nombre, precio, url })
                });

                // const result = await response.json();
                location.reload();
                /*
                if (result.success) {
                    // Crear el nuevo producto dinámicamente en el DOM
                    const nuevoProducto = result.product;
                    const productoCard = document.createElement('div');
                    productoCard.classList.add('card');
                    productoCard.dataset.id = nuevoProducto.id;
                    
                    productoCard.innerHTML = `
                        <img src="${nuevoProducto.url}" alt="${nuevoProducto.nombre}" class="card-image">
                        <div class="card-info">
                            <p class="product-name">${nuevoProducto.nombre}</p>
                            <p class="product-price">$${nuevoProducto.precio}</p>
                            <button class="btn-action" onclick="abrirModalEditar(this)">Editar</button>
                            <button class="btn-action" onclick="eliminarProducto(this)">Eliminar</button>
                        </div>
                    `;

                    // Agregar el nuevo producto a la interfaz sin recargar la página
                    document.getElementById("cards-container").appendChild(productoCard);

                    // Cerrar el modal después de agregar el producto
                    document.getElementById("modal-form").style.display = "none";
                }*/
            }
        };
    });

    // Función para cancelar la acción y cerrar el modal
    document.getElementById("cancel-product").addEventListener("click", function () {
        document.getElementById("modal-form").style.display = "none"; // Cerrar el modal
    });

    // Función para abrir el modal de editar producto
    function abrirModalEditar(button) {
        const card = button.closest(".card");
        const id = card.dataset.id;
        const name = card.querySelector(".product-name").innerText;
        const price = card.querySelector(".product-price").innerText.replace("$", "");
        const url = card.querySelector(".card-image").src;

        document.getElementById("product-name").value = name;
        document.getElementById("product-price").value = price;
        document.getElementById("product-url").value = url;
        document.getElementById("modal-form").style.display = "flex";

        document.getElementById("submit-product").onclick = async function () {
            const nombre = document.getElementById("product-name").value;
            const precio = document.getElementById("product-price").value;
            const url = document.getElementById("product-url").value;

            if (nombre && precio && url) {
                const response = await fetch("", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ action: "edit", id, nombre, precio, url })
                });
                location.reload();
                // const result = await response.json();

                // if (result.success) {
                //     // Actualizar el producto en el DOM sin recargar la página
                //     const card = document.querySelector(`[data-id="${id}"]`);
                //     card.querySelector(".product-name").innerText = nombre;
                //     card.querySelector(".product-price").innerText = `$${precio}`;
                //     card.querySelector(".card-image").src = url;

                //     // Cerrar el modal después de editar
                //     document.getElementById("modal-form").style.display = "none";
                // }
            }
        };
    }

    // Función para eliminar producto
    async function eliminarProducto(button) {
        const card = button.closest(".card");
        const id = card.dataset.id;

        const response = await fetch("", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "delete", id })
        });
        location.reload();
        // const result = await response.json();
        // if (result.success) {
        //     // Eliminar el producto del DOM sin recargar
        //     card.remove();
        // }
    }
</script>
</body>
</html>
