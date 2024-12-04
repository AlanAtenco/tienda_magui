<?php
    if(isset($_SESSION['usuario'])){
        header("location:inventario");
        exit();
    }
?>
<form id="frm_login" class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-4 fondo">
            <div class="py-4">
                <h2 class="text-center">Login</h2>
                <img src="<?=IMG."lg.png"?>" class="mx-auto d-block rounded-circle" width="40%" alt="Login">
                <div class="form-floating mb-3">
                    <input class="form-control w-100" id="usuario" name="usuario" type="text"
                        placeholder="<i class='fa-solid fa-envelope me-2'></i>e-mail">
                    <label style="color: #FF1493;" for="usuario"><i class="fa-solid fa-envelope me-2"></i>Usuario</label>
                </div>
                <div class="form-floating mb-3">
                    <input id="password" name="password" type="password" class="form-control w-100"
                        placeholder="<i class='fa-solid fa-lock me-2'></i>Password">
                    <label style="color: #FF1493;" for="password"><i class="fa-solid fa-lock me-2"></i>Password</label>
                </div>
                <button class="btn btn-primary w-100 mb-3" type="button" id="btn_iniciar"><i
                        class="fa-solid fa-door-open me-2"></i>Iniciar sesión</button>
                <a href="registro" class="btn btn-success w-100 mb-3"><i
                        class="fa-solid fa-chalkboard-user me-2"></i>Registro</a>
            </div>
        </div>
    </div>
</form>
<script src="./public/js/login.js"></script>
