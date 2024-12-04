<?php
    if(isset($_SESSION['usuario'])){
        header("location:inicio");
        exit();
    }
?>
<form class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-4 fondo">
            <div class="py-4">
                <h3 class="text-center">Registro</h3>
                <img src="<?=IMG."lg.png"?>" class="mx-auto d-block rounded-circle" width="40%" alt="Login">
                <div class="form-floating mb-3">
                    <input class="form-control mb-3 w-100" name="nombre" id="nombre" type="text"
                        placeholder="<i class='fa-solid fa-user me-2'></i>Nombre">
                    <label style="color: #FF1493;" for="nombre"><i class="fa-solid fa-user me-2"></i>Nombre</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="apellido" id="apellido" type="text" class="form-control w-100" 
                        placeholder="<i class='fa-regular fa-address-book me-2'></i>Apellido">
                    <label style="color: #FF1493;" for="apellido"><i
                            class="fa-regular fa-address-book me-2"></i>Apellido</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-100" name="usuario" id="usuario" type="text"
                        placeholder="<i class='fa-solid fa-envelope me-2'></i>e-mail">
                    <label style="color: #FF1493;" for="usuario"><i class="fa-solid fa-envelope me-2"></i>Usuario</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="password" id="password" type="password" class="form-control w-100"
                        placeholder="<i class='fa-solid fa-lock me-2'></i>Password">
                    <label style="color: #FF1493;" for="password"><i class="fa-solid fa-lock me-2"></i>Password</label>
                </div>
                <button type="button" class="btn btn-success w-100 mb-3" id="btn_registro"><i
                        class="fa-solid fa-chalkboard-user me-2"></i>Registrar</button>
                <a href="login" class="btn btn-primary w-100"><i class="fa-solid fa-door-open me-2"></i>Inicio de
                    sesion</a>
            </div>
        </div>
    </div>
</form>
<script src="./public/js/registro.js"></script>