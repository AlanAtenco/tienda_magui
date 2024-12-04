<?php
require_once '../config/conexion.php';

class Registro extends Conexion {
    public function iniciar_registro() {
        // Verificar que todos los campos están definidos y no están vacíos
        if (isset($_POST['nombre'], $_POST['apellido'], $_POST['usuario'], $_POST['password']) &&
            !empty($_POST['nombre']) && !empty($_POST['apellido']) &&
            !empty($_POST['usuario']) && !empty($_POST['password'])) {
            
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $usuario = trim($_POST['usuario']);
            $password = trim($_POST['password']);

            // Validar que el campo usuario sea un correo electrónico válido
            if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
                echo json_encode([0, "Error: El campo Usuario debe ser un correo electrónico válido."]);
                return;
            }

            // Verificar si el correo ya está registrado
            $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_usuario WHERE usuario = :usuario");
            $consulta->bindParam(":usuario", $usuario);
            $consulta->execute();
            $datos = $consulta->fetch(PDO::FETCH_ASSOC);

            if (!$datos) {
                // Insertar el nuevo usuario
                $insercion = $this->obtener_conexion()->prepare(
                    "INSERT INTO t_usuario (nombre, apellido, usuario, password) VALUES(:nombre, :apellido, :usuario, :password)"
                );
                $insercion->bindParam(":nombre", $nombre);
                $insercion->bindParam(":apellido", $apellido);
                $insercion->bindParam(":usuario", $usuario);
                $pass = password_hash($password, PASSWORD_BCRYPT);
                $insercion->bindParam(":password", $pass);

                if ($insercion->execute()) {
                    echo json_encode([1, "Usuario registrado con éxito."]);
                } else {
                    echo json_encode([0, "Error: No se pudo completar el registro, por favor inténtalo más tarde."]);
                }
            } else {
                echo json_encode([0, "Error: El correo ingresado ya está registrado."]);
            }
        } else {
            echo json_encode([0, "Error: Todos los campos son obligatorios."]);
        }
    }
}

$consulta = new Registro();
$metodo = $_POST['metodo'] ?? null;

if (method_exists($consulta, $metodo)) {
    $consulta->$metodo();
} else {
    echo json_encode([0, "Error: Método no válido."]);
}
?>
