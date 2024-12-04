<?php
require_once '../config/conexion.php';
session_start();

class Login extends Conexion {
    private function crear_sesion($datos, $rol) {
        $_SESSION['usuario'] = $datos;
        $_SESSION['rol'] = $rol; // Almacenamos el rol en la sesión
    }

    public function cerrar_sesion() {
        session_unset();
        session_destroy();
        echo json_encode([1, "Sesión finalizada!"]);
    }

    public function iniciar_sesion() {
        // Verificar que los campos 'usuario' y 'password' estén definidos y no estén vacíos
        if (isset($_POST['usuario'], $_POST['password']) && !empty($_POST['usuario']) && !empty($_POST['password'])) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_usuario WHERE usuario = :usuario");
            $consulta->bindParam(":usuario", $usuario);
            $consulta->execute();
            $datos = $consulta->fetch(PDO::FETCH_ASSOC);

            if ($datos) {
                if (password_verify($password, $datos['password'])) {
                    // Verificamos si el usuario es el administrador (mago@gmail.com y contraseña 1234)
                    if ($usuario === 'mago@gmail.com' && $password === '1234') {
                        $rol = 'administrador'; // Asignamos el rol de administrador
                    } else {
                        $rol = 'cliente'; // Cualquier otro usuario es un cliente
                    }

                    // Creamos la sesión con los datos y el rol
                    $this->crear_sesion($datos, $rol);
                    echo json_encode([1, "Sesión iniciada como $rol!"]);
                } else {
                    echo json_encode([0, "Error en credenciales de acceso!"]);
                }
            } else {
                echo json_encode([0, "Error al buscar información!"]);
            }
        } else {
            echo json_encode([0, "Error: Todos los campos son obligatorios!"]);
        }
    }
}

$consulta = new Login();
$metodo = $_POST['metodo'];
$consulta->$metodo();
?>
