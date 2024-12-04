// Llamada inicial para obtener los productos
const consulta = () => {
    let data = new FormData();
    data.append("metodo", "obtener_datos");
    fetch("./app/controller/Productos.php", {
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        let contenido = ``, i = 1;
        respuesta.map(producto => {
            contenido += `
                <tr>
                    <th>${i++}</th>
                    <td>${producto['producto']}</td>
                    <td>${producto['precio']}</td>
                    <td>${producto['unidades']}</td>
                    <td>
                        <button type="button" class="btn btn-warning" onclick="precargar(${producto['id_producto']})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-danger" onclick="eliminar(${producto['id_producto']})"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            `;
        });
        $("#contenido_producto").html(contenido);
        $('#myTable').DataTable();
    });
};

// Limpiar el modal de añadir producto cuando se abre
$('#agregarModal').on('show.bs.modal', function () {
    $("#producto").val('');
    $("#precio").val('');
    $("#unidades").val('');
});

// Precargar los datos del producto en el modal de edición
const precargar = (id) => {
    let data = new FormData();
    data.append("id_producto", id);
    data.append("metodo", "precargar_datos");
    fetch("./app/controller/Productos.php", {
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        $("#edit_producto").val(respuesta['producto']);
        $("#edit_precio").val(respuesta['precio']);
        $("#edit_unidades").val(respuesta['unidades']);
        $("#id_prodcuto_act").val(respuesta['id_producto']);
        $("#editarModal").modal('show');
    });
};

// Validar campos antes de agregar un producto
const validarCampos = () => {
    let producto = $("#producto").val();
    let precio = $("#precio").val();
    let unidades = $("#unidades").val();

    if (!producto || !precio || !unidades) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Todos los campos son obligatorios',
        });
        return false;
    }
    return true;
};

// Validar campos antes de actualizar un producto
const validarCamposEditar = () => {
    let producto = $("#edit_producto").val();
    let precio = $("#edit_precio").val();
    let unidades = $("#edit_unidades").val();

    if (!producto || !precio || !unidades) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Todos los campos son obligatorios',
        });
        return false;
    }
    return true;
};

// Actualizar producto
const actualizar = () => {
    if (validarCamposEditar()) {  // Verifica si todos los campos están llenos
        let data = new FormData();
        data.append("id_producto", $("#id_prodcuto_act").val());
        data.append("producto", $("#edit_producto").val());
        data.append("precio", $("#edit_precio").val());
        data.append("unidades", $("#edit_unidades").val());
        data.append("metodo", "actualizar_datos");
        fetch("./app/controller/Productos.php", {
            method: "POST",
            body: data
        }).then(respuesta => respuesta.json())
        .then(respuesta => {
            if (respuesta[0] == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: respuesta[1],
                });
                consulta();
                $("#editarModal").modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta[1],
                });
            }
        });
    }
};

// Agregar nuevo producto
const agregar = () => {
    if (validarCampos()) {  // Verifica si todos los campos están llenos
        let data = new FormData();
        data.append("producto", $("#producto").val());
        data.append("precio", $("#precio").val());
        data.append("unidades", $("#unidades").val());
        data.append("metodo", "insertar_datos");
        fetch("./app/controller/Productos.php", {
            method: "POST",
            body: data
        }).then(respuesta => respuesta.json())
        .then(respuesta => {
            if (respuesta[0] == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: respuesta[1],
                });
                consulta();
                $("#agregarModal").modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta[1],
                });
            }
        });
    }
};

// Eliminar producto
const eliminar = (id) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este producto será eliminado.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            let data = new FormData();
            data.append("id_producto", id);
            data.append("metodo", "eliminar_datos");
            fetch("./app/controller/Productos.php", {
                method: "POST",
                body: data
            }).then(respuesta => respuesta.json())
            .then(respuesta => {
                if (respuesta[0] == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Producto eliminado',
                        text: respuesta[1],
                    });
                    consulta();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta[1],
                    });
                }
            });
        }
    });
};

$(document).ready(() => {
    consulta();
    $('#btn_agregar').click(agregar);
    $('#btn_actualizar').click(actualizar);
});
