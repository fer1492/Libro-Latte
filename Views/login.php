<!-- Views/login.php -->
<div id="modal-login" class="modal">
    <button class="close-button" type="button">x</button>

    <h3>Inicio de Sesion</h3>

    <form id="form-modal-login" action="Index.php?action=login" method="POST">
        <input type="hidden" name="origen" value="<?= htmlspecialchars($_GET['action'] ?? 'inicio', ENT_QUOTES, 'UTF-8') ?>">

        <label for="login-email">Email</label>
        <input type="email" id="login-email" name="email" required placeholder="tu@correo.com">

        <label for="login-contrasena">Contraseña</label>
        <input type="password" id="login-contrasena" name="contrasena" required placeholder="Tu contraseña">

        <button type="submit">Iniciar Sesion</button>
    </form>
</div>
