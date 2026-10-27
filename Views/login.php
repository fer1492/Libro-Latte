

//<!-- Views/login.php -->


<div id="modal-login" class="modal">
    <button class="close-button">x</button>

    <h3>Inicio de Sesion</h3>

    <form id="form-modal-login" action="index.php?action=login" method="POST">

        <label for="login-email">Email</label>
        <input type="email" id="login-email" name="email" required>

        <label for="login-constrasena">Contraseña</label>
        <input type="password" id="login-constrasena" name="contrasena" required>

        <button type="submit">Iniciar Sesion</button>

    </form>
</div>
