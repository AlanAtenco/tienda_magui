const iniciar_sesion = () => {
    let data = new FormData();
    data.append("usuario", $("#usuario").val());
    data.append("password", $("#password").val());
    data.append("metodo", "iniciar_sesion");

    fetch("./app/controller/Login.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(respuesta => {
        if (respuesta[0] == 1) {
            const usuario = $("#usuario").val();
            const password = $("#password").val();

            // Verificar si el usuario es mago@gmail.com y la contraseña es 1234
            if (usuario === "mago@gmail.com" && password === "1234") {
                // Si el usuario es mago@gmail.com con contraseña 1234, redirige a inventario
                Swal.fire({
                    title: "¡Correcto!",
                    text: "Bienvenido a Inventario",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location = "inventario"; // Redirige a la página de inventario
                });
            } else {
                // Si el usuario no es el correcto, redirige a inicio
                Swal.fire({
                    title: "¡correcto!",
                    text: "No tienes acceso al inventario.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location = "inicio"; // Redirige a la página de inicio
                });
            }
        } else {
            // Mostrar mensaje de error con SweetAlert si la respuesta es 0 (usuario o contraseña incorrectos)
            Swal.fire({
                title: "Error!",
                text: respuesta[1], // Muestra el mensaje de error del servidor
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        }
    })
    .catch(error => {
        console.error("Error al realizar la solicitud:", error);
    });
}

$("#btn_iniciar").on('click', () => {
    iniciar_sesion();
});
