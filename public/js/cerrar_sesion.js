const cerrar_sesion = () => {
    let data = new FormData();
    data.append("metodo", "cerrar_sesion");

    fetch("./app/controller/Login.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(respuesta => {
        Swal.fire({
            title: "¡Sesión cerrada!",
            text: respuesta[1],
            icon: "success",  // Icono de éxito
            confirmButtonText: "Aceptar",  // Botón para aceptar
        }).then(() => {
            window.location = "login";  // Redirige a la página de login
        });
    })
    .catch(error => {
        console.error("Error al cerrar sesión:", error);
    });
}

$("#btn_cerrar").on('click', () => {
    cerrar_sesion();
});
