const iniciar_registro = () => {
    let data = new FormData();
    data.append("nombre", $("#nombre").val().trim());
    data.append("apellido", $("#apellido").val().trim());
    data.append("usuario", $("#usuario").val().trim());
    data.append("password", $("#password").val().trim());
    data.append("metodo", "iniciar_registro");

    fetch("./app/controller/Registro.php", {
        method: "POST",
        body: data,
    })
        .then((respuesta) => respuesta.json())
        .then((respuesta) => {
            if (respuesta[0] == 1) {
                Swal.fire({
                    icon: "success",
                    title: "Registro Exitoso",
                    text: respuesta[1],
                    confirmButtonText: "OK",
                }).then(() => {
                    window.location = "login";
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: respuesta[1],
                    confirmButtonText: "Intentar de nuevo",
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Ocurrió un problema al procesar la solicitud. Inténtalo más tarde.",
                confirmButtonText: "Entendido",
            });
        });
};

const validarCorreo = (correo) => {
    const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar correos electrónicos
    return regexCorreo.test(correo);
};

$("#btn_registro").on("click", () => {
    const correo = $("#usuario").val().trim();

    if (!validarCorreo(correo)) {
        Swal.fire({
            icon: "warning",
            title: "Correo Inválido",
            text: "Por favor, ingresa un correo electrónico válido en el campo Usuario.",
            confirmButtonText: "Entendido",
        });
        return;
    }

    iniciar_registro();
});
